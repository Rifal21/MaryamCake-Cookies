<x-app-layout>
    @section('header_title', __('Product Categories'))

    <div class="card-premium rounded-[2rem] overflow-hidden">
        <div class="px-8 py-8 border-b border-[#8B5E3C]/5 flex justify-between items-center bg-gray-50/30">
            <div>
                <h3 class="text-xl font-black text-[#4A3728]">{{ __('Categories') }}</h3>
                <p class="text-sm text-[#8B5E3C]/60 italic">{{ __('Organize your products into groups') }}</p>
            </div>
            <a href="{{ route('admin.categories.create') }}"
                class="px-6 py-3 gold-gradient text-white rounded-xl font-bold text-sm shadow-lg shadow-[#D4AF37]/30 hover:scale-105 transition-all">
                + {{ __('New Category') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 uppercase text-[10px] font-black tracking-widest text-[#8B5E3C]/60">
                        <th class="px-8 py-4 text-left">{{ __('Category Name') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Slug') }}</th>
                        <th class="px-8 py-4 text-left">{{ __('Products Count') }}</th>
                        <th class="px-8 py-4 text-right pr-12">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#8B5E3C]/5">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <span class="font-bold text-[#4A3728]">{{ $category->name }}</span>
                            </td>
                            <td class="px-8 py-5 text-sm text-gray-500">
                                {{ $category->slug }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-[#8B5E3C]/5 text-[#8B5E3C] rounded-full text-xs font-bold">
                                    {{ $category->products_count }} Products
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right pr-12 space-x-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this category?')"
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
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
