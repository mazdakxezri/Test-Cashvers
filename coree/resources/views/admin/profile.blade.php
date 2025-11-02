@extends('admin.layouts.master')

@section('title', 'Admin Profile')


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pt-2 pb-0">
                            <span class="h4 nav-link active fw-bold">Admin Update Information</span>
                        </div>
                        <div class="card-body row mt-2 pb-5">


                            <form method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="full-name">Full Name</label>
                                        <input type="text" class="form-control" id="full-name" name="full_name"
                                            value="{{ old('full_name', $info->name) }}" placeholder="Enter your full name"
                                            required>
                                        @error('full_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email', $info->email) }}" placeholder="Enter your email address"
                                            required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="old-password">Old Password</label>
                                        <input type="password" class="form-control" id="old-password" name="old_password"
                                            placeholder="Enter your old password" required>
                                        @error('old_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="new-password">New Password</label>
                                        <input type="password" class="form-control" id="new-password" name="new_password"
                                            placeholder="Enter your new password">
                                        @error('new_password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="confirm-password">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm-password"
                                            name="new_password_confirmation" placeholder="Confirm your new password">
                                        @error('new_password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
