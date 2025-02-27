<?php
// Copyright Amazon.com, Inc. or its affiliates. All Rights Reserved.
// SPDX-License-Identifier: Apache-2.0

/**
 *  ABOUT THIS PHP SAMPLE: This sample is part of the SDK for PHP Developer Guide topic at
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/iam-examples-working-with-policies.html
 *
 */
// snippet-start:[cognito.php.user_pool.create_user_pool.complete]
// snippet-start:[cognito.php.user_pool.create_user_pool.import]

require 'vendor/autoload.php';

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Exception\AwsException;

// snippet-end:[cognito.php.user_pool.create_user_pool.import]

/**
 * Creates a new User Pool Client for your AWS account.
 *
 * This code expects that you have AWS credentials set up per:
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html
 */

 // snippet-start:[cognito.php.user_pool.create_user_pool.main]
 
$client = new CognitoIdentityProviderClient([
    'profile' => 'default',
    'region' => 'us-east-2',
    'version' => '2016-04-18'
]);

$userPoolName = "PHP_SDK_test_user_pool";

try {
    $result = $client->createUserPool([
        'PoolName' => $userPoolName, 
    ]);
    echo $result["UserPool"]["Id"] . "\n";
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage() . "\n";
    error_log($e->getMessage());
}

// snippet-end:[cognito.php.user_pool.create_user_pool.main]
// snippet-end:[cognito.php.user_pool.create_user_pool.complete]
// snippet-sourceauthor:[jschwarzwalder (AWS)]