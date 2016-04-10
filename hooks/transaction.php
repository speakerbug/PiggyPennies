<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require '../vendor/autoload.php';

use SparkPost\SparkPost;
use GuzzleHttp\Client;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;

function print_line($message) {
  echo $message . "<br>";
}

$to = "sman591+pink@gmail.com";

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
          "amount" => "$8.48",
          "round_up" => "$0.52",
          "merchant_name" => "Starbucks",
          "goal" => "$150"
        ]
      ]
    ],
    "content" => [
      "template_id" => "piggy-transaction"
    ]
  ]);
  echo 'Woohoo! You just sent your first mailing!';
} catch (\Exception $err) {
  echo 'Whoops! Something went wrong';
  var_dump($err);
}

?>
