<div class="col-12 float-end">
    <div class="btn-group my-3" style="float: right;">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                {!! getIcon('bi-person-heart', 'text-info') !!}
                {{ $username }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    @if ($logintype == 'FB')
                        <a class="dropdown-item" href="{{ route('autoliker.facebook') }}">Logout</a>
                </li>
            @else
                <a class="dropdown-item" href="{{ route('autoliker.instagram') }}">Logout</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
