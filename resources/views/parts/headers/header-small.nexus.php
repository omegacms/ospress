<div class="bg-gray-900 z-20">
    <div class="container mx-auto px-8 py-4 flex flex-col md:flex-row items-center text-center md:text-left">
        <div class="flex flex-shrink items-center pr-0 md:pr-4 h-32">
            @includes('rocket')
        </div>
        <div class="flex flex-col justify-center flex-grow">
            <a href="/" class="text-4xl text-white">
                Whoosh!
            </a>
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
        <div class="flex flex-shrink items-center space-x-4 text-white text-xl ml-auto">
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
