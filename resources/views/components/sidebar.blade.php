@php
    $user = \Illuminate\Support\Facades\Auth::user();
    $role_id = (int)$user->role_id;


    $pagesWithRole = \App\Models\Page::where('role_id',$role_id)->get();

    $isAdmin = $user->role->role_name === 'admin';

@endphp
    <!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div
            class="brand-logo d-flex align-items-center justify-content-between justify-content-xl-center pt-4"
        >
            <a href="/profile" class="text-nowrap logo-img">
                <img
                    src="{{ asset("images/logos/polandstudylogo.png") }}"
                    width="120"
                    alt="logo"
                />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">

            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <span class="hide-menu">Student Platform</span>
                </li>
                @foreach($pagesWithRole as $page)
                    <li class="sidebar-item">
                        <a
                            class="sidebar-link {{'/'.request()->path() == $page->route ? "active" : ""}}"
                            href="{{$isAdmin ? '/admin' : ''}}{{ $page->route }}"
                            aria-expanded="false"
                        >
                  <span>
                    <i class="{{ $page->icon }}"></i>
                  </span>
                            <span
                                class="hide-menu">{{$page->title}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
