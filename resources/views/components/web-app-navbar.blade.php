<nav class="bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-3">
            @if ($title == '')
                <div class="flex items-center gap-3">
                    <x-like-icon size="32" class="align-text-bottom" />
                    <a href="./" class="text-lg font-semibold">{{ $like }}</a>
                </div>

                <div class="flex items-center gap-3">
                    <img src="https://www.autolikerlive.com/storage/autolikerlivetoken_own.webp" alt="" class="w-8 h-8 rounded-full">
                    <a href="./" class="text-lg font-semibold">{{ $follow }}</a>
                </div>
            @else
                <h1 class="text-lg font-semibold">{{ $title }}</h1>
            @endif
        </div>
    </div>
</nav>
