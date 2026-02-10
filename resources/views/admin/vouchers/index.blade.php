<x-app-layout>
    @section('header_title', __('Voucher Codes'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="px-8 py-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Active Vouchers') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Manage your discount campaigns') }}</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.vouchers.create') }}"
                    class="px-6 py-3 gold-gradient text-white rounded-xl font-bold text-sm shadow-lg shadow-[#D4AF37]/30 hover:scale-105 transition-all">
                    + {{ __('New Voucher') }}
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 uppercase text-[10px] font-black tracking-widest text-[#8B5E3C]/60">
                        <th class="px-8 py-4 text-left">{{ __('Code') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Type') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Value') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Min Spend') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Usage') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Status') }}</th>
                        <th class="px-8 py-4 text-right pr-12">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#8B5E3C]/5">
                    @foreach ($vouchers as $voucher)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span
                                    class="font-bold text-[#4A3728] text-lg tracking-wider">{{ $voucher->code }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="px-3 py-1 bg-[#8B5E3C]/5 text-[#8B5E3C] rounded-full text-[10px] font-black uppercase tracking-wider">
                                    {{ ucfirst($voucher->type) }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-bold">
                                    {{ $voucher->type === 'percentage' ? $voucher->value . '%' : 'Rp ' . number_format($voucher->value, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-sm">Rp {{ number_format($voucher->min_spend, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5 text-sm">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#4A3728]">{{ $voucher->used_count }} /
                                        {{ $voucher->max_uses ?? '∞' }}</span>
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                        @php
                                            $percent = $voucher->max_uses
                                                ? ($voucher->used_count / $voucher->max_uses) * 100
                                                : 0;
                                        @endphp
                                        <div class="h-full bg-[#D4AF37]" style="width: {{ min(100, $percent) }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @php
                                    $status = $voucher->status;
                                    $colorClass = match ($status) {
                                        'Active' => 'text-green-600',
                                        'Scheduled' => 'text-blue-500',
                                        'Expired', 'Inactive' => 'text-red-400',
                                        'Limit Reached' => 'text-orange-500',
                                        default => 'text-gray-400',
                                    };
                                    $dotClass = match ($status) {
                                        'Active' => 'bg-green-600',
                                        'Scheduled' => 'bg-blue-500',
                                        'Expired', 'Inactive' => 'bg-red-400',
                                        'Limit Reached' => 'bg-orange-500',
                                        default => 'bg-gray-400',
                                    };
                                @endphp
                                <span
                                    class="flex items-center text-[10px] font-bold uppercase tracking-widest {{ $colorClass }}">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ $dotClass }}"></span>
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right pr-12 space-x-3">
                                <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this voucher?')"
                                        class="inline-flex items-center justify-center p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-8 py-6 bg-gray-50/50 border-t border-[#8B5E3C]/5">
            {{ $vouchers->links() }}
        </div>
    </div>
</x-app-layout>
