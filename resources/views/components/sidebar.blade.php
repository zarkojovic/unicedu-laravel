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
            class="brand-logo d-flex align-items-center justify-content-between flex-column"
        >
            <a href="/profile" class="text-nowrap logo-img">
                <img
                    src="{{ asset("images/logos/polandstudylogo.png") }}"
                    width="180"
                    class="mt-4"
                    alt="logo"
                />
            </a>
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
