<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require '../vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

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

  $httpAdapter = new Guzzle6HttpAdapter(new Client());
  $sparky = new SparkPost($httpAdapter, ['key'=>getenv('SPARKPOST_API_KEY')]);

  try {
    // Build your email and send it!
    $results = $sparky->transmission->send([
      'from'=>'PiggyPennies <hello@piggy.aws-cloud.oweb.co>',
      'html'=>"<html><body><h1>Great job, {{name}}!</h1><p>You're now {{amount}} closer to your group's goal of {{goal}}! Keep up the good work!</p></body></html>",
      'text'=>"Great job, {{name}}! You're now {{amount}} closer to your group's goal of {{goal}}! Keep up the good work!",
      'substitutionData'=>['name'=>'Recipient', 'amount'=>'$20', 'goal'=>'$500'],
      'subject'=> $subject,
      'recipients'=>[
        [
          'address'=>[
            'name'=>'Recipient',
            'email'=> $to
          ]
        ]
      ]
    ]);
    echo 'Woohoo! You just sent your first mailing!';
  } catch (\Exception $err) {
    echo 'Whoops! Something went wrong';
    var_dump($err);
  }

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
