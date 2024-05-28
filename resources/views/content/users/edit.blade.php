@extends('layouts/contentNavbarLayout')

@section('title', ' Edit User - Form')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Users/</span> Edit</h4>

    <!-- Basic Layout -->
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST" id="userUpdateForm">
                        <input type="hidden" name="user_id" value="{{ Crypt::encrypt($user->id) }}">
                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                                value="{{ $user->name }}" />
                            <small id="name-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="john.doe@email.com" aria-label="john.doe" value="{{ $user->email }}"
                                    aria-describedby="basic-default-email2" readonly />
                            </div>
                            <small id="email-message" class=""></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="user_type">User Type</label>
                            <select name="user_type" id="user_type" class="form-select">
                                <option value="">Select one</option>
                                @foreach ($user_types as $user_type)
                                    <option value="{{ $user_type }}" @if ($user_type == $user->user_type) selected @endif>
                                        {{ Str::title($user_type) }}</option>
                                @endforeach
                            </select>
                            <small id="user_type-message" class=""></small>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <small id="password-message" class=""></small>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/users/user-update.js') }}" defer></script>
@endsection
