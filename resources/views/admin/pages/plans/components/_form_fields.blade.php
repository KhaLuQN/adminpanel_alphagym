<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    {{-- Cột thông tin chính --}}
    <div class="xl:col-span-3 space-y-6">
        {{-- Card thông tin cơ bản --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Thông tin cơ bản
                </h3>

                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Tên gói tập <span
                                    class="text-error">*</span></span>
                        </label>
                        <input type="text" name="plan_name" placeholder="Ví dụ: Gói Premium 3 tháng"
                            class="input input-bordered focus:input-primary"
                            value="{{ old('plan_name', $plan->plan_name ?? '') }}" required>

                        @error('plan_name')
                            <span class="text-error text-sm mt-1 block">{{ $message }}</span>
                        @enderror

                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Tên gói sẽ hiển thị cho khách hàng</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Mô tả gói tập</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered focus:textarea-primary h-28"
                            placeholder="Mô tả chi tiết về những gì khách hàng sẽ nhận được khi đăng ký gói này...">{{ old('description', $plan->description ?? '') }}</textarea>
                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Mô tả sẽ giúp khách hàng hiểu rõ hơn về
                                gói tập</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card thông tin giá cả và thời hạn --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                        </path>
                    </svg>
                    Giá cả & Thời hạn
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Thời hạn <span
                                    class="text-error">*</span></span>
                        </label>
                        <div class="relative">
                            <input type="number" name="duration_days" placeholder="30"
                                class="input input-bordered focus:input-primary pr-16"
                                value="{{ old('duration_days', $plan->duration_days ?? '') }}" min="1" required>
                            @error('duration_days')
                                <span class="text-error text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                            <span
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 text-sm">ngày</span>
                        </div>
                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Số ngày có hiệu lực của gói</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Giá gốc <span
                                    class="text-error">*</span></span>
                        </label>
                        <div class="relative">
                            <input type="number" name="price" placeholder="1500000"
                                class="input input-bordered focus:input-primary pr-16"
                                value="{{ old('price', $plan->price ?? '') }}" min="0" required>
                            <span
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 text-sm">VNĐ</span>
                        </div>
                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Giá niêm yết chưa giảm</span>
                        </label>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-base">Giảm giá</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="discount_percent" placeholder="0"
                                class="input input-bordered focus:input-primary pr-8"
                                value="{{ old('discount_percent', $plan->discount_percent ?? '0') }}" min="0"
                                max="100">
                            <span
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-base-content/60 text-sm">%</span>
                        </div>
                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Để trống hoặc 0 nếu không giảm giá</span>
                        </label>
                    </div>
                </div>

                {{-- Hiển thị giá sau giảm --}}
                <div class="mt-4 p-4 bg-success/10 rounded-lg border border-success/20">
                    <div class="flex items-center justify-between">
                        <span class="text-base-content/70">Giá sau khi giảm:</span>
                        <span class="text-xl font-bold text-success" id="final-price">0 VNĐ</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card trạng thái --}}
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                        </path>
                    </svg>
                    Cài đặt trạng thái
                </h3>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-4">
                        <input type="checkbox" name="is_active" value="1"
                            class="checkbox checkbox-primary checkbox-lg"
                            @if (old('is_active', $plan->is_active ?? true)) checked @endif />
                        <div class="flex flex-col">
                            <span class="label-text font-semibold text-base">Kích hoạt gói tập này</span>
                            <span class="label-text-alt text-base-content/60">Gói sẽ hiển thị cho khách hàng có thể
                                đăng ký</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Cột quyền lợi --}}
    <div class="xl:col-span-1">
        <div class="card bg-base-100 border border-base-300 shadow-sm sticky top-6">
            <div class="card-body">
                <h3 class="card-title text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Quyền lợi đi kèm
                </h3>

                <div class="text-sm text-base-content/60 mb-4">
                    Chọn các quyền lợi mà khách hàng sẽ nhận được khi đăng ký gói này
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach ($features as $feature)
                        @php
                            $currentFeature = isset($planFeatures) ? $planFeatures->get($feature->feature_id) : null;
                            $isChecked = old("features.{$feature->feature_id}.id", $currentFeature) ? 'checked' : '';
                            $currentValue = old(
                                "features.{$feature->feature_id}.value",
                                $currentFeature->pivot->feature_value ?? '',
                            );
                        @endphp
                        <div class="p-3 border border-base-300 rounded-lg hover:bg-base-200/50 transition-colors">
                            <div class="form-control">

                                <label class="label cursor-pointer justify-start gap-3 p-0">
                                    <input type="checkbox" name="features[{{ $feature->feature_id }}][id]"
                                        value="{{ $feature->feature_id }}"
                                        class="checkbox checkbox-primary checkbox-sm" {{ $isChecked }}>
                                    @error("features.{$feature->feature_id}.id")
                                        <span class="text-error text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <span class="label-text font-medium">{{ $feature->name }}</span>
                                </label>
                                <input type="text" name="features[{{ $feature->feature_id }}][value]"
                                    placeholder="Giá trị (ví dụ: 5 lần/tuần)"
                                    class="input input-bordered input-sm mt-2 focus:input-primary"
                                    value="{{ $currentValue }}">
                                @error("features.{$feature->feature_id}.value")
                                    <span class="text-error text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="mt-4 p-3 bg-info/10 rounded-lg border border-info/20">
                    <div class="text-sm text-info">
                        <strong>Lưu ý:</strong> Giá trị có thể là số lượng, thời gian hoặc mô tả chi tiết về quyền lợi.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom styles --}}
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: hsl(var(--b2));
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: hsl(var(--bc) / 0.3);
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: hsl(var(--bc) / 0.5);
    }
</style>

{{-- JavaScript để tính giá sau khi giảm --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.querySelector('input[name="price"]');
        const discountInput = document.querySelector('input[name="discount_percent"]');
        const finalPriceElement = document.getElementById('final-price');

        function calculateFinalPrice() {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const finalPrice = price - (price * discount / 100);

            finalPriceElement.textContent = new Intl.NumberFormat('vi-VN').format(finalPrice) + ' VNĐ';
        }

        priceInput.addEventListener('input', calculateFinalPrice);
        discountInput.addEventListener('input', calculateFinalPrice);

        // Tính giá ban đầu
        calculateFinalPrice();
    });
</script>
