<header class="pc-header">
    <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a
                            class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false"
                    >
                        <svg class="pc-icon">
                            <use xlink:href="#custom-search-normal-1"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3 py-2">
                            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . ." />
                        </form>
                    </div>
                </li>
            </ul>
        </div><!-- [Mobile Media Block end] -->

        <div class="ms-auto">
            <ul class="list-unstyled">
                @if(app()->maintenanceMode()->active())
                    <li class="pc-h-item">
                        <a href="javascript: void(0);" class="pc-head-link me-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Application is in maintenance mode">
                            <svg class="pc-icon text-danger"><use xlink:href="#custom-notification"></use></svg>
                        </a>
                    </li>
                @endif

                <li class="pc-h-item">
                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Go to front page"
                            class="pc-head-link me-0"
                            href="{{ route('index') }}"
                            target="_blank"
                            role="button"
                            aria-haspopup="false"
                            aria-expanded="false"
                    >
                        <svg class="pc-icon">
                            <use xlink:href="#custom-sort-outline"></use>
                        </svg>
                    </a>
                </li>


                <li class="dropdown pc-h-item header-user-profile">
                    <a
                            class="pc-head-link dropdown-toggle arrow-none me-0"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-haspopup="false"
                            data-bs-auto-close="outside"
                            aria-expanded="false"
                    >
                        <img src="{{ asset('assets/back/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar" />
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                                <div class="d-flex mb-1">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('assets/back/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar wid-35" />
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ auth()->user()->name }} 🖖</h6>
                                        <span>{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                                <hr class="border-secondary border-opacity-50" />

                                <a href="#" class="dropdown-item">
                                    <span><svg class="pc-icon text-muted me-2"><use xlink:href="#custom-user"></use></svg><span>{{ __('My Profile') }}</span></span>
                                </a>

                                <a href="{{ route('cache.clean') }}" class="dropdown-item">
                                    <span><svg class="pc-icon text-muted me-2"><use xlink:href="#custom-story"></use></svg><span>{{ __('Clear Cache') }}</span></span>
                                </a>

                                <a href="#" class="dropdown-item" onclick="layout_change('dark'); setTemplateMode('dark');">
                                    <span><svg class="pc-icon text-muted me-2"><use xlink:href="#custom-moon"></use></svg><span>{{ __('Dark Mode') }}</span></span>
                                </a>

                                <a href="#" class="dropdown-item" onclick="layout_change('light'); setTemplateMode('light');">
                                    <span><svg class="pc-icon text-muted me-2"><use xlink:href="#custom-sun-1"></use></svg><span>{{ __('Light Mode') }}</span></span>
                                </a>

                                <hr class="border-secondary border-opacity-50" />

                                <div class="card">
                                    <div class="card-body py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0 d-inline-flex align-items-center">
                                                <svg class="pc-icon text-muted me-2"><use xlink:href="#custom-lock-outline"></use></svg>
                                                Maintenance
                                            </h5>
                                            <div class="form-check form-switch form-check-reverse m-0">
                                                <input class="form-check-input input-danger f-18" type="checkbox" role="switch" id="maintenance_mode"
                                                       @if(app()->maintenanceMode()->active()) checked @endif
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="d-grid mb-3">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <a class="btn btn-warning" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg class="pc-icon me-2"><use xlink:href="#custom-logout-1-outline"></use></svg>
                                        {{ __('Logout') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>

@push('js_after')
    <script>
        $(() => {
            $('#maintenance_mode').on('change', (e) => {
                axios.post('maintenance/mode', { checked: e.currentTarget.checked }).then(() => { location.reload() });
            });
        });

        function setTemplateMode(mode) {
            axios.post('maintenance/mode', { mode: mode }).then(() => { showSuccess() });
        }
    </script>
@endpush