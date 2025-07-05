@if (session('success') || session('error'))
    <div class="fixed top-4 right-4 z-50 space-y-4">
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="alert alert-success shadow-lg w-80">
                <div>
                    <i class="ri-check-line text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                class="alert alert-error shadow-lg w-80">
                <div>
                    <i class="ri-error-warning-line text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>
@endif
