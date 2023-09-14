<!--  Header Start -->
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<header class="app-header position-relative w-100">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a
                    class="nav-link sidebartoggler nav-icon-hover"
                    id="headerCollapse"
                    href="javascript:void(0)"
                >
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <div
            class="navbar-collapse justify-content-end px-0"
            id="navbarNav"
        >
            <ul
                class="navbar-nav flex-row ms-auto align-items-center justify-content-end"
            >
                @if(\Illuminate\Support\Facades\Auth::user()->role->role_name == "student" && request()->path() != 'applications')
                    <li>
                        <a
                            href="{{route('applications')}}?showModal=true"
                            class="btn btn-primary rounded-3"
                        >Apply For University
                        </a>
                    </li>
                @elseif(\Illuminate\Support\Facades\Auth::user()->role->role_name == "student" && request()->path() == 'applications')
                    <li>
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#dealModal"
                            class="btn btn-primary rounded-3"
                        >Apply For University
                        </button>
                    </li>
                @elseif(\Illuminate\Support\Facades\Auth::user()->role->role_name == "admin")
                    @yield('adminBtn')
                @elseif(\Illuminate\Support\Facades\Auth::user()->role->role_name == "agent")

                @endif
                <li class="nav-item dropdown">
                    <a
                        class="nav-link nav-icon-hover"
                        href="javascript:void(0)"
                        id="drop2"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <img
                            src="{{ asset("storage/profile/tiny/{$user->profile_image}") }}"
                            alt=""
                            width="35"
                            height="35"
                            class="rounded-circle"
                        />
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                        aria-labelledby="drop2"
                    >
                        <div class="message-body">
                            <form action="{{route("logout")}}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block">Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
</header>
<!--  Header End -->
