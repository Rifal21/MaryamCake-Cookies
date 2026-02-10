<x-app-layout>
    @section('header_title', __('Edit Category'))

    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center text-sm font-bold text-[#8B5E3C] hover:text-[#D4AF37] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Categories') }}
            </a>
        </div>

        <div class="card-premium rounded-[3rem] overflow-hidden">
            <div class="p-10">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <label
                            class="block text-xs font-black uppercase tracking-widest text-[#8B5E3C]/60 mb-2">{{ __('Category Name') }}</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full rounded-2xl border-[#8B5E3C]/10 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/5 py-4 font-bold">
                        @error('name')
                            <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-6 border-t border-[#8B5E3C]/5 flex items-center justify-end">
                        <button type="submit"
                            class="px-12 py-5 gold-gradient text-white rounded-2xl font-black text-lg shadow-xl shadow-[#D4AF37]/30 hover:scale-[1.05] active:scale-95 transition-all">
                            {{ __('Update Category') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
