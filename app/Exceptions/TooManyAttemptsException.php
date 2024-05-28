<?php

namespace App\Exceptions;

class TooManyAttemptsException extends \Exception
{
  public function __construct($secondsLeft)
  {
    $this->message = `Too many login attempts. Try again in {$secondsLeft} seconds.`;
  }
}
