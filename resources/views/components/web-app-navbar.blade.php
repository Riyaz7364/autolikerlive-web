<style>
    .profile {
        width: 32px;
        display: inline-block;
        /* height: 3.5rem; */
        vertical-align: top;
        border-radius: 50%;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        @if ($title == '')
            <span>
                <x-like-icon size="32" style="vertical-align: text-bottom" />
                <a class="navbar-brand" href="./">{{ $like }}</a>
            </span>

            <span>
                <img class="profile ms-1" src="https://www.autolikerlive.com/storage/autolikerlivetoken_own.webp"
                    alt="">
                <a class="navbar-brand" href="./">{{ $follow }}</a>
            </span>
        @else
            <h1 class="h6" style="vertical-align: center">{{ $title }}</h1>
        @endif


    </div>
</nav>
