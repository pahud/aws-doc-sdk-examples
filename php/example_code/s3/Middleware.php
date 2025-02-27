<?php
// Copyright Amazon.com, Inc. or its affiliates. All Rights Reserved.
// SPDX-License-Identifier: Apache-2.0

/*
 * ABOUT THIS PHP SAMPLE: This sample is part of the SDK for PHP Developer Guide topic at
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_commands.html
 *
 */
// snippet-start:[s3.php.middleware.complete]
// snippet-start:[s3.php.middleware.import]
use Aws\CommandInterface;
use Aws\Middleware;
use Psr\Http\Message\RequestInterface;
// snippet-end:[s3.php.middleware.import]
/**
 * Use Middleware to list files in an Amazon S3 bucket.
 *
 * This code expects that you have AWS credentials set up per:
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html
 */
// Create the client
// snippet-start:[s3.php.middleware.main] 
$command = $s3Client->getCommand('ListObjects');
$list = $command->getHandlerList();

// Create a middleware that just dumps the command and request that is
// about to be sent
$middleware = Middleware::tap(
    function (CommandInterface $command, RequestInterface $request) {
        var_dump($command->toArray());
        var_dump($request);
    }
);

// Append the middleware to the "sign" step of the handler list. The sign
// step is the last step before transferring an HTTP request.
$list->append('sign', $middleware);

// Now transfer the command and see the var_dump data
$s3Client->execute($command);
// snippet-end:[s3.php.middleware.main]
// snippet-end:[s3.php.middleware.complete]
// snippet-sourceauthor:[jschwarzwalder (AWS)]