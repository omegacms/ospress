@extends('layout')
@includes('parts/headers/header-large')
@foreach($products as $i => $product)
    <div class="
        z-10
        @if($i % 2 === 0)
            bg-gray-50
        @endif
    ">
        <div class="container mx-auto px-8 py-8 md:py-16">
            <h2 class="text-3xl font-bold">
                {{ $product->name }}
            </h2>
            <p class="text-xl my-4">
                {!! $product->description !!}
            </p>
            <p class="text-xl my-4">
                Price: $ {!$product->price !}
            </p>
            @if(isset($_SESSION['user_id']))
                <a href="{{ $product->route }}" class="bg-indigo-500 rounded-lg p-2 text-white">
                    Order
                </a>
            @endif       
        </div>
    </div>
@endforeach
@includes('parts/footers/footer-small')