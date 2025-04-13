<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Tên đăng nhập -->
        <div>
            <x-input-label for="tenDangNhap" :value="__('Tên đăng nhập')" />
            <x-text-input id="tenDangNhap" class="block mt-1 w-full" type="text" name="tenDangNhap" :value="old('tenDangNhap')" required autofocus />
            <x-input-error :messages="$errors->get('tenDangNhap')" class="mt-2" />
        </div>

        <!-- Họ và tên -->
        <div class="mt-4">
            <x-input-label for="tenND" :value="__('Họ và tên')" />
            <x-text-input id="tenND" class="block mt-1 w-full" type="text" name="tenND" :value="old('tenND')" required />
            <x-input-error :messages="$errors->get('tenND')" class="mt-2" />
        </div>

        <!-- Số điện thoại -->
        <div class="mt-4">
            <x-input-label for="soDT" :value="__('Số điện thoại')" />
            <x-text-input id="soDT" class="block mt-1 w-full" type="text" name="soDT" :value="old('soDT')" required />
            <x-input-error :messages="$errors->get('soDT')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mật khẩu -->
        <div class="mt-4">
            <x-input-label for="matKhau" :value="__('Mật khẩu')" />
            <x-text-input id="matKhau" class="block mt-1 w-full" type="password" name="matKhau" required />
            <x-input-error :messages="$errors->get('matKhau')" class="mt-2" />
        </div>

        <!-- Nhập lại mật khẩu -->
        <div class="mt-4">
            <x-input-label for="matKhau_confirmation" :value="__('Nhập lại mật khẩu')" />
            <x-text-input id="matKhau_confirmation" class="block mt-1 w-full" type="password" name="matKhau_confirmation" required />
            <x-input-error :messages="$errors->get('matKhau_confirmation')" class="mt-2" />
        </div>

        <!-- Nút -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                {{ __('Đã có tài khoản?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Đăng ký') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
