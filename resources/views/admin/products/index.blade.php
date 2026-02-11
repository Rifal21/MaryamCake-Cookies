<x-app-layout>
    @section('header_title', __('Products Inventory'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="px-8 py-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Menu Items') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Manage your cake and cookie selection') }}</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.products.export') }}"
                    class="px-5 py-3 bg-white border border-[#8B5E3C]/10 text-[#8B5E3C] rounded-xl font-bold text-sm shadow-sm hover:bg-[#8B5E3C]/5 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Export') }}
                </a>

                <div class="flex flex-col items-end gap-1">
                    <button type="button" onclick="document.getElementById('import-input').click()"
                        class="px-5 py-3 bg-white border border-[#8B5E3C]/10 text-[#8B5E3C] rounded-xl font-bold text-sm shadow-sm hover:bg-[#8B5E3C]/5 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        {{ __('Import') }}
                    </button>
                    <a href="{{ route('admin.products.template') }}"
                        class="text-[10px] text-[#D4AF37] font-bold hover:underline">
                        {{ __('Download Template') }}
                    </a>
                </div>
                <form id="import-form" action="{{ route('admin.products.import') }}" method="POST"
                    enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" name="file" id="import-input"
                        onchange="document.getElementById('import-form').submit()">
                </form>

                <a href="{{ route('admin.products.create') }}"
                    class="px-6 py-3 gold-gradient text-white rounded-xl font-bold text-sm shadow-lg shadow-[#D4AF37]/30 hover:scale-105 transition-all">
                    + {{ __('New Product') }}
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 uppercase text-[10px] font-black tracking-widest text-[#8B5E3C]/60">
                        <th class="px-8 py-4 text-left">{{ __('Product') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Category') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Price') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Stock') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Status') }}</th>
                        <th class="px-8 py-4 text-right pr-12">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#8B5E3C]/5">
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div
                                        class="w-14 h-14 rounded-2xl overflow-hidden mr-4 shadow-sm border border-[#8B5E3C]/10 flex-shrink-0 flex items-center justify-center bg-[#8B5E3C]/5">
                                        @if ($product->image && $product->image !== 'images/products/default.jpg' && file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-cookie-bite text-[#D4AF37] text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-[#4A3728]">{{ $product->name }}</span>
                                            @if ($product->is_premium)
                                                <span
                                                    class="bg-[#D4AF37] text-white text-[8px] font-black px-1.5 py-0.5 rounded uppercase tracking-tighter shadow-sm shadow-[#D4AF37]/20">
                                                    {{ __('Premium') }}
                                                </span>
                                            @endif
                                        </div>
                                        <span
                                            class="text-[10px] text-[#8B5E3C]/50">{{ Str::limit($product->description, 40) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="px-3 py-1 bg-[#8B5E3C]/5 text-[#8B5E3C] rounded-full text-[10px] font-black uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <span
                                        class="font-bold {{ $product->stock < 10 ? 'text-red-500' : 'text-[#4A3728]' }}">{{ $product->stock }}</span>
                                    @if ($product->stock < 10)
                                        <span class="ml-2 w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span
                                    class="flex items-center text-[10px] font-bold uppercase tracking-widest {{ $product->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                    <span
                                        class="w-2 h-2 rounded-full mr-2 {{ $product->is_active ? 'bg-green-600' : 'bg-gray-400' }}"></span>
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right pr-12 space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirmDelete(event, 'Archive this product?')"
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
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
