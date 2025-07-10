@extends('admin.layouts.master')
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

                                <!-- Member Selection -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-user-line mr-2"></i>Hội viên
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <select name="member_id" class="select select-bordered select-lg w-full select2-member"
                                        required>
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
                                    <label class="label">
                                        <span class="label-text-alt text-info">
                                            <i class="ri-information-line mr-1"></i>
                                            Có thể tìm kiếm theo tên, số điện thoại hoặc mã thẻ RFID
                                        </span>
                                    </label>
                                </div>

                                <!-- Package Selection -->
                                <div class="form-control mb-6">
                                    <label class="label">
                                        <span class="label-text text-base font-semibold">
                                            <i class="ri-vip-crown-line mr-2"></i>Gói tập
                                            <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($packages as $package)
                                            <div class="package-option">
                                                <input type="radio" id="package-{{ $package->plan_id }}" name="package_id"
                                                    value="{{ $package->plan_id }}" class="package-radio hidden"
                                                    data-price="{{ $package->price }}"
                                                    data-discount="{{ $package->discount_percent }}"
                                                    data-duration="{{ $package->duration_days }}"
                                                    {{ $loop->first ? 'checked' : '' }}>
                                                <label for="package-{{ $package->plan_id }}"
                                                    class="package-label cursor-pointer">
                                                    <div
                                                        class="card package-card border-2 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 {{ $loop->first ? 'border-primary bg-primary/5' : 'border-base-300 hover:border-primary' }}">
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
                                                                        <span class="flex items-center gap-2 font-semibold">
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
                                                                        <span class="flex items-center gap-2 font-semibold">
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
                                        <input class="join-item btn btn-outline flex-1" type="radio" name="payment_method"
                                            value="cash" checked aria-label="Tiền mặt" />
                                        <input class="join-item btn btn-outline flex-1" type="radio" name="payment_method"
                                            value="momo" aria-label="Chuyển khoản MoMo" />
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
            border-color: hsl(var(--p)) !important;
            background-color: hsl(var(--p) / 0.05) !important;
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
    </style>
@endsection
@push('customjs')
    <script>
        $(document).ready(function() {

            $('.select2-member').select2({
                placeholder: "Tìm hội viên theo tên, SĐT hoặc mã RFID...",
                allowClear: true,
                width: '100%',
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    var term = params.term.toLowerCase();
                    var text = data.text.toLowerCase();
                    var $option = $(data.element);
                    var name = ($option.data('name') || '').toString().toLowerCase();
                    var phone = ($option.data('phone') || '').toString().toLowerCase();
                    var rfid = ($option.data('rfid') || '').toString().toLowerCase();

                    if (text.indexOf(term) > -1 ||
                        name.indexOf(term) > -1 ||
                        phone.indexOf(term) > -1 ||
                        rfid.indexOf(term) > -1) {
                        return data;
                    }

                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    if (!data.id) {
                        return data.text;
                    }

                    var $option = $(data.element);
                    var name = $option.text().split(' - ')[0];
                    var phone = $option.data('phone') || '';
                    var rfid = $option.data('rfid') || '';

                    var $result = $('<div>');
                    $result.append('<div class="font-semibold">' + name + '</div>');

                    if (phone) {
                        $result.append('<small class="text-gray-500"><i class="ri-phone-line"></i> ' +
                            phone + '</small>');
                    }

                    if (rfid) {
                        $result.append(
                            '<br><small class="text-blue-600"><i class="ri-bank-card-line"></i> RFID: ' +
                            rfid + '</small>');
                    }

                    return $result;
                },
                templateSelection: function(data) {
                    if (!data.id) {
                        return data.text;
                    }

                    var $option = $(data.element);
                    var name = $option.text().split(' - ')[0];
                    var phone = $option.data('phone') || '';

                    return name + (phone ? ' - ' + phone : '');
                }
            });


            $('.package-label').click(function(e) {
                e.preventDefault();


                $('.package-card').removeClass('border-primary bg-primary/5');
                $('.package-radio').prop('checked', false);


                $(this).find('.package-card').addClass('border-primary bg-primary/5');
                $(this).find('.package-radio').prop('checked', true);


                $(this).find('.package-radio').trigger('change');
            });


            $('.package-radio').change(function() {
                const price = $(this).data('price');
                const discount = $(this).data('discount');
                const duration = $(this).data('duration');

                const total = price * (1 - discount / 100);
                $('#totalAmount').text(total.toLocaleString('vi-VN') + 'đ');

                const startDate = $('input[name="start_date"]').val();
                if (startDate) {
                    const expiryDate = new Date(startDate);
                    expiryDate.setDate(expiryDate.getDate() + parseInt(duration));
                    $('#expiryDate').text(expiryDate.toLocaleDateString('vi-VN'));
                }
            });


            $('input[name="start_date"]').change(function() {
                const duration = $('.package-radio:checked').data('duration');
                const expiryDate = new Date($(this).val());
                expiryDate.setDate(expiryDate.getDate() + parseInt(duration));
                $('#expiryDate').text(expiryDate.toLocaleDateString('vi-VN'));
            });
        });
    </script>
@endpush
