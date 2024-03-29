<header id="header" class="transparent-header dark " data-mobile-sticky="true">
    <div id="header-wrap">
        <div class="container-fluid">
            <div class="header-row">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ route('index') }}">
                        <img class="logo-default" srcset="{{ asset('media/image/logo-goflexi.svg') }}" src="{{ asset('media/image/logo-goflexi.svg') }}" alt="{{ config('app.name') }}" style="max-height:30px;padding:3px">
                        <img class="logo-dark" srcset="{{ asset('media/image/logo-goflexi-dark.svg') }}" src="{{ asset('media/image/logo-goflexi-dark.svg.svg') }}" alt="{{ config('app.name') }}" style="max-height:30px;padding:3px">
                    </a>
                </div>

                <div class="header-misc">
                    <div class="header-misc-icon ms-5">
                        <a rel="alternate" hreflang="en"
                           href="#">
                            <img src="https://www.optimatransfer.com/media/flags/en.png" />
                        </a>
                    </div>
                </div>

                <div class="primary-menu-trigger">
                    <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                        <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                    </button>
                </div>

                <!-- Primary Navigation -->
                <nav class="primary-menu">
                    <ul class="one-page-menu menu-container" data-easing="easeInOutExpo" data-speed="1250" data-offset="60">
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#wrapper"><div>Naslovnica</div></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#vozni-red" data-offset="100"><div>Vozni red</div></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#onama"><div>O nama</div></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#faq"><div>FAQ</div></a>
                        </li>

                        <li class="menu-item">
                            <a href="#" class="menu-link" data-href="#contact"><div>Kontakt</div></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="header-wrap-clone"></div>
</header>