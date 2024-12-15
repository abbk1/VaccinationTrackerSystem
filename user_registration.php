<?php
header('Content-Type: application/json');

$response = [];

try {
    // Ensure only POST requests are allowed
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Database connection (use PDO or MySQLi)
    $conn = new mysqli('localhost', 'root', '', 'vaccinetracker_db');
    if ($conn->connect_error) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    // Retrieve and sanitize inputs
    $firstName = isset($_POST['firstName']) ? $conn->real_escape_string($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? $conn->real_escape_string($_POST['lastName']) : '';
    $dateOfBirth = isset($_POST['dateOfBirth']) ? $conn->real_escape_string($_POST['dateOfBirth']) : '';
    $gender = isset($_POST['flexRadioDefault']) ? $conn->real_escape_string($_POST['flexRadioDefault']) : '';
    $phoneNumber = isset($_POST['phoneNumber']) ? $conn->real_escape_string($_POST['phoneNumber']) : '';
    $address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : '';


    // Example query
    $query = "INSERT INTO tblindividual (firstName, lastName, dateOfBirth, gender, PhoneNumber, address) VALUES ('$firstName', '$lastName','$dateOfBirth','$gender','$phoneNumber', '$address')";
    if (!$conn->query($query)) {
        throw new Exception('Error inserting data: ' . $conn->error);
    }

    // Success response
    $response = [
        'success' => true,
        'message' => 'Your form has been submitted successfully!',
    ];
} catch (Exception $e) {
    // Error response
    $response = [
        'success' => false,
        'message' => 'An error occurred.',
        'error' => $e->getMessage(), // Include the error message for debugging (only in dev)
    ];
}

// Send the JSON response
echo json_encode($response);