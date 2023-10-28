<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// $customerMail = "chaudharidigambar52002@gmail.com";
// $name = "jojo";
// $amount = "300";
// $totalAmount = "400";
// $date = date("d/m/Y");
// $AccountNo = "123456789012";

// orderMail($customerMail,$name,"1",$amount,"2",$totalAmount,$date,$AccountNo);




function orderMail($customerMail, $pname, $weight, $price, $item, $total, $address, $mobileno)
{


    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'mahajantrushita@gmail.com';
    $mail->Password = 'mnqkiwrvheibguoj';

    $content = file_get_contents('../mail/ordertemp.php');
    $mail->setFrom("mahajantrushita@gmail.com", "Sweet Bakery");
    $mail->addAddress($customerMail);
    $mail->addReplyTo("mahajantrushita@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = "Your order '$pname' placed";

    $swap_var = array(

        "{pname}" => "$pname",
        "{weight}" => "$weight",
        "{price}" => "$price",
        "{item}" => "$item",
        "{total}" => "$total",
        "{address}" => "$address",
        "{mobileno}" => "$mobileno",

    );

    foreach (array_keys($swap_var) as $key) {
        if (strlen($key) > 2 && trim($key) != "") {
            $content = str_replace($key, $swap_var[$key], $content);
        }
    }

    $mail->Body = "$content";


    if (!$mail->send()) {
        echo "mail not sent";
    }
}

// VerificationMail($customerMail, "hello", "testing mail", "hello", "12234rkrhyupty", "true");

function VerificationMail($email, $subject, $message, $action, $vkey, $flag)
{

    

    $vlink = "http://localhost/sweetbakery/user/verify.php?vkey=" . $vkey . "&flag=" . $flag;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'mahajantrushita@gmail.com';
    $mail->Password = 'mnqkiwrvheibguoj';

    $content = file_get_contents('../mail/DebitMailTemp.php');
    $mail->setFrom("mahajantrushita@gmail.com", "Sweet Bakery");
    $mail->addAddress($email);
    $mail->addReplyTo("mahajantrushita@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message . " <a href='$vlink'>'$action'</a>";


    if (!$mail->send()) {
        $error = "mail not sent";
    }
}