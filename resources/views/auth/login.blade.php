<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-serif font-bold text-[#8B5E3C]">{{ __('Welcome Back') }}</h2>
        <p class="text-[#6B4F3A] mt-2">{{ __('Sign in to manage your premium bakery.') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all duration-300 py-3">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between mb-1">
                <label for="password" class="block text-sm font-bold text-[#8B5E3C]">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-[#D4AF37] hover:text-[#B8860B]"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all duration-300 py-3">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-[#8B5E3C]/20 text-[#D4AF37] shadow-sm focus:ring-[#D4AF37] focus:ring-offset-0 transition-all">
            <span class="ms-2 text-sm text-[#8B5E3C]/70">{{ __('Remember me on this device') }}</span>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full py-4 gold-gradient text-white rounded-xl font-bold text-lg shadow-lg shadow-[#D4AF37]/30 hover:scale-[1.02] transform transition-all duration-300">
                {{ __('Sign In') }}
            </button>
        </div>
    </form>
</x-guest-layout>
