<?php
// Copyright Amazon.com, Inc. or its affiliates. All Rights Reserved.
// SPDX-License-Identifier: Apache-2.0

/*
 *  ABOUT THIS PHP SAMPLE: This sample is part of the Elastic Transcoder Developer Guide topic at
 *  https://docs.aws.amazon.com/elastictranscoder/latest/developerguide/introduction.html
 *
 */
// snippet-start:[elastictranscoder.php.create_job_status_notification_handler.import]
$tmp_path = '/tmp';

# Get raw notification data from the POST.
$data = file_get_contents('php://input');
$notification = json_decode($data, true);

if ($notification['Type'] == 'SubscriptionConfirmation') {
  $subscription_file = "$tmp_path/subscribe_requests.txt";

  # Dump subscription request into temp file.
  file_put_contents($subscription_file, "$data\n", FILE_APPEND | LOCK_EX);
  try {
    # Automatically handle subscription confirmation requests.
    echo 'url: ', $notification['SubscribeURL'];
    $response = file_get_contents($notification['SubscribeURL']);
    file_put_contents($subscription_file, "$response\n", FILE_APPEND | LOCK_EX);
  } catch (Exception $e) {
    file_put_contents($subscription_file, "Error confirming subscription: {$e->getMessage()}\n", FILE_APPEND | LOCK_EX);
  }
} else if ($notification['Type'] == 'Notification') {
  # Handle Elastic Transcoder notifications.  In this example, we write them to
  # $tmp_path/<job-id>.
  $job_status = json_decode($notification['Message'], true);
  file_put_contents("$tmp_path/{$job_status['jobId']}", json_encode($job_status) . "\n", FILE_APPEND |  LOCK_EX);
} else {
  # Write unknown notifications out to disk.
  file_put_contents("$tmp_path/unknown_notification.txt", "$data\n", FILE_APPEND | LOCK_EX);
}
// snippet-end:[elastictranscoder.php.create_job_status_notification_handler.import]

?>
