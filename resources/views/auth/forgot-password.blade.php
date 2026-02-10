<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-serif font-bold text-[#8B5E3C]">{{ __('Reset Password') }}</h2>
        <p class="text-[#6B4F3A] mt-2 text-sm leading-relaxed">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-[#8B5E3C] mb-1">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="w-full rounded-xl border-[#8B5E3C]/20 focus:border-[#D4AF37] focus:ring focus:ring-[#D4AF37]/20 transition-all py-3">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full py-4 gold-gradient text-white rounded-xl font-bold shadow-lg shadow-[#D4AF37]/30 hover:scale-[1.02] transform transition-all duration-300">
                {{ __('Send Reset Link') }}
            </button>
        </div>

        <div class="text-center">
            <a class="text-sm font-semibold text-[#8B5E3C]/70 hover:text-[#D4AF37] underline"
                href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
