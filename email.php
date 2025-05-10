<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $Subject = htmlspecialchars($_POST['Subject']);
    $message = htmlspecialchars($_POST['message']);
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'wimmerasecurity.com.au';                  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'muhammadsaram2018@gmail.com';            // SMTP username
        $mail->Password   = '8q2@pdzH';                  // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable SSL encryption, TLS can be used as well
        $mail->Port       = 465;                                    // TCP port to connect to

        // Recipient
        $mail->setFrom('support@oliverhotelarezzo.com', 'Oliver Hotel');
        $mail->addAddress($email, $name);                           // Add a recipient (user)
        $mail->addAddress('support@oliverhotelarezzo.com');                  // Add a recipient (admin)

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Reservation Confirmation';
        $mail->Body    = "Dear $name,<br><br>Thank you for reaching out to us. Here are the details you provided:<br>" .
                         "Name: $name<br>Phone: $phone<br>Email: $email<br>" .
                         "Check-in Date: $checkin_date<br>Check-out Date: $checkout_date<br>" .
                         "Notes: $message<br><br>We will get back to you shortly.<br><br>Best regards,<br>Your Hotel";

        $mail->AltBody = "Dear $name,\n\nThank you for your reservation. Here are the details you provided:\n\n" .
                         "Name: $name\nPhone: $phone\nEmail: $email\n" .
                         "Check-in Date: $checkin_date\nCheck-out Date: $checkout_date\n" .
                         
                         "Notes: $message\n\nWe will get back to you shortly.\n\nBest regards,\nYour Hotel";

        // Send email to admin
        $mail->addAddress('support@oliverhotelarezzo.com');
        $mail->Subject = "New Contact Request";
        $mail->Body    = "New Contact details:<br>" .
                         "Name: $name<br>Phone: $phone<br>Email: $email<br>" .
                         "Check-in Date: $checkin_date<br>Check-out Date: $checkout_date<br>" .
                         
                         "Notes: $message";

        // Send the message
        $mail->send();
        // Redirect to reservation.html
        header("Location: Index.html");
        exit();  // Ensures no further code is executed after redirection
    } catch (Exception $e) {
        echo "Error: Unable to send email. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Error: Please submit the form properly.";
}
