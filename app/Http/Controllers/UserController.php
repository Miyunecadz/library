<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{
  use ResponseTrait;
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.users.list');
  }

  public function fetch()
  {
    $users = User::select(['id', 'name', 'email', 'user_type'])->get()
      ->transform(fn ($user) => [Crypt::encrypt($user->id), $user->name, $user->email, Str::title($user->user_type)]);

    return $this->successResponse($users);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.users.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreUserRequest $request)
  {
    $user = User::create([
      ...$request->validated(),
      'password' => bcrypt($request->password),
    ]);

    return $this->successResponse($user, 'User successfully created', 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    try {
      $user = User::findOrFail(Crypt::decrypt($id));
      return $this->successResponse($user, 'User successfully retrieved', 200);
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    try {
      $user = User::findOrFail(Crypt::decrypt($id));
      $user_types = [User::TYPE_ADMIN, User::TYPE_CLIENT];
      return view('content.users.edit', compact('user', 'user_types'));
    } catch (DecryptException $de) {
      abort(404);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request, string $id)
  {
    try {
      $user = User::findOrFail(Crypt::decrypt($id));
      $data = $request->only(['name', 'user_type']);

      if ($request->has('password') && $request->password) {
        $data['password'] = bcrypt($request->password);
      }

      $user->update($data);
      $user->refresh();
      return $this->successResponse($user, 'User successfully updated.', 200);
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
      $user = User::findOrFail(Crypt::decrypt($id));
      $user->delete();
      return $this->successResponse(message: 'User Successfully deleted.');
    } catch (DecryptException $de) {
      abort(404);
    }
  }
}
