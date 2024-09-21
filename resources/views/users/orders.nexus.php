@extends('layout')
@includes('parts/headers/header-small')
<div class="container mx-auto flex flex-col lg:space-x-8 space-y-16 lg:space-y-0 px-8 py-8 md:py-8">
    <!-- Titolo Dashboard con icona tachimetro ingrandita -->
    <div class="flex items-center mb-3">
        <i class="fa fa-tachometer fa-2x text-gray-700 mr-3"></i>
        <h1 class="text-2xl font-bold">Dashboard > User Orders</h1>
    </div>
    <div class="border-b border-gray-300 mb-4"></div>

    <div class="flex">
        <!-- Sidebar con larghezza ridotta, sfondo bianco e voci allineate a sinistra -->
        @includes( 'parts/users/user-sidebar' )

        <!-- Area centrale vuota -->
        <div class="flex-grow bg-white p-4">
            <!-- Contenuti della dashboard -->
            <!-- Prima tabella: Pending Orders -->
            <div class="border border-none">
                <!-- Titolo "Pending orders" con margine a sinistra -->
                <div class="flex items-center mt-8 ml-1">
                    <h1 class="text-2xl font-bold text-left">
                        Pending orders
                    </h1>
                </div>
                <?php //echo "<pre>"; print_r( $orders ); echo "</pre>"; ?>
                <?php //echo "<pre>"; print_r( $user ); echo "</pre>"; ?>
                <?php //echo "<pre>"; print_r( $product ); echo "</pre>"; ?>
                <table class="mt-8 w-full border-collapse mb-8 text-left">
                    <thead>
                        <tr>
                            <th class="bg-gray-100 px-4 py-2">User Name</th>
                            <th class="bg-gray-100 px-4 py-2">Order Number</th>
                            <th class="bg-gray-100 px-4 py-2">Order Date</th>
                            <th class="bg-gray-100 px-4 py-2">Product Name</th>
                            <th class="bg-gray-100 px-4 py-2">Quantity Ordered</th>
                            <th class="bg-gray-100 px-4 py-2">Total Price</th>
                            <th class="bg-gray-100 px-4 py-2" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $orders as $order )
                            @if( $order->is_confirmed === 0 )
                                <tr>
                                    <td class="px-4 py-2">{{ $order->name }}</td>
                                    <td class="px-4 py-2">{!! $order->id !!}</td>
                                    <td class="px-4 py-2">{!! $order->ordered_at !!}</td>
                                    <td class="px-4 py-2">{{ $order->product_name }}</td>
                                    <td class="px-4 py-2">{!! $order->quantity !!}</td>
                                    <td class="px-4 py-2">$ {!! $order->total_price !!}</td>
                                    <td class="px-4 py-2"><span style="color: blue"><a href="#"><i class="fa fa-edit fa-1x"></i></a></span></td>
                                    <td class="px-4 py-2"><span style="color: red"><a href="#"><i class="fa fa-trash fa-1x"></i></a></span></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Spazio e linea orizzontale -->
            <div class="mt-2.5 mb-8 flex justify-center">
                <hr class="w-11/12 border-t-2 border-gray-300">
            </div>

            <!-- Seconda tabella: Completed Orders -->
            <div class="border border-none">
                <!-- Titolo "Completed orders" con margine a sinistra -->
                <div class="flex items-center mt-8 ml-1">
                    <h1 class="text-2xl font-bold text-left">
                        Completed orders
                    </h1>
                </div>

                <table class="mt-8 w-full border-collapse mb-8 text-left">
                    <thead>
                        <tr>
                            <th class="bg-gray-100 px-4 py-2">User Name</th>
                            <th class="bg-gray-100 px-4 py-2">Order Number</th>
                            <th class="bg-gray-100 px-4 py-2">Completed Date</th>
                            <th class="bg-gray-100 px-4 py-2">Product Name</th>
                            <th class="bg-gray-100 px-4 py-2">Quantity Ordered</th>
                            <th class="bg-gray-100 px-4 py-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $orders as $order )
                            @if( $order->is_confirmed === 1 )
                                <tr>                            
                                        <td class="px-4 py-2">{{ $order->name }}</td>
                                    <td class="px-4 py-2">{!! $order->id !!}</td>
                                    <td class="px-4 py-2">{!! $order->completed_at !!}</td>
                                    <td class="px-4 py-2">{{ $order->product_name }}</td>
                                    <td class="px-4 py-2">{!! $order->quantity !!}</td>
                                    <td class="px-4 py-2">$ {!! $order->total_price !!}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@includes('parts/footers/footer-small')