@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div
            class="brand-logo d-flex align-items-center justify-content-between flex-column"
        >
            <a href="/profile" class="text-nowrap logo-img">
                <img
                    src="{{ asset("images/logos/polandstudylogo.png") }}"
                    width="180"
                    class="mt-4"
                    alt=""
                />
            </a>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">

            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <span class="hide-menu">Student Platform</span>
                </li>
                @php
                    $menuItems = [
                        [
                            "name" => "My profile",
                            "route" => "/profile",
                            "icon" => "ti ti-user"
                        ],
                        [
                            "name" => "Documents",
                            "route" => "/documents",
                            "icon" => "ti ti-files"
                        ],
                    ];
                    var_dump(request()->route()->getName());
                    foreach ($menuItems as $item) :
                @endphp
                <li class="sidebar-item">
                    <a
                        class="sidebar-link {{ request()->route()->getName() === "/".$item["route"] ? "active" : "" }}"
                        href="{{ $item["route"] }}"
                        aria-expanded="false"
                    >
                  <span>
                    <i class="{{ $item["icon"] }}"></i>
                  </span>
                        <span class="hide-menu">{{ $user->role->role_name === "admin" && $item["name"] === "My profile" ? "Admin" : $item["name"] }}</span>
                    </a>
                </li>
                @php endforeach; @endphp
{{--                <li class="sidebar-item">--}}
{{--                    <a--}}
{{--                        class="sidebar-link"--}}
{{--                        href="/profile"--}}
{{--                        aria-expanded="false"--}}
{{--                    >--}}
{{--                  <span>--}}
{{--                    <i class="ti ti-user"></i>--}}
{{--                  </span>--}}
{{--                        <span class="hide-menu">{{ $user->role->role_name === "admin" ? "Admin" : "My profile" }}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="sidebar-item">--}}
{{--                    <a--}}
{{--                        class="sidebar-link"--}}
{{--                        href="/documents"--}}
{{--                        aria-expanded="false"--}}
{{--                    >--}}
{{--                  <span>--}}
{{--                    <i class="ti ti-files"></i>--}}
{{--                  </span>--}}
{{--                        <span class="hide-menu">Documents</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                {{--                <li class="nav-small-cap">--}}
                {{--                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>--}}
                {{--                    <span class="hide-menu">UI COMPONENTS</span>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="/ui-buttons.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-article"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Buttons</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./ui-alerts.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-alert-circle"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Alerts</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./ui-card.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-cards"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Card</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./ui-forms.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-file-description"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Forms</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./ui-typography.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-typography"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Typography</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-small-cap">--}}
                {{--                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>--}}
                {{--                    <span class="hide-menu">AUTH</span>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./authentication-login.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-login"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Login</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./authentication-register.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-user-plus"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Register</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-small-cap">--}}
                {{--                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>--}}
                {{--                    <span class="hide-menu">EXTRA</span>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./icon-tabler.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-mood-happy"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Icons</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="sidebar-item">--}}
                {{--                    <a--}}
                {{--                        class="sidebar-link"--}}
                {{--                        href="./sample-page.html"--}}
                {{--                        aria-expanded="false"--}}
                {{--                    >--}}
                {{--                  <span>--}}
                {{--                    <i class="ti ti-aperture"></i>--}}
                {{--                  </span>--}}
                {{--                        <span class="hide-menu">Sample Page</span>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
