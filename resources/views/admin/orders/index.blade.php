<x-app-layout>
    @section('header_title', __('Customer Orders'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="px-8 py-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Order History') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Monitor and process incoming cake orders') }}</p>
            </div>
            <div class="flex space-x-2">
                <span
                    class="px-4 py-2 bg-white rounded-xl border border-[#8B5E3C]/10 text-xs font-bold">{{ __('Total:') }}
                    {{ $orders->total() }}</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 uppercase text-[10px] font-black tracking-widest text-[#8B5E3C]/60">
                        <th class="px-8 py-4 text-left">{{ __('Order ID') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Customer Information') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Total Payment') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Current Status') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Placement Date') }}</th>
                        <th class="px-8 py-4 text-right pr-12">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#8B5E3C]/5">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="text-sm font-black text-blue-600 block">{{ $order->order_number }}</span>
                                <span class="text-[10px] opacity-50 uppercase tracking-widest">ID:
                                    #{{ $order->id }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full gold-gradient flex items-center justify-center text-white text-xs font-black mr-3 shadow-md">
                                        {{ substr($order->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span
                                            class="block font-bold text-[#4A3728] text-sm">{{ $order->customer_name }}</span>
                                        <span
                                            class="text-[10px] text-[#8B5E3C]/60 italic">{{ $order->customer_phone }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-black">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : '' }}
                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                                {{ $order->status == 'shipping' ? 'bg-purple-100 text-purple-700 border border-purple-200' : '' }}
                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}
                            ">
                                    {{ __(ucfirst($order->status)) }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="text-sm text-[#8B5E3C]/70 block">{{ $order->created_at->format('d M Y') }}</span>
                                <span
                                    class="text-[10px] text-[#8B5E3C]/40">{{ $order->created_at->format('H:i A') }}</span>
                            </td>
                            <td class="px-8 py-5 text-right pr-12">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center px-4 py-2 border border-[#8B5E3C]/20 rounded-xl text-xs font-bold text-[#8B5E3C] hover:bg-[#8B5E3C] hover:text-white transition-all shadow-sm">
                                    {{ __('Order Details') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50/50 border-t border-[#8B5E3C]/5">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
