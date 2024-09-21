<div class="bg-gray-900 z-20">
    <div class="container mx-auto px-8 py-8 md:py-16 flex flex-col md:flex-row items-center text-center md:text-left">
        <div class="flex flex-shrink justify-end mb-8 md:-mb-20 pr-0 md:pr-16">
            @includes('rocket')
        </div>
        <!-- Colonna centrale -->
        <div class="flex flex-col justify-center flex-grow mb-8 md:mb-0">
            <a href="/" class="text-3xl text-white">
                Whoosh!
            </a>
            <div class="text-xl text-gray-300">
                A place to buy rocket things
            </div>
            <ol class="text-white flex flex-row space-x-2">
                <li><a class="underline" href="/">Home</a></li>
                @if(isset($_SESSION['user_id']))
                    <li><a class="underline" href="/user/dashboard">Dashboard</a></li>
                    <li><a class="underline" href="/user/log-out">Log out</a></li>
                @endif
                @if(!isset($_SESSION['user_id']))
                    <li><a class="underline" href="/register">Register</a></li>
                    <li><a class="underline" href="/user/log-in">Log in</a></li>
                @endif
            </ol>
        </div>

        <!-- Colonna con icone sociali -->
        <div class="flex flex-shrink items-center space-x-6 text-white text-2xl ml-auto">
            <a href="https://facebook.com" class="hover:text-gray-400">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="https://instagram.com" class="hover:text-gray-400">
                <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
            <a href="https://twitter.com" class="hover:text-gray-400">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
            <a href="https://plus.google.com" class="hover:text-gray-400">
                <i class="fa fa-google-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
