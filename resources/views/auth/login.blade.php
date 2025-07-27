@extends('auth.layout')

@section('conten')
    <div class="min-h-screen flex items-center justify-center bg-base-200">
        <div class="w-full max-w-md shadow-xl rounded-xl bg-base-100">

            <form method="POST" action="{{ route('login.auth') }}" class="p-6 space-y-4">
                @csrf
                <div class="p-6 bg-primary text-primary-content rounded-t-xl text-center">
                    <h3 class="text-2xl font-bold">Đăng Nhập</h3>
                    <p class="text-sm">Phần mềm quản lý phòng Gym</p>
                </div>
                <div class="flex bg-indigo-700 p-3">
                    <div class="w-full max-w-xs m-auto bg-indigo-100 rounded p-5">
                        <header>
                            <img class="w-20 mx-auto mb-5" src="{{ asset('images/admin.png') }}" />
                        </header>
                        <form>
                            <div>
                                <label class="block mb-2 text-indigo-500" for="username">Username</label>
                                <input
                                    class="w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300"
                                    type="text" name="username" id="username" placeholder="Nhập username" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-indigo-500" for="password">Password</label>
                                <input
                                    class="w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300"
                                    type="password" name="password"id="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div>
                                <input
                                    class="w-full bg-indigo-700 hover:bg-pink-700 text-white font-bold py-2 px-4 mb-6 rounded"
                                    type="submit">
                            </div>
                        </form>

                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
