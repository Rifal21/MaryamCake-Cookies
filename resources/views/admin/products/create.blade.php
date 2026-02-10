<x-app-layout>
    @section('header_title', __('List New Premium Treat'))

    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center text-sm font-bold text-[#8B5E3C] hover:text-[#D4AF37] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Inventory') }}
            </a>
        </div>

        <div class="card-premium rounded-[3rem] overflow-hidden">
            <div class="p-10">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-10">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-10">
                        <!-- Left Side: Basic Info -->
                        <div class="space-y-6">
                            <h4
                                class="text-sm font-black uppercase tracking-[0.2em] text-[#D4AF37] border-b border-[#D4AF37]/10 pb-2">
                                {{ __('General Info') }}</h4>

                            <div>
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Product Name') }}</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold"
                                    placeholder="e.g. Signature Dark Chocolate Cookies">
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Category') }}</label>
                                <select name="category_id" required
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Price (IDR)') }}</label>
                                    <input type="number" name="price" value="{{ old('price') }}" required
                                        class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold"
                                        placeholder="85000">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Initial Stock') }}</label>
                                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required
                                        class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold">
                                </div>
                            </div>
                            <div class="pt-6 flex flex-col gap-4">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }} class="hidden peer">
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
                                        {{ old('is_premium') ? 'checked' : '' }} class="hidden peer">
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
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Product Story / Description') }}</label>
                                <textarea name="description" rows="5"
                                    class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 p-4 font-medium"
                                    placeholder="Tell the story of this treat...">{{ old('description') }}</textarea>
                            </div>

                            <div x-data="{ fileName: '' }">
                                <label
                                    class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Signature Image') }}</label>
                                <div
                                    class="relative w-full h-32 border-2 border-dashed border-[#8B5E3C]/10 rounded-[2rem] flex flex-col items-center justify-center bg-gray-50/50 hover:bg-[#D4AF37]/5 hover:border-[#D4AF37]/30 transition-all cursor-pointer group">
                                    <input type="file" name="image_file"
                                        @change="fileName = $event.target.files[0].name"
                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                    <svg class="w-8 h-8 text-[#8B5E3C]/30 mb-2 group-hover:text-[#D4AF37]/50"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs font-bold text-[#8B5E3C]/50"
                                        x-text="fileName || 'Click to upload high-res photo'"></span>
                                </div>
                                <p
                                    class="text-[10px] text-[#8B5E3C]/40 mt-3 italic text-center uppercase tracking-widest">
                                    {{ __('Best: 1200x900px JPG or PNG') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-[#8B5E3C]/5 flex items-center justify-between">
                        <p class="text-[10px] font-bold text-[#8B5E3C]/40 uppercase tracking-widest max-w-[200px]">
                            {{ __('By saving, this product will be immediately visible on the store front.') }}
                        </p>
                        <button type="submit"
                            class="px-12 py-5 gold-gradient text-white rounded-2xl font-black text-lg shadow-xl shadow-[#D4AF37]/30 hover:scale-[1.05] active:scale-95 transition-all">
                            {{ __('Publish Treat') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
