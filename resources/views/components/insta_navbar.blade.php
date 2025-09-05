<div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!-- Container wrapper -->

        <!-- Icons -->
        <ul class="navbar-nav d-flex flex-row">
            <li
                class="nav-item me-1 me-lg-0 text-center h6 font-small border rounded mx-3 {{ Route::currentRouteName() === 'instagram.findInstaId' ? 'bg-info' : '' }}">
                <a class="nav-link text-white" href="{{ route('instagram.findInstaId') }}">{!! getIcon('people', 'text-white mb-1') !!}
                    Find USER ID</a>
            </li>
            <li
                class="nav-item me-1 me-lg-0 text-center h6 font-small border rounded mx-3 {{ Route::currentRouteName() === 'instagram.photo' ? 'bg-info' : '' }}">
                <a class="nav-link text-white" href="{{ route('instagram.photo') }}">{!! getIcon('photo', 'text-white mb-1') !!}
                    PHOTO</a>
            </li>

            <li
                class="nav-item me-1 me-lg-0 text-center h6 font-small border rounded mx-3 {{ Route::currentRouteName() === 'instagram.avatar' ? 'bg-info' : '' }}">
                <a class="nav-link text-white" href="{{ route('instagram.avatar') }}">{!! getIcon('people', 'text-white mb-1') !!} DP</a>
            </li>

        </ul>
    </nav>
    <!-- Navbar -->
</div>
