<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCreateFormController extends Controller
{
  public function index()
  {
    return view('content.users.create');
  }
}
