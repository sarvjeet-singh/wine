@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="dashboard-card">
            <h3>Create User</h3>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" required>
                </div>
                <div class="mb-3">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
