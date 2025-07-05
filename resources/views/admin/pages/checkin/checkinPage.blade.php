@extends('admin.layouts.master')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="text-center">
            <h2 class="text-4xl font-bold mb-4">QUÉT THẺ ĐỂ CHECK-IN</h2>

            <form id="checkinForm" action="{{ route('admin.checkin.machine') }}" method="POST">
                @csrf
                <input type="text" id="rfidInput" name="rfid_card_id" autocomplete="off" autofocus
                    class="opacity-0 absolute">
            </form>

            <p class="text-gray-500 mt-3">Vui lòng quét thẻ tại máy để thực hiện check-in.</p>

            @if (session('message'))
                <div class="alert alert-info mt-4">
                    <i class="ri-information-line"></i>
                    <span>{{ session('message') }}</span>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('rfidInput');

            input.focus();

            input.addEventListener('change', function() {
                document.getElementById('checkinForm').submit();
            });

            setInterval(() => {
                if (document.activeElement !== input) {
                    input.focus();
                }
            }, 1000);
        });
    </script>
@endsection
