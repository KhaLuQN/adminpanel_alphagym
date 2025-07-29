<!-- Navbar -->
<div class="navbar bg-base-300 shadow-lg border-b border-base-200">
    <div class="navbar-start">
        <label for="drawer-toggle" class="btn btn-square btn-ghost lg:hidden">
            <i class="ri-menu-line text-xl"></i>
        </label>
        <div class="ml-4 flex items-center">
            <div class="avatar placeholder mr-3">
                <div class="bg-primary text-primary-content rounded-lg w-10">
                    <i class="ri-dashboard-3-line text-lg"></i>
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


        <!-- Search -->
        <div class="form-control hidden md:block">
            <input type="text" placeholder="Tìm kiếm..." class="input input-bordered input-sm w-64" />
        </div>
        <a href="{{ route('admin.subscriptions.create') }}">
            <i class="ri-add-circle-line text-lg"></i>

        </a>
        <!-- Notifications -->
        @include('admin.components.notifications')

        <!-- Messages -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <i class="ri-mail-line text-lg"></i>
                    <span class="badge badge-sm badge-success indicator-item">3</span>
                </div>
            </div>
            <div tabindex="0" class="dropdown-content z-[1] card card-compact w-80 p-2 shadow-xl bg-base-100">
                <div class="card-body">
                    <h3 class="card-title">Tin nhắn</h3>
                    <div class="space-y-3">
                        <div
                            class="flex items-center gap-3 p-3 hover:bg-base-200 rounded-lg cursor-pointer transition-colors">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-10">
                                    <span class="text-xs">NA</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-sm">Nguyễn Văn A</div>
                                <div class="text-xs text-base-content/70">Xin chào, tôi muốn hỏi về gói tập...</div>
                                <div class="text-xs text-base-content/50">2 phút trước</div>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-3 p-3 hover:bg-base-200 rounded-lg cursor-pointer transition-colors">
                            <div class="avatar placeholder">
                                <div class="bg-secondary text-secondary-content rounded-full w-10">
                                    <span class="text-xs">TB</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-sm">Trần Thị B</div>
                                <div class="text-xs text-base-content/70">Khi nào phòng gym mở cửa vào chủ nhật?</div>
                                <div class="text-xs text-base-content/50">15 phút trước</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-block">Xem tất cả</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Theme Toggle -->
        <button onclick="toggleTheme()" class="btn btn-ghost btn-circle" title="Đổi theme">
            <i class="ri-contrast-2-line text-lg"></i>
        </button>
        <!-- Profile -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-lg w-8">
                        <span class="text-xs">NK</span>
                    </div>
                </div>
                <span class="hidden md:inline ml-2">Nguyễn Đình Kha</span>
                <i class="ri-arrow-down-s-line"></i>
            </div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-base-100 rounded-box w-52">
                <li class="menu-title">
                    <span>Nguyễn Đình Kha</span>
                    <span class="text-xs text-base-content/50">GYM ADMIN</span>
                </li>
                <li><a><i class="ri-user-line"></i>Hồ sơ cá nhân</a></li>
                <li><a><i class="ri-settings-line"></i>Cài đặt</a></li>
                <li><a><i class="ri-logout-box-line"></i>Đăng xuất</a></li>
            </ul>
        </div>


    </div>
</div>
