<footer id="footer" class="dark border-0" style="background: url('{{ asset('media/image/bg-strets.jpg') }}') no-repeat center bottom / cover;">
    <div class="container">
        <!-- Footer Widgets -->
        <div class="footer-widgets-wrap pb-1">
            <div class="row col-mb-30">

                <div class="col-lg-4">
                    <div class="widget widget_links">
                        <h4>Uvijeti korištenja</h4>
                        <ul>
                            <li><a href="#">Pravila privatnosti</a></li>
                            <li><a href="#">Uvjeti korištenja</a></li>
                            <li><a href="#">Odredbe i uvjeti prijevoza</a></li>
                        </ul>
                    </div>
                </div>

                <div class=" col-lg-4">
                    <div class="widget">
                        <img src="{{ asset('media/image/logo-goflexi-dark.svg') }}" class="mb-4 d-block" alt="{{ config('app.name') }}" style="height:30px">
                    </div>
                </div>

                <div class=" col-lg-4">
                    <div class="widget">
                        <h4>Plaćanje karticama</h4>
                        <img style="height: 35px;margin-right:3px" src="{{ asset('media/image/visa.svg') }}">
                        <img style="height: 35px;margin-right:3px" src="{{ asset('media/image/maestro.svg') }}">
                        <img style="height: 35px;margin-right:3px" src="{{ asset('media/image/mastercard.svg') }}">
                        <img style="height: 35px;margin-right:3px" src="{{ asset('media/image/diners.svg') }}">
                        <img style="height: 30px;margin-right:3px" src="{{ asset('media/image/stripe-logo.svg') }}">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Copyrights -->
    <div id="copyrights">
        <div class="container">
            <div class="w-100 text-md-center">
                <div class="copyrights-menu copyright-links"></div>
                GoFlexi©2024. Sva prava pridržana.
            </div>
        </div>
    </div>
</footer>