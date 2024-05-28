<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;

class LogoutBasic extends Controller
{
  use ResponseTrait;

  public function index(Request $request)
  {
    auth()->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return $this->successResponse();
  }
}
