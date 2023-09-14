<?php

namespace App\Listeners;

use App\Events\SendPhoneConfirm;
use App\Http\Controllers\SmsController;

class phoneConfirmationListener
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */
  public function handle(SendPhoneConfirm $event): void
  {
    SmsController::send('7' . $event->conf->phone, $event->conf->code);
  }
}
