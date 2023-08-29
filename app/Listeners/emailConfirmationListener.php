<?php

namespace App\Listeners;

use App\Events\SendEmailConfirm;
use App\Http\Controllers\EmailController;

class emailConfirmationListener
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
  public function handle(SendEmailConfirm $event): void
  {
    EmailController::sendEmailConfirmCode($event->conf);
  }
}
