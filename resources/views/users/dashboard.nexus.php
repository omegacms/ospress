@extends('layout')
@includes('parts/headers/header-small')
<div class="container mx-auto flex flex-col lg:space-x-8 space-y-16 lg:space-y-0 px-8 py-8 md:py-8">
    <!-- Titolo Dashboard con icona tachimetro ingrandita -->
    <div class="flex items-center mb-3">
        <i class="fa fa-tachometer fa-2x text-gray-700 mr-3"></i>
        <h1 class="text-2xl font-bold">Dashboard</h1>
    </div>
    <div class="border-b border-gray-300 mb-4"></div>

    <div class="flex">
        <!-- Sidebar con larghezza ridotta, sfondo bianco e voci allineate a sinistra -->
        @includes( 'parts/users/user-sidebar' )

        <!-- Area centrale vuota -->
        <div class="flex-grow bg-white p-8">
            <!-- Contenuti della dashboard -->
             Dashboard
        </div>
    </div>
</div>
@includes('parts/footers/footer-small')