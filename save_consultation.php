<?php
// Capture form fields
$full_name      = $_POST['full_name'] ?? '';
$business_name  = $_POST['business_name'] ?? '';
//$email          = $_POST['email'] ?? ''; replaced by below code 10122026
//New Code 10122026
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

if (!empty($_POST['honey'])) {
    exit;
}

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

if (!$email) {
    exit('Invalid email');
}
$phone          = $_POST['phone'] ?? '';
$service        = $_POST['service'] ?? '';
$preferred_date = $_POST['preferred_date'] ?? '';
$message        = $_POST['message'] ?? '';
//New Code 10122026
// Timestamp
$timestamp = date("Y-m-d H:i:s");

// CSV file path
$csv_file = __DIR__ . "/CSV/consultations.csv";

// Write to CSV
$csv_row = [
    $timestamp,
    $full_name,
    $business_name,
    $email,
    $phone,
    $service,
    $preferred_date,
    $message
];

$fp = fopen($csv_file, 'a');
fputcsv($fp, $csv_row);
fclose($fp);

// Email notification
$to = "contact@medhaaccounting.com";
$subject = "New Consultation Request - Medha Accounting";
$body = "
A new consultation request has been submitted:

Timestamp: $timestamp
Full Name: $full_name
Business Name: $business_name
Email: $email
Phone: $phone
Service Interested In: $service
Preferred Call Date: $preferred_date

Message:
$message
";

$headers = "From: noreply@medhaaccounting.com";

mail($to, $subject, $body, $headers);

// Redirect user to thank-you page
header("Location: thankyou.html");
exit;
?>
