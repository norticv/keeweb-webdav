<?php

    use Sabre\DAV;
    use Nortic;

    // The autoloader
    require 'vendor/autoload.php';

    // Parameters.
    $params = include '/params.php';

    // Now we're creating a whole bunch of objects
    $rootDirectory = new DAV\FS\Directory('files');

    // The server object is responsible for making sense out of the WebDAV protocol
    $server = new DAV\Server($rootDirectory);

    // If your server is not on your webroot, make sure the following line has the
    // correct information
    $server->setBaseUri($params['base-uri']);

    // The lock manager is reponsible for making sure users don't overwrite
    // each others changes.
    $lockBackend = new DAV\Locks\Backend\File('data/locks');
    $lockPlugin = new DAV\Locks\Plugin($lockBackend);
    $server->addPlugin($lockPlugin);

    // Add BruteForceProtection
    $iteratorStorage = new Nortic\BruteForceProtection\IteratorStorage\File(dirname(__FILE__) .'/data/brute_force_protection_iterate');

    $bruteForceProtectionFactory = new Nortic\BruteForceProtection\CoreFactory;
    $bruteForceProtection = $bruteForceProtectionFactory->create(array(
        'enabled' => true,
        'protectors' => array(
            new Nortic\BruteForceProtection\Protector\LimitLoginAttempts($params['brute-force-protection']['limit-login-attempts']['max-retry'], $iteratorStorage)
        )
    ));

    // AuthPlugin
    $authBackend = new DAV\Auth\Backend\BasicCallBack(function($username, $password) use ($params) {

        if ($username == $params['auth']['username'] && $password == $params['auth']['password'])
            return true;
        return false;
    });

    $server->addPlugin(new Nortic\Sabre\AuthPlugin($authBackend, $bruteForceProtection));

    // This ensures that we get a pretty index in the browser, but it is
    // optional.
    $server->addPlugin(new DAV\Browser\Plugin());

    // All we need to do now, is to fire up the server
    $server->exec();
