<!-- Navbar -->
<div class="navbar bg-base-300 shadow-lg border-b border-base-200">
    <div class="navbar-start">
        <label for="drawer-toggle" class="btn btn-square btn-ghost lg:hidden">
            <i class="ri-menu-line text-xl"></i>
        </label>
        <div class="ml-4 flex items-center">
            <div class="avatar placeholder mr-3">
                <div class="bg-primary text-primary-content rounded-lg w-10">
                    <i class="ri-dashboard-3-line text-4xl text-center"></i>
                </div>
            </div>
            <div>
                <h1 class="text-lg font-bold">@yield('page_title', 'Trang Quản Trị')</h1>
                <div class="breadcrumbs text-xs">
                    <ul>
                        @section('page_title', 'Quản lý Thiết Bị')

                        @yield('breadcrumbs')

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="navbar-end gap-2">




        <!-- Notifications -->
        @include('admin.components.notifications')

        <!-- Messages -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <i class="ri-notification-2-line text-lg"></i>
                    <span class="badge badge-sm badge-success indicator-item">3</span>
                </div>
            </div>
            <div tabindex="0" class="dropdown-content z-[1] card card-compact w-80 p-2 shadow-xl bg-base-100">
                <div class="card-body">
                    <h3 class="card-title">Thông báo</h3>
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
                        <button class="btn btn-sm btn-block">Xem tất cả</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-sm">

                <span class="hidden md:inline ml-2">ADMIN</span>
                <i class="ri-arrow-down-s-line"></i>
            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-base-100 rounded-box w-52">
                <li class="menu-title">
                    <span>Nguyễn Đình Kha</span>
                    <span class="text-xs text-base-content/50">GYM ADMIN</span>
                </li>
                <li><a><i class="ri-user-line"></i>Hồ sơ cá nhân</a></li>
                <li><a onclick="toggleTheme()"><i class="ri-contrast-line"></i>Theme</a></li>
                <li><a><i class="ri-settings-line"></i>Cài đặt</a></li>
                <li><a><i class="ri-logout-box-line"></i>Đăng xuất</a></li>
            </ul>
        </div>


    </div>
</div>
