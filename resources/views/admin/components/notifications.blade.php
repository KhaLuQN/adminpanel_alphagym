<!-- Notifications -->
<div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <div class="indicator">
            <i class="ri-mail-line text-lg"></i>
            <span class="badge badge-sm badge-error indicator-item">
                {{ $contactNotifications->count() }}
            </span>

        </div>
    </div>
    <div tabindex="0" class="dropdown-content z-[1] card card-compact w-80 p-2 shadow-xl bg-base-100">
        <div class="card-body">
            <h3 class="card-title">Tin nhắn</h3>
            <div class="space-y-3">
                <div class="space-y-3">
                    @forelse ($contactNotifications as $contact)
                        <div class="alert"
                            style="background-color: {{ $contact->color }}20; color: {{ $contact->color }};">
                            @if ($contact->type === 'complain')
                                <i class="ri-error-warning-line"></i>
                                <div>
                                    <div class="font-bold">Khiếu nại</div>
                                    <div class="text-xs">
                                        {{ $contact->full_name }} đã gửi khiếu nại lúc
                                        {{ \Carbon\Carbon::parse($contact->submitted_at)->format('H:i d/m') }}
                                    </div>
                                </div>
                            @elseif ($contact->type === 'support')
                                <i class="ri-customer-service-2-line"></i>
                                <div>
                                    <div class="font-bold">Yêu cầu hỗ trợ</div>
                                    <div class="text-xs">
                                        {{ $contact->full_name }} cần hỗ trợ lúc
                                        {{ \Carbon\Carbon::parse($contact->submitted_at)->format('H:i d/m') }}
                                    </div>
                                </div>
                            @elseif ($contact->type === 'contact')
                                <i class="ri-mail-line"></i>
                                <div>
                                    <div class="font-bold">Liên hệ</div>
                                    <div class="text-xs">
                                        {{ $contact->full_name }} đã gửi liên hệ lúc
                                        {{ \Carbon\Carbon::parse($contact->submitted_at)->format('H:i d/m') }}
                                    </div>
                                </div>
                            @else
                                <i class="ri-notification-2-line"></i>
                                <div>
                                    <div class="font-bold">Thông báo khác</div>
                                    <div class="text-xs">
                                        {{ $contact->full_name }} đã gửi lúc
                                        {{ \Carbon\Carbon::parse($contact->submitted_at)->format('H:i d/m') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">Không có liên hệ mới</div>
                    @endforelse
                </div>

            </div>
            <div class="card-actions">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-block"> xem tất cả</a>
            </div>
        </div>
    </div>
</div>
