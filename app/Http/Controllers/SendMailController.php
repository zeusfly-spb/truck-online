<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailConfirm;

class SendMailController extends Controller
{
  public function sendEmailCode()
  {
    $to = 'zeusfly@mail.ru';
    $code = '7777';
    $subject = 'Email code';
    $message = $code;
    $headers = 'From: info@online-port.ru'       . "\r\n" .
      'Reply-To: info@online-port.ru' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    }

}
