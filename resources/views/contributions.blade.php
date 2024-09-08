<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Content -->
    <div class="w-full lg:ps-64">
        <!-- Card Section -->
        <div class="max-w-2xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 ">
                <div class="text-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 ">
                        Payment
                    </h2>
                    <p class="text-sm text-gray-600 ">
                        Easily make your contributions. Through Mpesa
                    </p>
                </div>

                <form method="POST" action="{{ route('mpesa.paybill') }}">


                    @csrf

                    <!-- Section -->
                    <div class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-neutral-700 dark:first:border-transparent">
                        <label for="af-payment-billing-contact" class="inline-block text-sm font-medium dark:text-white">
                            Payment Information.
                        </label>


                        <div class="space-y-4">
                                <div>
                                    <x-input-label for="phoneNumber" :value="__('phoneNumber')" />


                                    <x-text-input id="phoneNumber" class="block mt-1 w-full" type="text" placeholder='2547xx' name="email" :value="old('phoneNumber')" required autofocus autocomplete="phoneNumber" />



                                    <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />

                                </div>

                                <div>
                                    <x-input-label for="amount" :value="__('amount')" />

                                    <x-text-input id="amount" class="block mt-1 w-full" type="number" min='1' name="amount" :value="old('amount')" required autofocus autocomplete="amount" />





                                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />

                                </div>

                        </div>



                    </div>
                    <!-- End Section -->


                    <div class="mt-5 flex justify-end gap-x-2">

                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Pay using Mpesa
                        </button>
                    </div>
                </form>

            </div>
            <!-- End Card -->
        </div>
        <!-- End Card Section -->

    </div>
    <!-- End Content -->

</x-app-layout>

