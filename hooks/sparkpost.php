<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$inputJSON = file_get_contents('php://input');
$messages = json_decode( $inputJSON, TRUE );

function print_line($message) {
  echo $message . "<br>";
}

foreach ($messages as $message) {
  $message = $message["msys"]["relay_event"];
  print_line("New message from: " . $message["msg_from"]);
  print_line("To: " . $message["rcpt_to"]);
  mail($message["msg_from"], "Received", "hello");
}

?>
