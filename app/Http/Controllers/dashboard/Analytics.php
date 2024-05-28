<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Book;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index()
  {
    $userCount = User::count();
    $bookCount = Book::count();
    $rentCount = Rent::count();
    return view('content.dashboard.dashboards-analytics', compact('userCount', 'bookCount', 'rentCount'));
  }
}
