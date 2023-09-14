<?php

namespace App\Http\Controllers;

use App\Models\EmailConfirmation;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController extends Controller
{
  /**
   * @param EmailConfirmation $conf
   * @return bool
   * @throws Exception
   */
  public static function sendEmailConfirmCode(EmailConfirmation $conf)
  {
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'onlineport019@gmail.com';
    $mail->Password = 'lgumocfxqoavkqet';
    // Sender &amp; Recipient
    $mail->From = 'support@onlineport.ru';
    $mail->FromName = 'Служба поддержки OnlinePort';
    $mail->addAddress($conf->email);
    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->Subject = 'Код подтверждения email';
    $body = "<h1><strong>$conf->code</strong></h1>";
    $mail->Body = $body;
    return $mail->send();
  }

  /**
   * @return void
   * @throws Exception
   */
  public function sendMail()
  {
    $mail = new PHPMailer(true);
    // Server settings
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = 'onlineport019@gmail.com';
    $mail->Password = 'lgumocfxqoavkqet';
    // Sender &amp; Recipient
    $mail->From = 'support@onlineport.ru';
    $mail->FromName = 'Джамба';
    $mail->addAddress('zeusfly@mail.ru');
    // Content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->Subject = 'My Subject';
    $body = 'This is a test message sent by <b>Online Web Tutor</b>';
    $mail->Body = $body;

    if ($mail->send()) {

      echo 'Mail sent successfully';
      exit;
    } else {

      echo 'Failed to send email';
      exit;
    }
  }
}
