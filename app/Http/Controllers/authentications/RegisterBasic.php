<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  use ResponseTrait;

  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function register(RegistrationRequest $request)
  {
    $user = User::create([
      ...$request->validated(),
      'password' => bcrypt($request->password),
      'user_type' => User::TYPE_CLIENT
    ]);

    auth()->login($user);
    $request->session()->regenerate();

    // OTP
    // $otp = rand(1000, 9999);
    // session()->flash('user_id_' . $user->id, $otp);

    return $this->successResponse(
      data: $user,
      statusCode: 201
    );
  }
}
