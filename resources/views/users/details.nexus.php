@extends('layout')
@includes('parts/headers/header-small')
<div class="container mx-auto flex flex-col lg:space-x-8 space-y-16 lg:space-y-0 px-8 py-8 md:py-8">
    <!-- Titolo Dashboard con icona tachimetro ingrandita -->
    <div class="flex items-center mb-3">
        <i class="fa fa-tachometer fa-2x text-gray-700 mr-3"></i>
        <h1 class="text-2xl font-bold">Dashboard > User Details</h1>
    </div>
    <div class="border-b border-gray-300 mb-4"></div>
    <div class="flex">
        <!-- Sidebar con larghezza ridotta, sfondo bianco e voci allineate a sinistra -->
        @includes( 'parts/users/user-sidebar' )
        <div class="flex flex-col w-1/2 p-8">
            <h1 class="text-2xl font-bold">
                Update User Details
            </h1>
            <form
                method="post"
                action="{{ $updateDetailsAction }}"
                class="flex flex-col w-full space-y-4 max-w-xl register-form"
            >
                <input type="hidden" name="csrf" value="{{ $csrf }}" />
                <input type="hidden" name="user_id" value="{!! $user->id !!}" />
                <label for="name" class="flex flex-col w-full">
                    <span class="flex">Name:</span>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="bg-gray-200 rounded-lg p-2 text-gray-900 cursor-not-allowed"
                        value="{{ $user->name }}"
                        readonly
                    />
                </label>
                <label for="email" class="flex flex-col w-full">
                    <span class="flex">Email:</span>
                    <input
                        id="email"
                        name="email"
                        type="text"
                        class="bg-gray-200 rounded-lg p-2 text-gray-900 cursor-not-allowed"
                        value="{{ $user->email }}"
                        readonly
                    />
                </label>
                <label for="address" class="flex flex-col w-full">
                    <span class="flex">Home Address:</span>
                    <input
                        id="address"
                        name="address"
                        type="text"
                        class="bg-gray-50 rounded-lg p-2 text-gray-900"
                        placeholder="Home Address"
                        value="{{ $user->address }}"
                    />
                </label>
                <label for="address2" class="flex flex-col w-full">
                    <span class="flex">Office Address:</span>
                    <input
                        id="address2"
                        name="address2"
                        type="text"
                        class="bg-gray-50 rounded-lg p-2 text-gray-900"
                        placeholder="Office Address"
                        value="{{ $user->address2 }}"
                    />
                </label>
                <button
                    type="submit"
                    class="bg-indigo-500 rounded-lg p-2 text-white register-button"
                >
                    Update User Details
                </button>
            </form>
        </div>
        
        <div class="flex flex-col w-1/2 p-8">
            <h1 class="text-2xl font-bold">
                Change Password
            </h1>
            <form
                method="post"
                action="{{ $changePasswordAction }}"
                class="flex flex-col w-full space-y-4 max-w-xl log-in-form"
            >
                <input type="hidden" name="csrf" value="{{ $csrf }}" />
                <input type="hidden" name="user_id" value="{!! $user->id !!}" />
                <label for="oldpassword" class="flex flex-col w-full">
                    <span class="flex">Type Old Password:</span>
                    <input
                        id="oldpassword"
                        name="oldpassword"
                        type="password"
                        class="bg-gray-50 rounded-lg p-2 text-gray-900"
                    />
                </label>
                <label for="password" class="flex flex-col w-full">
                    <span class="flex">New Password:</span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="bg-gray-50 rounded-lg p-2 text-gray-900"
                    />
                </label>
                <label for="password2" class="flex flex-col w-full">
                    <span class="flex">Repeat New Password:</span>
                    <input
                        id="password2"
                        name="password2"
                        type="password"
                        class="bg-gray-50 rounded-lg p-2 text-gray-900"
                    />
                </label>
                <button
                    type="submit"
                    class="bg-indigo-500 rounded-lg p-2 text-white log-in-button"
                >
                    Change Password
                </button>
            </form>
        </div>
    </div>
</div>
@includes('parts/footers/footer-small')
