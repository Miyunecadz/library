<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class BookController extends Controller
{
  use ResponseTrait;
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.books.list');
  }

  public function fetch()
  {
    $books = Book::select(['id', 'title', 'author', 'genre', 'book_number', 'is_available'])->get()
      ->transform(fn ($book) => [
        Crypt::encrypt($book->id),
        $book->title,
        $book->author,
        $book->genre,
        $book->book_number,
        $book->prettyStatus(),
      ]);

    return $this->successResponse($books);
  }

  public function create()
  {
    return view('content.books.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreBookRequest $request)
  {
    $book = Book::create($request->validated());

    return $this->successResponse($book, 'Book created successfully.', 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $book = Book::find(Crypt::decrypt($id));
      return $this->successResponse($book);
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  public function edit(string $id)
  {
    try {
      $book = Book::find(Crypt::decrypt($id));
      $status = ['Not Available', 'Available'];
      return view('content.books.edit', compact('book', 'status'));
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateBookRequest $request, string $id)
  {
    try {
      $book = Book::find(Crypt::decrypt($id));
      $book->update($request->validated());
      return $this->successResponse(message: 'Book updated successfully.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    try {
      $book = Book::find(Crypt::decrypt($id));
      $book->delete();
      return $this->successResponse(message: 'Book deleted successfully.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }
}
