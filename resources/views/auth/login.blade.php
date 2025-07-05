@extends('auth.layout')

@section('conten')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <div class="bg-blue-600 p-6 rounded-t-lg text-white text-center">
                <h3 class="text-2xl font-bold">Đăng Nhập</h3>
                <p class="text-sm">Phần mềm quản lý phòng Gym</p>
            </div>
            <form method="POST" action="{{ route('login.auth') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Tên đăng nhập</label>
                    <input type="text" name="username" id="username" placeholder="username" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <input type="password" name="password" id="password" placeholder="Password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Đăng nhập</button>
            </form>
        </div>
    </div>
@endsection
