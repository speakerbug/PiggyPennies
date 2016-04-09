<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$inputJSON = file_get_contents('php://input');
$messages = json_decode( $inputJSON, TRUE );

function print_line($message) {
  echo $message . "<br>";
}

function transfer_money($message) {
  // do the Capital One transfer API here
  return true;
}

function send_response($message) {
  $to      = $message["msg_from"];
  $subject = 'Re: ' . $message["content"]["subject"];
  $content = "Success! We've made your transfer.";
  $headers = 'From: hello@piggy.aws-cloud.oweb.co' . "\r\n" .
      'Reply-To: hello@piggy.aws-cloud.oweb.co' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $content, $headers);
}

foreach ($messages as $message) {
  $message = $message["msys"]["relay_message"];
  print_line("New message from: " . $message["friendly_from"]);
  print_line("To: " . $message["rcpt_to"]);

  if (transfer_money($message)) {
    send_response($message);
  } else {
    echo "Failed";
  }
}

?>
