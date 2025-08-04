@extends('admin.layouts.master')
@section('page_title', 'Bảng Điều Khiển')

@section('breadcrumbs')
    <li><a href="{{ route('home') }}" class="link link-hover">Admin</a></li>
    <li><a href="#" class="link link-hover">Đăng ký gói tập </a></li>

@endsection
@section('content')
    <div class="p-6">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <!-- Header Card -->
                    <div class="card bg-white shadow-xl mb-8">
                        <div class="card-body">
                            <div class="flex items-center gap-3">
                                <div class="avatar placeholder">
                                    <div class="bg-primary text-primary-content rounded-full w-12">
                                        <i class="ri-account-pin-box-line text-xl"></i>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-800">Đăng ký gói tập</h1>
                                    <p class="text-gray-600">Chọn gói tập phù hợp cho hội viên</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Form -->
                    <div class="card bg-white shadow-xl">
                        <div class="card-body">
                            <form id="registerPackageForm" action="{{ route('admin.subscriptions.store') }}" method="POST">
                                @csrf

                                <!-- Quick Search Section -->
                                <div class="card bg-base-100 border-2 border-dashed border-primary/30 mb-6">
                                    <div class="card-body">
                                        <h3 class="card-title text-primary mb-4">
                                            <i class="ri-search-line mr-2"></i>Tìm kiếm nhanh hội viên
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- RFID Search -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold">
                                                        <i class="ri-nfc-line mr-2"></i>Quét thẻ RFID
                                                    </span>
                                                </label>
                                                <div class="join">
                                                    <input type="text" id="rfidSearch"
                                                        placeholder="Quét hoặc nhập mã RFID..."
                                                        class="input input-bordered join-item flex-1" autocomplete="off">
                                                    <button type="button" id="clearRfid" class="btn btn-outline join-item">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                                <label class="label">
                                                    <span class="label-text-alt text-info">
                                                        <i class="ri-information-line mr-1"></i>
                                                        Đặt con trỏ vào ô và quét thẻ RFID
                                                    </span>
                                                </label>
                                            </div>

                                            <!-- Phone Search -->
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-semibold">
                                                        <i class="ri-phone-line mr-2"></i>Tìm theo SĐT
                                                    </span>
                                                </label>
                                                <div class="join">
                                                    <input type="text" id="phoneSearch"
                                                        placeholder="Nhập số điện thoại..."
                                                        class="input input-bordered join-item flex-1">
                                                    <button type="button" id="clearPhone"
                                                        class="btn btn-outline join-item">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>
                                                <label class="label">
                                                    <span class="label-text-alt text-info">
                                                        <i class="ri-information-line mr-1"></i>
                                                        Nhập ít nhất 3 chữ số để tìm kiếm
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Search Results -->
                                        <div id="searchResults" class="mt-4 hidden">
                                            <div class="divider">
                                                <span class="text-primary font-semibold">Kết quả tìm kiếm</span>
                                            </div>
                                            <div id="searchResultsList" class="space-y-2 max-h-60 overflow-y-auto">
                                                <!-- Results will be populated here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Member Selection -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-user-line mr-2"></i>Hội viên được chọn
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>

                                    <!-- Selected Member Display -->
                                    <div id="selectedMemberCard"
                                        class="card bg-success/10 border-2 border-success/30 hidden mb-4">
                                        <div class="card-body py-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar placeholder">
                                                        <div class="bg-success text-success-content rounded-full w-10">
                                                            <i class="ri-user-line"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-success" id="selectedMemberName"></div>
                                                        <div class="text-sm opacity-75" id="selectedMemberInfo"></div>
                                                    </div>
                                                </div>
                                                <button type="button" id="clearSelection"
                                                    class="btn btn-sm btn-outline btn-error">
                                                    <i class="ri-close-line mr-1"></i>Bỏ chọn
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden input for selected member -->
                                    <input type="hidden" name="member_id" id="selectedMemberId" required>

                                    <!-- Traditional dropdown (fallback) -->
                                    <select name="member_id_fallback"
                                        class="select select-bordered select-lg w-full select2-member hidden">
                                        <option value="">-- Chọn hội viên --</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->member_id }}"
                                                data-name="{{ strtolower($member->full_name) }}"
                                                data-phone="{{ $member->phone }}" data-rfid="{{ $member->rfid_card_id }}">
                                                {{ $member->full_name }} - {{ $member->phone }}
                                                @if ($member->rfid_card_id)
                                                    - RFID: {{ $member->rfid_card_id }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    <div id="noMemberSelected" class="alert alert-warning mt-2">
                                        <i class="ri-alert-line mr-2"></i>
                                        <span>Vui lòng tìm kiếm và chọn hội viên bằng thẻ RFID hoặc số điện thoại ở phía
                                            trên</span>
                                    </div>
                                </div>

                                <!-- Package Selection -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-vip-crown-line mr-2"></i>Gói tập
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    @error('package_id')
                                        <div class="alert alert-error mt-2 mb-4">
                                            <i class="ri-error-warning-line mr-2"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($packages as $package)
                                            <div class="package-option">
                                                <input type="radio" id="package-{{ $package->plan_id }}"
                                                    name="package_id" value="{{ $package->plan_id }}"
                                                    class="package-radio hidden" data-price="{{ $package->price }}"
                                                    data-discount="{{ $package->discount_percent }}"
                                                    data-duration="{{ $package->duration_days }}">
                                                <label for="package-{{ $package->plan_id }}"
                                                    class="package-label cursor-pointer">
                                                    <div
                                                        class="card package-card border-2 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                                        <div class="card-body relative">
                                                            <!-- Selected Indicator -->
                                                            <div
                                                                class="selected-indicator absolute top-4 right-4 w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white opacity-0 transition-opacity duration-300">
                                                                <i class="ri-check-line text-sm"></i>
                                                            </div>

                                                            <!-- Package Header -->
                                                            <div class="text-center mb-4">
                                                                <h3
                                                                    class="text-lg font-bold text-primary flex items-center justify-center gap-2">
                                                                    <i class="ri-vip-crown-line"></i>
                                                                    {{ $package->plan_name }}
                                                                </h3>
                                                            </div>

                                                            <!-- Package Details -->
                                                            <div class="space-y-3">
                                                                <div class="flex justify-between items-center">
                                                                    <span class="flex items-center gap-2 text-gray-600">
                                                                        <i class="ri-time-line"></i>
                                                                        Thời hạn:
                                                                    </span>
                                                                    <span
                                                                        class="font-semibold">{{ $package->duration_days }}
                                                                        ngày</span>
                                                                </div>

                                                                <div class="flex justify-between items-center">
                                                                    <span class="flex items-center gap-2 text-gray-600">
                                                                        <i class="ri-money-dollar-circle-line"></i>
                                                                        Giá gốc:
                                                                    </span>
                                                                    <span
                                                                        class="font-semibold">{{ number_format($package->price) }}đ</span>
                                                                </div>

                                                                @if ($package->discount_percent > 0)
                                                                    <div
                                                                        class="flex justify-between items-center text-success">
                                                                        <span class="flex items-center gap-2">
                                                                            <i class="ri-discount-percent-line"></i>
                                                                            Giảm giá:
                                                                        </span>
                                                                        <span
                                                                            class="font-semibold">{{ $package->discount_percent }}%</span>
                                                                    </div>

                                                                    <div class="divider my-2"></div>

                                                                    <div
                                                                        class="flex justify-between items-center text-error">
                                                                        <span
                                                                            class="flex items-center gap-2 font-semibold">
                                                                            <i class="ri-price-tag-3-line"></i>
                                                                            Thành tiền:
                                                                        </span>
                                                                        <span class="text-lg font-bold">
                                                                            {{ number_format($package->price * (1 - $package->discount_percent / 100)) }}đ
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div class="divider my-2"></div>

                                                                    <div
                                                                        class="flex justify-between items-center text-primary">
                                                                        <span
                                                                            class="flex items-center gap-2 font-semibold">
                                                                            <i class="ri-price-tag-3-line"></i>
                                                                            Thành tiền:
                                                                        </span>
                                                                        <span
                                                                            class="text-lg font-bold">{{ number_format($package->price) }}đ</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-bank-card-line mr-2"></i>Phương thức thanh toán
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <div class="join w-full">
                                        <input class="join-item btn btn-outline flex-1" type="radio"
                                            name="payment_method" value="cash" checked aria-label="Tiền mặt" />
                                        <input class="join-item btn btn-outline flex-1" type="radio"
                                            name="payment_method" value="vnpay" aria-label="Chuyển khoản VNPAY" />
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-calendar-line mr-2"></i>Ngày bắt đầu
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <input type="date" name="start_date" class="input input-bordered input-lg w-full"
                                        value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                </div>

                                <!-- Payment Summary -->
                                <div class="alert alert-info shadow-lg mb-6">
                                    <div class="flex w-full justify-between items-center">
                                        <div>
                                            <h3 class="font-bold text-lg">Tổng cộng</h3>
                                            <div class="text-xs opacity-75">
                                                <i class="ri-calendar-check-line mr-1"></i>
                                                Ngày hết hạn: <span
                                                    id="expiryDate">{{ date('d/m/Y', strtotime('+' . $packages[0]->duration_days . ' days')) }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-error" id="totalAmount">
                                                {{ number_format($packages[0]->price * (1 - $packages[0]->discount_percent / 100)) }}đ
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-4 justify-end">
                                    <button type="reset" class="btn btn-outline btn-lg">
                                        <i class="ri-eraser-line mr-2"></i>
                                        Nhập lại
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="ri-check-line mr-2"></i>
                                        Xác nhận đăng ký
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .package-card.border-primary {
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
        }

        .package-radio:checked+.package-label .package-card {
            border-color: #dc2626 !important;
            background-color: rgba(220, 38, 38, 0.05) !important;
        }

        .package-radio:checked+.package-label .selected-indicator {
            opacity: 1;
        }

        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid hsl(var(--bc) / 0.2) !important;
            border-radius: 8px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 46px !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
        }

        .select2-dropdown {
            border: 1px solid hsl(var(--bc) / 0.2) !important;
            border-radius: 8px !important;
        }

        .search-result-item {
            transition: all 0.2s ease;
        }

        .search-result-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #rfidSearch {
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }
    </style>
@endsection

@push('customjs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            const members = @json($membersJson);

            let selectedMember = null;

            // Initialize
            updateSummary();
            updateSubmitButton();

            // RFID Search functionality
            $('#rfidSearch').on('input', function() {
                const rfidValue = $(this).val().trim();
                if (rfidValue.length >= 3) {
                    searchByRfid(rfidValue);
                } else {
                    hideSearchResults();
                }
            });

            // Phone Search functionality
            $('#phoneSearch').on('input', function() {
                const phoneValue = $(this).val().trim();
                if (phoneValue.length >= 3) {
                    searchByPhone(phoneValue);
                } else {
                    hideSearchResults();
                }
            });

            // Clear buttons
            $('#clearRfid').click(function() {
                $('#rfidSearch').val('').focus();
                hideSearchResults();
            });

            $('#clearPhone').click(function() {
                $('#phoneSearch').val('').focus();
                hideSearchResults();
            });

            // Clear selection
            $('#clearSelection').click(function() {
                clearSelectedMember();
            });

            // Search by RFID
            function searchByRfid(rfidValue) {
                const results = members.filter(member =>
                    member.rfid && member.rfid.toLowerCase().includes(rfidValue.toLowerCase())
                );
                displaySearchResults(results, 'RFID');
            }

            // Search by Phone
            function searchByPhone(phoneValue) {
                const results = members.filter(member =>
                    member.phone && member.phone.includes(phoneValue)
                );
                displaySearchResults(results, 'Số điện thoại');
            }

            // Display search results
            function displaySearchResults(results, searchType) {
                const resultsContainer = $('#searchResultsList');
                resultsContainer.empty();

                if (results.length === 0) {
                    resultsContainer.html(`
                        <div class="alert alert-warning">
                            <i class="ri-search-line mr-2"></i>
                            <span>Không tìm thấy hội viên nào với ${searchType} này</span>
                        </div>
                    `);
                } else {
                    results.forEach(member => {
                        const memberCard = createMemberCard(member);
                        resultsContainer.append(memberCard);
                    });
                }

                $('#searchResults').removeClass('hidden');
            }

            // Create member card for search results
            function createMemberCard(member) {
                return $(`
                    <div class="card bg-base-100 border search-result-item cursor-pointer hover:bg-base-200"
                         data-member-id="${member.id}">
                        <div class="card-body py-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-primary text-primary-content rounded-full w-10">
                                            <i class="ri-user-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">${member.name}</div>
                                        <div class="text-sm opacity-75">
                                            <i class="ri-phone-line mr-1"></i>${member.phone}
                                            ${member.rfid ? `<span class="ml-2"><i class="ri-nfc-line mr-1"></i>${member.rfid}</span>` : ''}
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary select-member-btn">
                                    <i class="ri-check-line mr-1"></i>Chọn
                                </button>
                            </div>
                        </div>
                    </div>
                `).on('click', function() {
                    selectMember(member);
                });
            }

            // Select member
            function selectMember(member) {
                selectedMember = member;

                // Update hidden input
                $('#selectedMemberId').val(member.id);

                // Update selected member display
                $('#selectedMemberName').text(member.name);
                $('#selectedMemberInfo').html(`
                    <i class="ri-phone-line mr-1"></i>${member.phone}
                    ${member.rfid ? `<span class="ml-2"><i class="ri-nfc-line mr-1"></i>${member.rfid}</span>` : ''}
                `);

                // Show selected member card
                $('#selectedMemberCard').removeClass('hidden');
                $('#noMemberSelected').addClass('hidden');

                // Clear search
                $('#rfidSearch').val('');
                $('#phoneSearch').val('');
                hideSearchResults();

                // Update submit button
                updateSubmitButton();

                // Show success toast
                showToast('success', `Đã chọn hội viên: ${member.name}`);
            }

            // Clear selected member
            function clearSelectedMember() {
                selectedMember = null;
                $('#selectedMemberId').val('');
                $('#selectedMemberCard').addClass('hidden');
                $('#noMemberSelected').removeClass('hidden');
                updateSubmitButton();
                showToast('info', 'Đã bỏ chọn hội viên');
            }

            // Hide search results
            function hideSearchResults() {
                $('#searchResults').addClass('hidden');
            }

            // Update submit button state
            function updateSubmitButton() {
                const submitBtn = $('#submitBtn');
                if (selectedMember) {
                    submitBtn.prop('disabled', false).removeClass('btn-disabled');
                } else {
                    submitBtn.prop('disabled', true).addClass('btn-disabled');
                }
            }

            // Show toast notification
            function showToast(type, message) {
                const toastClass = type === 'success' ? 'alert-success' :
                    type === 'error' ? 'alert-error' : 'alert-info';

                const toast = $(`
                    <div class="toast toast-top toast-end z-50">
                        <div class="alert ${toastClass}">
                            <span>${message}</span>
                        </div>
                    </div>
                `);

                $('body').append(toast);

                setTimeout(() => {
                    toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Package selection and summary update
            $('.package-radio').on('change', function() {
                updateSummary();
            });

            $('input[name="start_date"]').on('change', function() {
                updateSummary();
            });

            // Select first package by default
            const firstPackage = $('.package-radio').first();
            if (firstPackage.length && !$('.package-radio:checked').length) {
                firstPackage.prop('checked', true).trigger('change');
            }

            function updateSummary() {
                const selectedPackage = $('.package-radio:checked');

                if (selectedPackage.length === 0) return;

                const price = parseFloat(selectedPackage.data('price')) || 0;
                const discount = parseFloat(selectedPackage.data('discount')) || 0;
                const duration = parseInt(selectedPackage.data('duration')) || 0;

                const finalAmount = Math.round(price * (1 - discount / 100));
                $('#totalAmount').text(finalAmount.toLocaleString('vi-VN') + 'đ');

                const startDate = $('input[name="start_date"]').val();
                if (startDate) {
                    const expiry = new Date(startDate);
                    expiry.setDate(expiry.getDate() + duration);
                    const formattedExpiry = expiry.toLocaleDateString('vi-VN');
                    $('#expiryDate').text(formattedExpiry);
                } else {
                    $('#expiryDate').text('Chưa chọn ngày');
                }
            }

            // Form validation before submit
            $('#registerPackageForm').on('submit', function(e) {
                if (!selectedMember) {
                    e.preventDefault();
                    showToast('error', 'Vui lòng chọn hội viên trước khi đăng ký gói tập');
                    return false;
                }
            });

            // Auto-focus on RFID input for quick scanning
            $('#rfidSearch').focus();

            // Handle RFID scanner input (usually ends with Enter)
            $('#rfidSearch').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    const rfidValue = $(this).val().trim();
                    if (rfidValue) {
                        // Try to find exact match first
                        const exactMatch = members.find(member =>
                            member.rfid && member.rfid.toLowerCase() === rfidValue.toLowerCase()
                        );

                        if (exactMatch) {
                            selectMember(exactMatch);
                        } else {
                            searchByRfid(rfidValue);
                        }
                    }
                }
            });
        });
    </script>
@endpush
