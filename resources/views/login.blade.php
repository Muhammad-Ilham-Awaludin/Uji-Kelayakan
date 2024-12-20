@extends('layouts.template')

@section('masuk')
    <form action="{{ route('postLogin') }}" class="w-50 p-5 align-middle" method="POST">
        @csrf
        {{-- // csrf fungsinya untuk memferivikasi ketika akan mengambil data dari POST --}}
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        @if (Session::get('logout'))
            <div class="alert alert-primary">{{ Session::get('logout') }}</div>
        @endif
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror <br>
        </div>
        <div class="d-flex justify-content-center gap-2">
            <button type="submit" class="btn w-100 btn-success">Login</button>
            <button type="submit" class="btn w-100 btn-success">Buat Akun</button>
        </div>
    </form>
@endsection
