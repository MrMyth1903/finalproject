<?php
require __DIR__ . '/vendor/autoload.php'; // Load Twilio SDK

use Twilio\Rest\Client;

// Twilio API credentials (Replace with actual credentials from Twilio Dashboard)
$sid = "your_twilio_account_sid";
$token = "your_twilio_auth_token";
$twilio_number = "your_twilio_phone_number";

$client = new Client($sid, $token);

try {
    $message = $client->messages->create(
        "+1234567890", // Replace with recipient's phone number (in international format)
        [
            'from' => $twilio_number,
            'body' => "Your order is confirmed! Thank you for choosing our service."
        ]
    );

    echo "Message sent successfully! Message SID: " . $message->sid;
} catch (Exception $e) {
    echo "Error sending message: " . $e->getMessage();
}
?>
