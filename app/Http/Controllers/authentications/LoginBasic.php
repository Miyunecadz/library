<?php

namespace App\Http\Controllers\authentications;

use App\Exceptions\TooManyAttemptsException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class LoginBasic extends Controller
{
  use ResponseTrait;

  public function index()
  {
    // dd(auth()->user());
    return view('content.authentications.auth-login-basic');
  }

  public function authenticate(Request $request)
  {
    try {
      $remainingAttempts = $this->handleLoginRateLimit($request->email);

      if (!auth()->attempt($request->all())) {
        return $this->failedResponse(
          message: 'Invalid Credentials',
          errors: [
            'email' => 'Invalid credentials',
            'attempts' => "Remaining attempts $remainingAttempts"
          ],
          statusCode: 401
        );
      }

      $request->session()->regenerate();

      return $this->successResponse(message: 'Authentication successful', data: auth()->user());
    } catch (\Exception $e) {
      return $this->failedResponse(message: $e->getMessage(), statusCode: 500);
    } catch (TooManyAttemptsException $tmae) {
      return $this->failedResponse(
        message: 'Login failed',
        errors: [
          'attempt' => $tmae->getMessage()
        ]
      );
    }
  }

  private function handleLoginRateLimit($email)
  {
    $limit = 10;
    $key = $this->throttleKey($email);

    if (!RateLimiter::tooManyAttempts($key, $limit)) {
      RateLimiter::hit($key);
      return RateLimiter::remaining($key, $limit);
    }

    $seconds = RateLimiter::availableIn($key);
    throw new TooManyAttemptsException($seconds);
  }

  private function throttleKey($email)
  {
    return Str::lower($email) . '|' . request()->ip();
  }

  public function handleGoogleSignIn(Request $request)
  {
    $request->validate([
      'credential' => 'required'
    ]);

    list($header, $payload, $signature) = explode(".", $request->credential);
    $responsePayload = json_decode(base64_decode($payload));

    $user = User::where('email', $responsePayload->email)->first();

    if (!$user) {
      return $this->failedResponse('Invalid user, unregistered user', ['attempt' => 'Unrecognized User, please try again!'], 401);
    }

    auth()->login($user);

    $request->session()->regenerate();
    return $this->successResponse(message: 'Authentication successful', data: auth()->user());
  }
}
