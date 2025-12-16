<x-guest-layout>

    <div class="min-h-screen flex flex-col items-center justify-center bg-[#DDEEDB] px-4">

        <!-- Header Icon + Title -->
        <div class="text-center mb-10">
            <div class="bg-[#10AF13] w-14 h-14 rounded-xl flex items-center justify-center mx-auto">
                <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" 
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                    class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                </svg>
            </div>
            <h2 class="mt-3 text-xl font-semibold">Sistem Pelatihan Guru</h2>
            <p class="text-gray-500 text-sm mt-3">Silahkan login untuk melanjutkan</p>
        </div>

        <!-- Card -->
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg p-10 grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Logo -->
            <div class="flex items-center justify-center">
                <img src="img/logo-timedoor.svg" class="w-100" alt="Logo">
            </div>

            <!-- Login Form -->
            <div>
                <h3 class="text-center text-lg font-semibold mb-6">Login</h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email"
                                    class="block mt-1 w-full"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required autofocus autocomplete="username"
                                    placeholder="Masukkan email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <div class="relative">
                            <x-text-input id="password"
                                class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Masukkan password" />

                            <!-- Icon Mata -->
                            <button type="button" onclick="togglePassword()" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 focus:outline-none">

                                <!-- Icon Mata Terbuka -->
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 3C5 3 1.73 7.11 1.07 10c.66 2.89 4 7 8.93 7s8.27-4.11 8.93-7C18.27 7.11 15 3 10 3zM10 15a5 5 0 110-10 5 5 0 010 10z" />
                                    <path d="M10 7a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>

                                <!-- Icon Mata Tertutup -->
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.338-4.578M9.88 9.88a3 3 0 104.24 4.24" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6.24 6.239l11.52 11.52" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Login sebagai')" />
                        <select id="role" name="role" required onchange="toggleTokenField()"
                            class="block mt-1 w-full border-gray-300 focus:ring-[#10AF13] focus:border-[#10AF13] rounded-md shadow-sm cursor-pointer">
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{  $role->description }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Token -->
                    <div class="mt-4 hidden" id="tokenField">
                        <x-input-label for="token" :value="__('Token Akses')" />
                        <x-text-input id="token"
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="token"
                                    :value="old('token')"
                                    required autofocus autocomplete="token"
                                    placeholder="Masukkan token akses" />
                        <x-input-error :messages="$errors->get('token')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-[#10AF13] shadow-sm focus:ring-[#10AF13]"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <div class="flex justify-end mt-6">
                        <x-primary-button class="w-full justify-center">
                            {{ __('Login') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>

</x-guest-layout>