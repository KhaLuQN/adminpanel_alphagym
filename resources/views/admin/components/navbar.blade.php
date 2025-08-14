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

        <!-- Nút thao tác nhanh -->
        <a href="{{ route('admin.members.create') }}" class="btn btn-sm btn-primary tooltip tooltip-bottom"
            data-tip="Thêm hội viên">
            <i class="ri-user-add-line text-lg"></i>
        </a>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-sm btn-secondary tooltip tooltip-bottom"
            data-tip="Thêm gói tập">
            <i class="ri-file-add-line text-lg"></i>
        </a>
        <a href="{{ route('admin.checkin.checkinPage') }}" target="_blank"
            class="btn btn-sm btn-accent tooltip tooltip-bottom" data-tip="Trang Check-in">
            <i class="ri-door-open-line text-lg"></i>
        </a>

        <!-- Notifications -->
        @include('admin.components.notifications')

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
