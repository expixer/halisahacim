<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService {

  private $messaging;

  public function __construct() {
    $serviceAccountPath = storage_path('app/bimacyap-cfefb-firebase-adminsdk-gr21d-687a540d7b.json');
    $factory = (new Factory)->withServiceAccount($serviceAccountPath);
    $this->messaging = $factory->createMessaging();
  }

  public function sendNotification($token, $title, $body, $data) {
    $message = CloudMessage::new()
      ->withNotification([
        'title' => $title,
        'body' => $body,
      ])
      ->withData($data)
      ->toToken($token);

    $this->messaging->send($message);

  }
}
