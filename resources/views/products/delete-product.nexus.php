@extends('layout')
@includes('parts/headers/header-small')
<div class="container mx-auto flex flex-col space-x-0 lg:space-x-8 space-y-16 lg:space-y-0 px-8 py-8 md:py-16">
    <div class="flex flex-col items-center text-center space-y-8">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold text-red-600 mb-4">Order Cancelled</h1>
            <p class="text-lg text-gray-700 mb-6">We regret to inform you that your order has been cancelled. If you believe this is an error or if you need further assistance, please contact our support team.</p>
            <div class="text-left">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Details:</h2>
                <ul class="list-disc list-inside space-y-2 mb-6">
                    <li><strong>Order Number:</strong> #{!! $order->id !!}</li>
                    <li><strong>Date:</strong> {!! $order->ordered_at !!}</li>
                </ul>
            </div>
            <div class="flex justify-center">
                <a href="/" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Return to Home</a>
            </div>
        </div>
    </div>
</div>
@includes('parts/footers/footer-small')