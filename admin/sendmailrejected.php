<?php
include 'includes/dbconnection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE tblappointment SET Status = '2' WHERE ID = '$id' ";
    $run_sql = mysqli_query($con, $sql);

    // Fetch the appointment with the given ID
    $ret = mysqli_query($con, "SELECT * FROM tblappointment WHERE ID = '$id'");

    $row = mysqli_fetch_array($ret);
    if ($row) {
        // Send confirmation email
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = '';
        $mail->SMTPAuth = ;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('');
        $mail->addAddress($row['Email']);

        $mail->isHTML(true);
        $mail->Subject = 'Appointment Rejected';
        $mail->Body = "Dear {$row['Name']},<br><br>Sorry, Your appointment has been Rejected  We currently do not accept any new appointments, Please send a new apppointment request later.<br><br>Details:<br>Service: {$row['Services']}<br>Date: {$row['AptDate']}<br>Time: {$row['AptTime']}<br>Phone: {$row['PhoneNumber']}<br><br>Thank you.";

        if(!$mail->send()) {
            echo 'Confirmation Email Sent.Please Check your Email.';
            echo 'Confirmation Email sending failed. Please try again: ' . $mail->ErrorInfo;
        } else {
            echo "<script>alert('Confirmation Email will be Sent to your email shortly. Thank you'); window.location = 'rejected-appointment.php';</script>";
        }
    }
}
?>
