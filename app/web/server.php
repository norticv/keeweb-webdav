<?php

$rootPath = dirname(__DIR__);

// The autoloader
require $rootPath .'/vendor/autoload.php';

use Sabre\DAV;
use Sabre\HTTP\RequestInterface;
use Sabre\HTTP\ResponseInterface;
use Nortic\BruteForceProtection;

// Parameters.
$params = include $rootPath .'/config/params.php';

// Now we're creating a whole bunch of objects
$rootDirectory = new DAV\FS\Directory($rootPath .'/files');

// The server object is responsible for making sense out of the WebDAV protocol
$server = new DAV\Server($rootDirectory);

// If your server is not on your webroot, make sure the following line has the
// correct information
$server->setBaseUri($params['base-uri']);

// The lock manager is reponsible for making sure users don't overwrite
// each others changes.
$lockBackend = new DAV\Locks\Backend\File($rootPath .'/data/locks');
$lockPlugin = new DAV\Locks\Plugin($lockBackend);

// BruteForceProtection
$iteratorStorage = new BruteForceProtection\IteratorStorage\File($rootPath .'/data/brute_force_protection_iterate');

$bruteForceProtectionFactory = new BruteForceProtection\CoreFactory;
$bruteForceProtection = $bruteForceProtectionFactory->create(array(
    'enabled' => true,
    'protectors' => array(
        new BruteForceProtection\Protector\LimitLoginAttempts($params['brute-force-protection']['limit-login-attempts']['max-retry'], $iteratorStorage)
    )
));

$authBackend = new BruteForceProtection\SabreDavBackend\BasicCallBack($bruteForceProtection, function($username, $password) use ($params) {

    if ($username == $params['auth']['username'] 
            && $password == $params['auth']['password']) {

        return true;
    }

    return false;
});

// Keeweb
$server->on('method:GET', function(RequestInterface $request, ResponseInterface $response) use ($rootPath) {

    if ( ! $request->getPath()) {
        include $rootPath .'/keeweb.html';
        exit;
    }
}, 0);

// Add plugins
$server->addPlugin($lockPlugin);
$server->addPlugin(new DAV\Auth\Plugin($authBackend));
$server->addPlugin(new DAV\Browser\Plugin());
$server->exec();
