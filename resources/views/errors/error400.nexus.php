@extends('layout')
@includes('parts/headers/header-small')
<div class="container mx-auto flex flex-col space-x-0 lg:space-x-8 space-y-16 lg:space-y-0 px-8 py-8 md:py-16 text-center">
  <div class="flex flex-col items-center">
    <h1 class="text-6xl font-bold text-red-600">400</h1>
    <p class="text-xl font-semibold text-gray-700 mt-4">Bad Request</p>
    <p class="text-gray-500 mt-2">The server could not understand the request due to invalid syntax.</p>
    <a href="/" class="mt-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Go to Home</a>
  </div>
</div><script type="module" src=""></script>
@includes('parts/footers/footer-small')