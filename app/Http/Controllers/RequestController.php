<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RequestController extends Controller
{
  use ResponseTrait;

  public function list()
  {
    $rents = Rent::with(['borrower', 'book']);

    $rents = auth()->user()->hasRole(User::TYPE_CLIENT) ? $rents->where('user_id', auth()->user()->id)->get() : $rents->get();

    return view('content.requests.list', compact('rents'));
  }

  public function approval()
  {
    $rents = Rent::with(['borrower', 'book'])->where('status', Rent::STATUS_PENDING)->get();

    return view('content.requests.approval', compact('rents'));
  }

  public function dueForReturn()
  {
    $rents = Rent::with(['borrower', 'book'])->where('status', Rent::STATUS_APPROVED)->get();

    return view('content.requests.return', compact('rents'));
  }

  public function create()
  {
    $books = Book::where('is_available', Book::STATUS_AVAILABLE)->get();
    return view('content.requests.create', compact('books'));
  }

  public function store(Request $request)
  {
    $maxDate = now()->addDays(7)->toDateString();
    $request->validate([
      'book_id' => ['required', 'exists:books,id'],
      'due_date' => ['required', 'after:today', `before_or_equal:{$maxDate}`]
    ]);

    Rent::create([
      ...$request->only(['book_id', 'due_date']),
      'user_id' => auth()->user()->id,
      'status' => Rent::STATUS_PENDING,
    ]);

    Book::find($request->book_id)->update(['is_available' => Book::STATUS_NOT_AVAILABLE]);

    return $this->successResponse(statusCode: 201, message: 'Successfully created!');
  }

  public function show(string $id)
  {
    try {
      $rent = Rent::findOrFail(Crypt::decrypt($id));
      return view('content.requests.show', compact('rent'));
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  public function cancel(Request $request, string $id)
  {
    try {
      $rent = Rent::findOrFail(Crypt::decrypt($id));
      $rent->update(['status' => Rent::STATUS_CANCELLED, 'reason' => $request->reason]);
      $rent->book->update(['is_available' => true]);
      $rent->refresh();

      return $this->successResponse(message: 'Request to rent was successfully cancelled.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  public function returned(string $id)
  {
    try {
      $rent = Rent::findOrFail(Crypt::decrypt($id));
      $rent->update(['return_date' => now(), 'status' => Rent::STATUS_RETURNED]);

      return $this->successResponse(message: 'Request to rent was successfully returned.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  public function approve(Request $request, string $id)
  {
    try {
      $rent = Rent::findOrFail(Crypt::decrypt($id));
      $rent->update(['status' => Rent::STATUS_APPROVED]);

      return $this->successResponse(message: 'Request to rent was successfully approved.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  public function reject(Request $request, string $id)
  {
    try {
      $rent = Rent::findOrFail(Crypt::decrypt($id));
      $rent->update(['status' => Rent::STATUS_REJECTED, 'reason' => $request->reason]);
      $rent->book->update(['is_available' => true]);
      $rent->refresh();

      return $this->successResponse(message: 'Request to rent was successfully rejected.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }
}
