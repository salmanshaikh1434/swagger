<?php

require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Replace with your actual secret key (strong and unique)
$secretKey = 'efghijhs';


// User data to be encoded in the payload (replace with actual data)
$userData = [
    'id' => 123,
    'username' => 'johndoe',
    'email' => 'johndoe@example.com',
];

$issuedAt = time();
$expire = $issuedAt + 3600; // 1 hour expiration time (adjust as needed)
$payload = [
    'data' => $userData  // User data
];

$jwt = JWT::encode($payload, $secretKey, 'HS256'); // Use HS256 algorithm (consider stronger ones for production)

// Example response with the JWT token
echo json_encode([
    'message' => 'JWT token generated successfully',
    'token' => $jwt
]);

// -------- Validating the JWT --------

// Replace with the received JWT token from the client
$receivedJwt = $jwt;

try {
    $decoded = JWT::decode($receivedJwt, new Key($secretKey, 'HS256'));
    $decodedData = $decoded->data; // Access user data from the payload


    echo json_encode([
        'message' => 'JWT token is valid',
        'userData' => $decodedData
    ]);
} catch (Exception $e) {
    echo json_encode([
        'message' => 'Invalid JWT token: ' . $e->getMessage()
    ]);

}