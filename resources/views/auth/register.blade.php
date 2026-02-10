<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-serif font-bold text-[#8B5E3C]">{{ __('Join Maryam Cake & Cookies') }}</h2>
        <p class="text-[#6B4F3A] mt-2">{{ __('Create an account to start managing.') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Full Name') }}</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all py-3">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all py-3">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all py-3">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation"
                class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all py-3">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-4">
            <a class="text-sm font-semibold text-[#8B5E3C]/70 hover:text-[#D4AF37] underline"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit"
                class="px-8 py-3 gold-gradient text-white rounded-xl font-bold shadow-lg shadow-[#D4AF37]/20 hover:scale-105 transition-all">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
