<?php

$rootPath = dirname(__DIR__);

// The autoloader
require $rootPath .'/vendor/autoload.php';

use Nortic\BruteForceProtection;

// Parameters.
$params = include $rootPath .'/config/params.php';

// BruteForceProtection
$iteratorStorage = new BruteForceProtection\IteratorStorage\File($rootPath .'/data/brute_force_protection_iterate');
$bruteForceProtectionFactory = new BruteForceProtection\CoreFactory;
$bruteForceProtection = $bruteForceProtectionFactory->create(array(
    'enabled' => true,
    'protectors' => array(
        new BruteForceProtection\Protector\LimitLoginAttempts($params['brute-force-protection']['limit-login-attempts']['max-retry'], $iteratorStorage)
    )
));


