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
                        ]
                    ];
                    foreach ($menuItems as $item) :
                @endphp
                <li class="sidebar-item">
                    <a
                        class="sidebar-link {{ "/".request()->path() === $item["route"] ? "active" : "" }} {{ request()->path() === "admin" && $item["route"] === "/profile" ? "active" : "" }}
                        {{ request()->path() === '/' && $item["route"] === "/profile" ? "active" : "" }}"
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
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
