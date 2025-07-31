<div class="drawer-side">
    <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="min-h-full w-72 bg-base-200">
        <div class="bg-gradient-to-r from-primary to-secondary p-6">
            <div class="flex items-center text-primary-content">
                <div class="avatar placeholder mr-3">
                    <div class="bg-base-100 text-center text-primary rounded-xl w-12">
                        <i class="ri-admin-line text-5xl"></i>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-bold">AdminPanel</h1>
                    <p class="text-sm opacity-90">MANAGEMENT SYSTEM</p>
                </div>
            </div>
        </div>

        <ul class="menu p-4 space-y-2">
            {{-- Bảng Điều Khiển --}}
            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all hover:bg-base-300 {{ is_active('dashboard*') }}">
                    <i class="ri-dashboard-3-line"></i> Bảng Điều Khiển
                </a>
            </li>

            <li class="menu-title"><span><i class="ri-building-line mr-1"></i>Quản Lý Phòng Gym</span></li>

            {{-- Hội Viên --}}
            <li>
                <details {{ is_active('admin/members*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/members*') }}">
                        <i class="ri-user-3-line"></i> Hội Viên
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.members.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/member/index') }}">Danh
                                sách Hội
                                viên</a></li>
                        <li><a href="{{ route('admin.members.create') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/member/create') }}">Thêm
                                Hội viên mới</a></li>
                    </ul>
                </details>
            </li>

            {{-- Gói Dịch Vụ --}}
            <li>
                <details {{ is_active('admin/membership-plans*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/membership-plans*') }}">
                        <i class="ri-vip-crown-2-line"></i> Gói Dịch Vụ
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.membership-plans.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/membership-plans/index') }}">Danh
                                sách
                                Gói</a></li>
                        <li><a href="{{ route('admin.membership-plans.create') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/membership-plans/create') }}">Thêm
                                Gói</a></li>
                    </ul>
                </details>
            </li>

            {{-- Check-in/Check-out --}}
            <li>
                <details {{ is_active('admin/checkin*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/checkin*') }}">
                        <i class="ri-time-line"></i> Check-in/Check-out
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.checkin.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/checkin/index') }}">Lịch
                                sử
                                Ra/Vào</a></li>
                        <li><a href="{{ route('admin.checkin.checkinPage') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/checkin/page') }}">Trang
                                Check-in</a></li>
                    </ul>
                </details>
            </li>

            {{-- Thanh Toán --}}
            <li>
                <a href="{{ route('admin.payments.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all hover:bg-base-300 {{ is_active('admin/payments*') }}">
                    <i class="ri-money-dollar-circle-line"></i> Thanh Toán
                </a>
            </li>

            {{-- Thiết Bị --}}
            <li>
                <details {{ is_active('admin/equipment*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/equipment*') }}">
                        <i class="ri-tools-line"></i> Thiết Bị
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.equipment.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/equipment') }}">Danh
                                sách Thiết bị</a></li>
                        <li><a href="{{ route('admin.equipment.create') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/equipment/create') }}">Thêm
                                Thiết bị</a></li>
                    </ul>
                </details>
            </li>

            <li class="menu-title"><span><i class="ri-global-line mr-1"></i>Quản Lý Website</span></li>

            {{-- Bài Viết --}}
            <li>
                <details {{ is_active('admin/articles*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/articles*') }}">
                        <i class="ri-article-line"></i> Bài Viết & Tin Tức
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.articles.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/articles') }}">Tất cả
                                Bài Viết</a></li>
                        <li><a href="{{ route('admin.articles.create') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/articles/create') }}">Viết
                                Bài Mới</a></li>
                        <li><a href="{{ route('admin.article-categories.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/article-categories') }}">Danh
                                Mục Bài Viết</a></li>
                    </ul>
                </details>
            </li>

            <li>
                <details {{ is_active('admin/trainers*', 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/trainers*') }}">
                        <i class="ri-tools-line"></i> Huấn Luyện viên
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.trainers.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/trainers') }}">Danh
                                sách Huấn luyện viên</a></li>
                        <li><a href="{{ route('admin.trainers.create') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/trainers/create') }}">Thêm
                                Huấn luyên viên</a></li>
                    </ul>
                </details>
            </li>

            {{-- Mục chưa có route --}}
            <li><a href="#"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/trials*') }}"><i
                        class="ri-user-add-line"></i>Đăng Ký Tập Thử</a></li>
            <li><a href="{{ route('admin.contacts.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/feedback*') }}"><i
                        class="ri-chat-1-line"></i>Phản Hồi Khách Hàng</a></li>


            <li class="menu-title"><span><i class="ri-mail-line mr-1"></i>Marketing & CSKH</span></li>

            {{-- Chiến Dịch Email --}}
            <li>
                <details
                    {{ is_active(['admin/engagement*', 'admin/email-templates*', 'admin/communication-logs*'], 'open') }}>
                    <summary
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active(['admin/engagement*', 'admin/email-templates*', 'admin/communication-logs*']) }}">
                        <i class="ri-mail-send-line"></i> Chiến Dịch Email
                    </summary>
                    <ul>
                        <li><a href="{{ route('admin.engagement.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/engagement*') }}">Gửi
                                Email Thủ Công</a></li>
                        <li><a href="{{ route('admin.email-templates.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/email-templates*') }}">Quản
                                Lý Mẫu Email</a></li>
                        <li><a href="{{ route('admin.communication-logs.index') }}"
                                class="px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/communication-logs*') }}">Lịch
                                Sử Gửi</a></li>
                    </ul>
                </details>
            </li>

            <li class="menu-title"><span><i class="ri-settings-3-line mr-1"></i>Quản Lý Hệ Thống</span></li>


            <li><a href="{{ route('admin.rfid.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/rfid*') }}"><i
                        class="ri-rfid-line"></i>Quản Lý Thẻ RFID</a></li>
            <li><a href="{{ route('admin.reports.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-base-300 {{ is_active('admin/reports*') }}"><i
                        class="ri-bar-chart-line"></i>Báo Cáo & Thống Kê</a></li>
        </ul>
    </aside>
</div>
