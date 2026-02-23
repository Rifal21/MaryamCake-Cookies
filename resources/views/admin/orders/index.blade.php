<x-app-layout>
    @section('header_title', __('Customer Orders'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="px-8 py-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Order History') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Monitor and process incoming cake orders') }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <span
                    class="px-4 py-2 bg-white rounded-xl border border-[#8B5E3C]/10 text-xs font-bold">{{ __('Total:') }}
                    {{ $orders->total() }}</span>
                @if (isset($mode) && $mode == 'trashed')
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-[#8B5E3C] text-white rounded-xl text-xs font-bold hover:bg-[#6A462D] transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Back to Orders') }}
                    </a>
                @else
                    <a href="{{ route('admin.orders.trashed') }}"
                        class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition-all border border-red-100 shadow-sm group">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        {{ __('Trash') }}
                        @php $trashedCount = \App\Models\Order::onlyTrashed()->count(); @endphp
                        @if ($trashedCount > 0)
                            <span
                                class="ml-2 px-1.5 py-0.5 bg-red-600 text-white text-[8px] rounded-full">{{ $trashedCount }}</span>
                        @endif
                    </a>
                @endif
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
                                @if ($order->is_preorder)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest bg-orange-100 text-orange-600 border border-orange-200 mb-1">
                                        📦 Pre-Order
                                    </span>
                                @endif
                                <span class="text-[10px] opacity-50 uppercase tracking-widest block">ID:
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
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank"
                                        title="{{ __('Download Invoice') }}"
                                        class="inline-flex items-center p-2 bg-[#8B5E3C]/10 text-[#8B5E3C] rounded-xl hover:bg-[#8B5E3C] hover:text-white transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex items-center px-4 py-2 border border-[#8B5E3C]/20 rounded-xl text-xs font-bold text-[#8B5E3C] hover:bg-[#8B5E3C] hover:text-white transition-all shadow-sm">
                                        {{ __('Order Details') }}
                                    </a>
                                    @if ($order->trashed())
                                        <form action="{{ route('admin.orders.restore', $order) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" title="{{ __('Restore') }}"
                                                class="inline-flex items-center p-2 bg-green-50 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all shadow-sm border border-green-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                            class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmForceDeleteOrder(this)"
                                                title="{{ __('Delete Permanently') }}"
                                                class="inline-flex items-center p-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all shadow-sm border border-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                            class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDeleteOrder(this)"
                                                title="{{ __('Soft Delete') }}"
                                                class="inline-flex items-center p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
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
    <script>
        function confirmDeleteOrder(button) {
            Swal.fire({
                title: '{{ __('Hapus Pesanan?') }}',
                text: '{{ __('Pesanan akan dipindahkan ke tempat sampah (Soft Delete).') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8B5E3C',
                confirmButtonText: '{{ __('Ya, Hapus!') }}',
                cancelButtonText: '{{ __('Batal') }}',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        function confirmForceDeleteOrder(button) {
            Swal.fire({
                title: '{{ __('Hapus Permanen?') }}',
                text: '{{ __('Tindakan ini tidak dapat dibatalkan!') }}',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8B5E3C',
                confirmButtonText: '{{ __('Ya, Hapus Selamanya!') }}',
                cancelButtonText: '{{ __('Batal') }}',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
</x-app-layout>
