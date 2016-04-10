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

  $amount_regex = "/Transfer \$(\d{0,10}(\.\d{0,2})?)/";
  if (preg_match($amount_regex, $message["content"]["html"], $matches)) {
    $amount = "$" . $matches[1];
  } else {
    $amount = "$20";
  }

  $httpAdapter = new Guzzle6HttpAdapter(new Client());
  $sparky = new SparkPost($httpAdapter, ['key'=>getenv('SPARKPOST_API_KEY')]);

  try {
    // Build your email and send it!
    // $results = $sparky->transmission->send([
    //   'from'=>'PiggyPennies <hello@piggy.aws-cloud.oweb.co>',
    //   'html'=>"<html><body><h1>Great job, {{name}}!</h1><p>You're now {{amount}} closer to your group's goal of {{goal}}! Keep up the good work!</p></body></html>",
    //   'text'=>"Great job, {{name}}! You're now {{amount}} closer to your group's goal of {{goal}}! Keep up the good work!",
    //   'substitutionData'=>['name'=>'Recipient', 'amount'=>'$20', 'goal'=>'$500'],
    //   'inline_css'=> true,
    //   'subject'=> $subject,
    //   'recipients'=>[
    //     [
    //       'address'=>[
    //         'name'=>'Recipient',
    //         'email'=> $to
    //       ]
    //     ]
    //   ]
    // ]);
    $results = $sparky->transmission->send([
      "campaign_id" => "postman_metadata_example",
      "recipients" => [
        [
          "address" => [
            'name' => 'Henry',
            'email' => $to,
          ],
          "metadata" => [
            "unique_id" => 424242
          ],
          "substitution_data" => [
            "name" => "Henry",
            "amount" => $amount,
            "goal" => "$150"
          ]
        ]
      ],
      "template" => "piggy"
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
