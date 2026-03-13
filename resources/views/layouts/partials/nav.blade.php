<!-- Header Start -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" id="mainNav">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: #1da3dd;"><h3 style="color: #1da3dd;">Villa Fabulosa</h3></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto smooth-scroll">
                {{-- Home --}}
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Home</a>
                </li>

                {{-- Gallery --}}
                <li
                    class="nav-item dropdown {{ request()->is('the-rooms', 'game-rooms', 'bridal-suite', 'the-pool', 'miniature-golf-course', 'the-sports-area', 'birds-eye', 'floorplan') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownGallery" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gallery
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownGallery">
                        <a class="dropdown-item" href="{{ url('/the-rooms') }}">The Rooms</a>
                        <a class="dropdown-item" href="{{ url('/game-rooms') }}">Game Room</a>
                        <a class="dropdown-item" href="{{ url('/bridal-suite') }}">Bridal Suite</a>
                        <a class="dropdown-item" href="{{ url('/the-pool') }}">The Pool</a>
                        <a class="dropdown-item" href="{{ url('/miniature-golf-course') }}">Miniature Golf Course</a>
                        <a class="dropdown-item" href="{{ url('/the-sports-area') }}">The Sports Area</a>
                        <a class="dropdown-item" href="{{ url('/birds-eye') }}">Bird's Eye</a>
                        <a class="dropdown-item" href="{{ url('/floorplan') }}">Floor Plan</a>
                    </div>
                </li>
                {{-- Experiences --}}
                <li
                    class="nav-item dropdown {{ request()->is('wineries', 'temecula', 'team-bonding') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownExp" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Experiences
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownExp">
                        <a class="dropdown-item" href="{{ url('/wineries') }}">Nearby Wineries</a>
                        <a class="dropdown-item" href="{{ url('/temecula') }}">Temecula</a>
                        <a class="dropdown-item" href="{{ url('/team-bonding') }}">Team Bonding</a>
                    </div>
                </li>

                {{-- Instructions --}}
                <li class="nav-item {{ request()->is('instructions') ? 'active' : '' }}">
                    <a class="nav-link js-scroll-trigger" href="{{ url('/instructions') }}">Instructions</a>
                </li>

                {{-- About --}}
                <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                    <a class="nav-link js-scroll-trigger" href="{{ url('/about') }}">About</a>
                </li>

                {{-- Your Hosts --}}
                <li class="nav-item {{ request()->is('your-hosts') ? 'active' : '' }}">
                    <a class="nav-link js-scroll-trigger" href="{{ url('/your-hosts') }}">Your Hosts</a>
                </li>

                {{-- Social icons --}}
                <li class="nav-item d-flex align-items-center ml-lg-3">
                    <a href="https://www.instagram.com/villa.fabulosa/" target="_blank" class="nav-link p-0 mr-2"
                        aria-label="Instagram">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.tiktok.com/@villafabulosa" target="_blank" class="nav-link p-0"
                        aria-label="TikTok">
                        {{-- <i class="fa fa-music" aria-hidden="true"></i> --}}
                        {{-- <i class="fa-brands fa-tiktok"></i> --}}
                        <img src="{{ asset('frontend/imgs/tiktok-brands-solid-full.svg') }}" alt="TikTok" style="height: 22px; width: 22px;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Header End -->
