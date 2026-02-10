<x-app-layout>
    @section('header_title', __('Create New Voucher'))

    <div class="max-w-4xl mx-auto">
        <div class="card-premium rounded-[2.5rem] overflow-hidden">
            <div class="px-10 py-8 border-b border-[#8B5E3C]/5 bg-gray-50/30">
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Voucher Details') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Define your discount rules') }}</p>
            </div>

            <form action="{{ route('admin.vouchers.store') }}" method="POST" class="p-10 space-y-8">
                @csrf
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Voucher Code') }}</label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold tracking-widest uppercase placeholder:normal-case placeholder:font-normal"
                            placeholder="E.g. MARYAMSAVE10">
                        @error('code')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Voucher Type') }}</label>
                        <select name="type" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold">
                            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)
                            </option>
                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage
                                (%)</option>
                        </select>
                        @error('type')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Value') }}</label>
                        <input type="number" step="0.01" name="value" value="{{ old('value') }}" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold">
                        @error('value')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Minimum Spend') }}</label>
                        <input type="number" step="0.01" name="min_spend" value="{{ old('min_spend', 0) }}"
                            required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold">
                        @error('min_spend')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Start Date') }}</label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('End Date') }}</label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold">
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Max Usage') }}</label>
                        <input type="number" name="max_uses" value="{{ old('max_uses') }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold"
                            placeholder="Leave blank for unlimited">
                    </div>

                    <div class="flex items-center space-x-3 pt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-[#D4AF37] border-[#8B5E3C]/20 focus:ring-[#D4AF37]">
                        <label for="is_active"
                            class="text-sm font-bold text-[#4A3728] uppercase tracking-widest">{{ __('Is Active') }}</label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-8 border-t border-[#8B5E3C]/5">
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="px-8 py-4 bg-white border border-[#8B5E3C]/10 text-[#8B5E3C] rounded-2xl font-bold hover:bg-[#8B5E3C]/5 transition-all">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="px-10 py-4 gold-gradient text-white rounded-2xl font-black shadow-lg shadow-[#D4AF37]/30 hover:scale-[1.02] transition-all">
                        {{ __('Create Voucher') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
