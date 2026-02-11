<x-app-layout>
    @section('header_title', __('Shipping Settings'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="p-8 border-b border-[#8B5E3C]/5 bg-gray-50/30">
            <h3 class="text-xl font-black text-[#4A3728]">{{ __('Update Shipping Cost') }}</h3>
            <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Set the default shipping fee for all orders') }}</p>
        </div>

        <div class="p-8">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-xl">
                @csrf
                <div class="mb-6">
                    <label for="shipping_cost"
                        class="block text-sm font-bold text-[#4A3728] mb-2">{{ __('Default Shipping Fee (Rp)') }}</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-[#8B5E3C]/60 font-bold">Rp</span>
                        <input type="number" name="shipping_cost" id="shipping_cost" value="{{ $shippingCost }}"
                            class="w-full pl-12 rounded-2xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/10 py-3 font-bold text-[#4A3728]"
                            min="0">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-8 py-3 gold-gradient text-white rounded-xl font-bold text-sm shadow-lg shadow-[#D4AF37]/30 hover:scale-105 transition-all">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
