<x-app-layout>
    @section('header_title', __('Refine Premium Treat'))

    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center text-sm font-bold text-[#8B5E3C] hover:text-[#D4AF37] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Inventory') }}
            </a>
            <span
                class="text-[10px] font-black uppercase tracking-[0.2em] text-[#8B5E3C]/30 italic">{{ __('Editing:') }}
                {{ $product->name }}</span>
        </div>

        <div class="card-premium rounded-[3rem] overflow-hidden">
            <div class="p-10">
                <form action="{{ route('admin.products.update', $product) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-10">
                    @csrf @method('PUT')

                    <div class="grid md:grid-cols-2 gap-10">
                        <!-- Left Side: Basic Info -->
                        <div class="space-y-6">
                            <h4
                                class="text-sm font-black uppercase tracking-[0.2em] text-[#D4AF37] border-b border-[#D4AF37]/10 pb-2">
                                {{ __('Essential Details') }}</h4>

                            <div>
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Product Name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold">
                                @error('name')
                                    <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Category') }}</label>
                                <select name="category_id" required
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Price (IDR)') }}</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-[10px] font-black opacity-30 tracking-widest italic uppercase">Rp</span>
                                        <input type="number" name="price"
                                            value="{{ old('price', $product->price) }}" required
                                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 pl-12 font-bold">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Stock Level') }}</label>
                                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                        required
                                        class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold text-center">
                                </div>
                            </div>

                            <div class="pt-6 flex flex-col gap-4">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ $product->is_active ? 'checked' : '' }} class="hidden peer">
                                    <div
                                        class="w-12 h-6 bg-gray-200 rounded-full relative transition-colors peer-checked:bg-green-500 mr-3 shadow-inner">
                                        <div
                                            class="absolute w-4 h-4 bg-white rounded-full top-1 left-1 transition-all peer-checked:left-7 shadow-sm">
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Product is Active') }}</span>
                                </label>

                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_premium" value="1"
                                        {{ $product->is_premium ? 'checked' : '' }} class="hidden peer">
                                    <div
                                        class="w-12 h-6 bg-gray-200 rounded-full relative transition-colors peer-checked:bg-[#D4AF37] mr-3 shadow-inner">
                                        <div
                                            class="absolute w-4 h-4 bg-white rounded-full top-1 left-1 transition-all peer-checked:left-7 shadow-sm">
                                        </div>
                                    </div>
                                    <span
                                        class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60">{{ __('Premium Product') }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Right Side: Presentation -->
                        <div class="space-y-6">
                            <h4
                                class="text-sm font-black uppercase tracking-[0.2em] text-[#D4AF37] border-b border-[#D4AF37]/10 pb-2">
                                {{ __('Presentation') }}</h4>

                            <div>
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Product Description') }}</label>
                                <textarea name="description" rows="5"
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 p-4 font-medium">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div x-data="{ fileName: '' }">
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Signature Image') }}</label>
                                @if ($product->image)
                                    <div class="mb-4 relative group">
                                        <img src="{{ asset($product->image) }}"
                                            class="w-full h-40 object-cover rounded-[2rem] shadow-md border border-[#8B5E3C]/10 transition-transform group-hover:scale-[1.02]">
                                        <div
                                            class="absolute inset-0 bg-black/40 rounded-[2rem] opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span
                                                class="text-white text-[10px] font-black uppercase tracking-[0.2em]">{{ __('Current Signature Photo') }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="relative w-full h-24 border-2 border-dashed border-[#8B5E3C]/10 rounded-[2rem] flex flex-col items-center justify-center bg-gray-50/50 hover:bg-[#D4AF37]/5 hover:border-[#D4AF37]/30 transition-all cursor-pointer group">
                                    <input type="file" name="image_file"
                                        @change="fileName = $event.target.files[0].name"
                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                    <svg class="w-6 h-6 text-[#8B5E3C]/30 mb-1 group-hover:text-[#D4AF37]/50"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span
                                        class="text-[10px] font-bold text-[#8B5E3C]/50 uppercase tracking-widest text-center px-4"
                                        x-text="fileName || 'Click to change photo (optional)'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-[#8B5E3C]/5 flex items-center justify-between">
                        <button type="button" onclick="window.history.back()"
                            class="text-xs font-black uppercase tracking-widest text-[#8B5E3C]/40 hover:text-red-500 transition-colors uppercase italic underline">
                            {{ __('Discard Changes') }}
                        </button>
                        <button type="submit"
                            class="px-12 py-5 gold-gradient text-white rounded-2xl font-black text-lg shadow-xl shadow-[#D4AF37]/30 hover:scale-[1.05] active:scale-95 transition-all">
                            {{ __('Apply Refined Details') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
