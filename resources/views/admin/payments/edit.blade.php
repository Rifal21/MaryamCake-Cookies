<x-app-layout>
    @section('header_title', __('Edit Payment Method'))

    <div class="max-w-4xl mx-auto">
        <div class="card-premium rounded-[2.5rem] overflow-hidden">
            <div class="px-10 py-8 border-b border-[#8B5E3C]/5 bg-gray-50/30">
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Payment Details') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Update your payment gateway information') }}</p>
            </div>

            <form action="{{ route('admin.payments.update', $paymentMethod) }}" method="POST" class="p-10 space-y-8">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Method Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold"
                            placeholder="E.g. DANA, SeaBank, BNI, COD">
                        @error('name')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Account Holder Name') }}</label>
                        <input type="text" name="account_name"
                            value="{{ old('account_name', $paymentMethod->account_name) }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold"
                            placeholder="E.g. Maryam Cake & Cookies Store">
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Account Number') }}</label>
                        <input type="text" name="account_number"
                            value="{{ old('account_number', $paymentMethod->account_number) }}"
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold"
                            placeholder="E.g. 0812345678 or 1234567890">
                    </div>

                    <div class="space-y-2">
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Admin Fee') }}</label>
                        <input type="number" name="admin_fee"
                            value="{{ old('admin_fee', $paymentMethod->admin_fee) }}" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-bold"
                            placeholder="0">
                        @error('admin_fee')
                            <p class="text-xs text-red-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center space-x-3 pt-6">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="is_active"
                            {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 rounded text-[#D4AF37] border-[#8B5E3C]/20 focus:ring-[#D4AF37]">
                        <label for="is_active"
                            class="text-sm font-bold text-[#4A3728] uppercase tracking-widest">{{ __('Is Active') }}</label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Instructions') }}</label>
                    <textarea name="instructions" rows="4"
                        class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 px-6 py-4 font-medium"
                        placeholder="Instructions for user after checkout">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                </div>

                <div class="flex justify-end gap-4 pt-8 border-t border-[#8B5E3C]/5">
                    <a href="{{ route('admin.payments.index') }}"
                        class="px-8 py-4 bg-white border border-[#8B5E3C]/10 text-[#8B5E3C] rounded-2xl font-bold hover:bg-[#8B5E3C]/5 transition-all">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="px-10 py-4 gold-gradient text-white rounded-2xl font-black shadow-lg shadow-[#D4AF37]/30 hover:scale-[1.02] transition-all">
                        {{ __('Update Payment Method') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
