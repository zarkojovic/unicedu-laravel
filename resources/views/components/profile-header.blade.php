<!--  Header Start -->
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
                @if(\Illuminate\Support\Facades\Auth::user()->role->role_name == "student")
                <li>
                    <a
                        href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/"
                        target="_blank"
                        class="btn btn-primary"
                    >Apply For University</a>
                </li>
                @elseif(\Illuminate\Support\Facades\Auth::user()->role->role_name == "admin")

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
                        @php
                            $user = \Illuminate\Support\Facades\Auth::user();
//                            $imagePathRoute = route('profile.image.path', ['directory' => 'tiny',
//                                                                           'imageName' => $user->profile_image]);
                        @endphp
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
                            <a
                                href="javascript:void(0)"
                                class="d-flex align-items-center gap-2 dropdown-item"
                            >
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                            <a
                                href="javascript:void(0)"
                                class="d-flex align-items-center gap-2 dropdown-item"
                            >
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">My Account</p>
                            </a>
                            <a
                                href="javascript:void(0)"
                                class="d-flex align-items-center gap-2 dropdown-item"
                            >
                                <i class="ti ti-list-check fs-6"></i>
                                <p class="mb-0 fs-3">My Task</p>
                            </a>
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
