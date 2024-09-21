@extends('layout')
@includes('parts/headers/header-large')
<div class="container mx-auto px-8 py-8 md:py-16">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">
            Order Summary
        </h1>
        <form action='{{ $deleteAction }}' method='post'>
            <input type='hidden' name='order_id' value='{!! $order->id !!}'>
            <button class="bg-red-500 rounded-lg p-2 text-white text-sm" data-id="{!! $order->id !!}" data-number="{!! $order->id !!}">Delete Order</button>
        </form>
    </div>
    <div class="border-b border-gray-400 my-4"></div>
    <form action='{{ $buyAction }}' method='post'>
        <input type='hidden' name='order_id' value='{!! $order->id !!}'>
        <input type='hidden' name='csrf' value='{{ $csrf }}'>
        <table class="mt-8 w-full border-collapse">
            <thead>
            <tr>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">User Name</th>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">Order Number</th>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">Order Date</th>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">Product Name</th>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">Quantity Ordered</th>
                <th class="bg-gray-100 border border-gray-300 px-4 py-2 text-center">Total Price</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-center">{{ $order->user_name }}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">{!! $order->id !!}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">{!! $order->ordered_at !!}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">{{ $order->product_name }}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">{!! $order->quantity !!}</td>
                <td class="border border-gray-300 px-4 py-2 text-center">$ {!! $order->total_price !!}</td>
            </tr>
            <tr>
                <td colspan="6" class="px-4 py-2">
                    <div class="border-b border-gray-400 mb-4"></div>
                    <form class="w-full max-w-4xl mx-auto">
                        <div class="flex flex-col md:flex-row justify-between">
                            <div class="md:w-1/2 md:pr-4 mb-4 md:mb-0">
                                <label for="notes" class="block mb-2 text-center">Notes</label>
                                <textarea id="notes" name="notes" class="w-full p-2 border border-gray-500 rounded-md mb-2" rows="8" cols="15"></textarea>
                            </div>
                            <div class="md:w-1/2 md:pl-4">
                                <label for="delivery_instruction" class="block mb-2 text-center">Delivery Instructions</label>
                                <textarea id="delivery_instruction" name="delivery_instruction" class="w-full p-2 border border-gray-500 rounded-md mb-2" rows="8" cols="15"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-center mt-4">
                            <button class="bg-indigo-500 rounded-lg p-2 text-white text-sm">Purchase Order</button>
                        </div>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
@includes('parts/footers/footer-small')