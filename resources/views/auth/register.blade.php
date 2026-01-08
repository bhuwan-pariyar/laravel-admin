<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center">
        <div class="container mx-auto">
            <!-- Main container with responsive layout -->
            <div class="flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-8 lg:gap-12">

                <!-- Left column - Image -->
                <div class="w-full lg:w-1/2 xl:w-1/2 max-w-2xl">
                    <img src="{{ asset('assets/images/SignUp.png') }}" class="w-3/4 h-auto object-contain mx-auto"
                        alt="Register illustration" />
                </div>

                <!-- Right column - Form -->
                <div class="w-full lg:w-1/2 xl:w-5/12 max-w-md">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Sign up section -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                            <p class="text-base sm:text-lg font-medium">Sign up with</p>

                            <div class="flex gap-2">
                                <!-- Google -->
                                <button type="button"
                                    class="h-9 w-9 rounded-full bg-slate-800 hover:bg-slate-500 fill-white p-2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full">
                                        <path
                                            d="M564 325.8C564 467.3 467.1 568 324 568C186.8 568 76 457.2 76 320C76 182.8 186.8 72 324 72C390.8 72 447 96.5 490.3 136.9L422.8 201.8C334.5 116.6 170.3 180.6 170.3 320C170.3 406.5 239.4 476.6 324 476.6C422.2 476.6 459 406.2 464.8 369.7L324 369.7L324 284.4L560.1 284.4C562.4 297.1 564 309.3 564 325.8z" />
                                    </svg>
                                </button>

                                <!-- Facebook -->
                                <button type="button"
                                    class="h-9 w-9 rounded-full bg-slate-800 hover:bg-slate-500 fill-white p-2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-full h-full">
                                        <path
                                            d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
                                    </svg>
                                </button>

                                <!-- Github -->
                                <button type="button"
                                    class="h-9 w-9 rounded-full bg-slate-800 hover:bg-slate-500 fill-white p-2 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-full h-full">
                                        <path
                                            d="M237.9 461.4C237.9 463.4 235.6 465 232.7 465C229.4 465.3 227.1 463.7 227.1 461.4C227.1 459.4 229.4 457.8 232.3 457.8C235.3 457.5 237.9 459.1 237.9 461.4zM206.8 456.9C206.1 458.9 208.1 461.2 211.1 461.8C213.7 462.8 216.7 461.8 217.3 459.8C217.9 457.8 216 455.5 213 454.6C210.4 453.9 207.5 454.9 206.8 456.9zM251 455.2C248.1 455.9 246.1 457.8 246.4 460.1C246.7 462.1 249.3 463.4 252.3 462.7C255.2 462 257.2 460.1 256.9 458.1C256.6 456.2 253.9 454.9 251 455.2zM316.8 72C178.1 72 72 177.3 72 316C72 426.9 141.8 521.8 241.5 555.2C254.3 557.5 258.8 549.6 258.8 543.1C258.8 536.9 258.5 502.7 258.5 481.7C258.5 481.7 188.5 496.7 173.8 451.9C173.8 451.9 162.4 422.8 146 415.3C146 415.3 123.1 399.6 147.6 399.9C147.6 399.9 172.5 401.9 186.2 425.7C208.1 464.3 244.8 453.2 259.1 446.6C261.4 430.6 267.9 419.5 275.1 412.9C219.2 406.7 162.8 398.6 162.8 302.4C162.8 274.9 170.4 261.1 186.4 243.5C183.8 237 175.3 210.2 189 175.6C209.9 169.1 258 202.6 258 202.6C278 197 299.5 194.1 320.8 194.1C342.1 194.1 363.6 197 383.6 202.6C383.6 202.6 431.7 169 452.6 175.6C466.3 210.3 457.8 237 455.2 243.5C471.2 261.2 481 275 481 302.4C481 398.9 422.1 406.6 366.2 412.9C375.4 420.8 383.2 435.8 383.2 459.3C383.2 493 382.9 534.7 382.9 542.9C382.9 549.4 387.5 557.3 400.2 555C500.2 521.8 568 426.9 568 316C568 177.3 455.5 72 316.8 72zM169.2 416.9C167.9 417.9 168.2 420.2 169.9 422.1C171.5 423.7 173.8 424.4 175.1 423.1C176.4 422.1 176.1 419.8 174.4 417.9C172.8 416.3 170.5 415.6 169.2 416.9zM158.4 408.8C157.7 410.1 158.7 411.7 160.7 412.7C162.3 413.7 164.3 413.4 165 412C165.7 410.7 164.7 409.1 162.7 408.1C160.7 407.5 159.1 407.8 158.4 408.8zM190.8 444.4C189.2 445.7 189.8 448.7 192.1 450.6C194.4 452.9 197.3 453.2 198.6 451.6C199.9 450.3 199.3 447.3 197.3 445.4C195.1 443.1 192.1 442.8 190.8 444.4zM179.4 429.7C177.8 430.7 177.8 433.3 179.4 435.6C181 437.9 183.7 438.9 185 437.9C186.6 436.6 186.6 434 185 431.7C183.6 429.4 181 428.4 179.4 429.7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-300 dark:border-slate-600"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-slate-600 dark:text-slate-800 font-semibold">
                                    OR
                                </span>
                            </div>
                        </div>

                        <!-- FullName input -->
                        <div class="mb-6">
                            <x-input-icon name="name" type="name" icon="user" placeholder="Enter FullName"
                                value="{{ old('name') }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Username input -->
                        <div class="mb-6">
                            <x-input-icon name="username" type="username" icon="user" placeholder="Enter UserName"
                                value="{{ old('username') }}" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Email input -->
                        <div class="mb-6">
                            <x-input-icon name="email" type="email" icon="email" placeholder="Enter Email"
                                value="{{ old('email') }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password input -->
                        <div class="mb-6">
                            <x-input-icon name="password" type="password" icon="lock" placeholder="Enter Password"
                                value="{{ old('password') }}" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password input -->
                        <div class="mb-6">
                            <x-input-icon name="password_confirmation" type="password" icon="lock"
                                placeholder="Re-enter Password" value="{{ old('password_confirmation') }}" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Register button -->
                        <div>
                            <x-button variant="slate" fullWidth type="submit">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                {{ __('Register') }}
                            </x-button>
                        </div>

                        <!-- Already registered link -->
                        <div class="text-center text-sm text-slate-600 dark:text-slate-700">
                            <a class="text-slate-600 hover:text-slate-900 dark:text-slate-700 dark:hover:text-slate-900 font-medium"
                                href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
