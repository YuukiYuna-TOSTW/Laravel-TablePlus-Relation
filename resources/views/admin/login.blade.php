@extends('layouts.app')

@section('title', 'Admin Login')

@section('head')
<style>
    .login-card {
        max-width: 420px;
        margin: 48px auto;
    }
</style>
@endsection

@section('content')
<div class="login-card">
    <div class="bg-white rounded-xl p-8 shadow-md">
        <h2 class="text-2xl font-bold mb-4">Admin Login</h2>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/login" method="post">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                    Login
                </button>
                <a href="/" class="text-sm text-gray-600 hover:text-blue-600">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection