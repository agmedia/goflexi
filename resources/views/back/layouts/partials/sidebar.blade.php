<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <img src="{{ asset('assets/back/images/logo-dark.svg') }}" class="img-fluid" alt="logo">
                <span class="badge bg-light-success rounded-pill ms-2 theme-version">v9.0</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">

                <li class="pc-item{{ request()->routeIs('dashboard') ? ' active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-presentation-chart"></use></svg></span>
                        <span class="pc-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="pc-item pc-hasmenu{{ request()->is([current_locale() . '/admin/catalog/*']) ? ' active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-element-plus"></use></svg></span>
                        <span class="pc-mtext">{{ __('Catalog') }}</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item{{ request()->routeIs(['products', 'product.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('products') }}">{{ __('Products') }}</a></li>
                        <li class="pc-item{{ request()->routeIs(['options', 'options.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('options') }}">{{ __('Options') }}</a></li>
{{--                        <li class="pc-item{{ request()->routeIs(['widgets', 'widget.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('widgets') }}">{{ __('Widgets') }}</a></li>--}}
                        <li class="pc-item{{ request()->routeIs(['pages', 'page.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('pages') }}">{{ __('Pages') }}</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu{{ request()->is([current_locale() . '/admin/sales/*']) ? ' active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-graph"></use></svg></span>
                        <span class="pc-mtext">{{ __('Sales') }}</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        {{--<li class="pc-item"><a class="pc-link" href="#">{{ __('Payments') }}</a></li>--}}
{{--                        <li class="pc-item{{ request()->routeIs(['orders', 'orders.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('orders') }}">{{ __('Orders') }}</a></li>--}}
                        <li class="pc-item{{ request()->routeIs(['calendar', 'calendar.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('calendar') }}">{{ __('Drives') }}</a></li>
                    </ul>
                </li>

                <li class="pc-item pc-hasmenu{{ request()->is([current_locale() . '/admin/marketing/*']) ? ' active pc-trigger' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-link"></use></svg></span>
                        <span class="pc-mtext">{{ __('Marketing') }}</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item{{ request()->routeIs(['faqs', 'faqs.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('faqs') }}">{{ __('FAQ') }}</a></li>
                    </ul>
                </li>

                <li class="pc-item{{ request()->is([current_locale() . '/admin/users', current_locale() . '/admin/user/*']) ? ' active' : '' }}">
                    <a href="{{ route('users') }}" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-profile-2user-outline"></use></svg></span>
                        <span class="pc-mtext">{{ __('Users') }}</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>{{ __('Settings') }}</label>
                </li>

{{--                <li class="pc-item pc-hasmenu{{ request()->is([current_locale() . '/admin/settings/system/*']) ? ' active' : '' }}">--}}
{{--                    <a href="#!" class="pc-link">--}}
{{--                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-share-bold"></use></svg></span>--}}
{{--                        <span class="pc-mtext">{{ __('System') }}</span>--}}
{{--                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>--}}
{{--                    </a>--}}
{{--                    <ul class="pc-submenu">--}}
{{--                        <li class="pc-item{{ request()->routeIs(['application.settings']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('application.settings') }}">{{ __('Aplication') }}</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

                <li class="pc-item pc-hasmenu{{ request()->is([current_locale() . '/admin/settings/application/*']) ? ' active' : '' }}">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-security-safe"></use></svg></span>
                        <span class="pc-mtext">{{ __('Local Settings') }}</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
{{--                        <li class="pc-item{{ request()->routeIs(['languages']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('languages') }}">{{ __('Langiages') }}</a></li>--}}
{{--                        <li class="pc-item{{ request()->routeIs(['currencies']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('currencies') }}">{{ __('Currencies') }}</a></li>--}}
{{--                        <li class="pc-item{{ request()->routeIs(['taxes']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('taxes') }}">{{ __('Taxes') }}</a></li>--}}
                        <li class="pc-item{{ request()->routeIs(['geo-zones', 'geozones.*']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('geozones') }}">{{ __('Geo Zones') }}</a></li>
                        <li class="pc-item{{ request()->routeIs(['order-statuses']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('order.statuses') }}">{{ __('Order Statuses') }}</a></li>
                        <li class="pc-item{{ request()->routeIs(['payments']) ? ' active' : '' }}"><a class="pc-link" href="{{ route('payments') }}">{{ __('Payment Methods') }}</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>