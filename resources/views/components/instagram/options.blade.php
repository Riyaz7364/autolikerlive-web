<div class="rounded" style="border: 2px solid #a500ff; text-align: center">
    <div class="card-title" style="margin-bottom: 0px !important;"><b style="font-size: 20px;">Quick Access</b>
    </div>
    <div class="card-body" style="
    padding: 0rem 0rem 1rem 1rem !important;!i;!;
">
        <a href="{{ route('autoliker.earn') }}" class="btn btn-info mt-2">EARN CREDITS
            <span class="border px-1 text-white">{{ $earntype }}</span></a>
        <a href="{{ route('autoliker.boost') }}" class="btn btn-success mt-2">BOOST PROFILE</a>
        <a href="{{ route('autoliker.view') }}" class="btn btn-primary mt-2">VIEW PROMOTIONS</a>
        <a href="{{ route('autoliker.dashboard') }}" class="btn btn-warning mt-2">DASHBOARD</a>
        @if ($logintype == 'IG')
            <a href="{{ route('autoliker.free.likes') }}" class="btn bg-dark text-white mt-2 instgram-btn">FREE IG
                LIKES</a>
            <a href="{{ route('autoliker.free.ig.views') }}" class="btn bg-dark text-white mt-2 instgram-btn">FREE
                IG VIEWS</a>
        @endif
        <a href="{{ route('autoliker.free.views') }}" class="btn text-white mt-2 facebook-btn">FREE FB VIEWS
            <sup>BETA</sup></a>


        <a href="{{ route('autoliker.settings') }}" class="btn btn-warning mt-2">SETTINGS</a>

    </div>
</div>
