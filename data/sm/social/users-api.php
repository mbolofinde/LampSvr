<?php

// Facebook Graph API endpoint
$url = 'https://graph.facebook.com/v19.0/me?fields=id,name,about,email&access_token=EAAKZAfLQMXL0BO7ZCI7vZCZCUnE5IRFvSFQluskDZBYp4eyTfzq0P07S8tBQZCWLIsR5Ucrj11NBEZBHNPlkEg9xsELJmo220H75qbYLg2DToYbM8uAfxrtTM7VX7DDKDa6EuREDBtpbovJjyC02FGbHy4vzQWb54zniQgLZALc4Q8ULCZAWFhFd3May3ZBv1t81TfJrqRNe9Bh6Hfd7GqggZDZD';

// Execute cURL request
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

// Decode JSON response
$data = json_decode($response, true);

// Check if data retrieval was successful
if (isset($data['error'])) {
    echo 'Error: ' . $data['error']['message'];
} else {
    // Connect to MySQL database
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'social_media';

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare('INSERT INTO users (username, profile_photo_url, bio, email) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $username, $profile_photo_url, $bio, $email);

    // Set parameters
    $username = $data['name'];
    $profile_photo_url = 'https://picsum.photos/100'; // Default profile photo URL
    $bio = isset($data['about']) ? $data['about'] : null;
    $email = $data['email'];

    // Execute SQL statement
    if ($stmt->execute() === TRUE) {
        echo 'New record created successfully';
    } else {
        echo 'Error: ' . $conn->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}

?>
