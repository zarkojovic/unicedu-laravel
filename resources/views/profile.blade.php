<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Poland Study Platform</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="/src/images/logos/polandstudylogo.png"
    />
      @vite(['resources/scss/styles.scss'])
  </head>

  <body>
  <!--  Body Wrapper -->
  <div
      class="page-wrapper"
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin6"
      data-sidebartype="full"
      data-sidebar-position="fixed"
      data-header-position="fixed"
  >
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
          <!-- Sidebar scroll-->
          <div>
              <div
                  class="brand-logo d-flex align-items-center justify-content-between flex-column"
              >
                  <a href="profile.blade.php" class="text-nowrap logo-img">
                      <img
                          src="{{ asset("images/logos/polandstudylogo.png") }}"
                          width="180"
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
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="/index.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-user"></i>
                  </span>
                              <span class="hide-menu">My Profile</span>
                          </a>
                      </li>
                      <li class="nav-small-cap">
                          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                          <span class="hide-menu">UI COMPONENTS</span>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="/ui-buttons.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-article"></i>
                  </span>
                              <span class="hide-menu">Buttons</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./ui-alerts.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-alert-circle"></i>
                  </span>
                              <span class="hide-menu">Alerts</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./ui-card.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-cards"></i>
                  </span>
                              <span class="hide-menu">Card</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./ui-forms.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-file-description"></i>
                  </span>
                              <span class="hide-menu">Forms</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./ui-typography.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-typography"></i>
                  </span>
                              <span class="hide-menu">Typography</span>
                          </a>
                      </li>
                      <li class="nav-small-cap">
                          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                          <span class="hide-menu">AUTH</span>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./authentication-login.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-login"></i>
                  </span>
                              <span class="hide-menu">Login</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./authentication-register.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-user-plus"></i>
                  </span>
                              <span class="hide-menu">Register</span>
                          </a>
                      </li>
                      <li class="nav-small-cap">
                          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                          <span class="hide-menu">EXTRA</span>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./icon-tabler.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-mood-happy"></i>
                  </span>
                              <span class="hide-menu">Icons</span>
                          </a>
                      </li>
                      <li class="sidebar-item">
                          <a
                              class="sidebar-link"
                              href="./sample-page.html"
                              aria-expanded="false"
                          >
                  <span>
                    <i class="ti ti-aperture"></i>
                  </span>
                              <span class="hide-menu">Sample Page</span>
                          </a>
                      </li>
                  </ul>
                  <div
                      class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded"
                  >
                      <div class="d-flex">
                          <div class="unlimited-access-title me-3">
                              <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">
                                  Upgrade to pro
                              </h6>
                              <a
                                  href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/"
                                  target="_blank"
                                  class="btn btn-primary fs-2 fw-semibold lh-sm"
                              >Buy Pro</a
                              >
                          </div>
                          <div class="unlimited-access-img">
                              <img
                                  src="{{ asset("images/backgrounds/rocket.png") }}"
                                  alt=""
                                  class="img-fluid"
                              />
                          </div>
                      </div>
                  </div>
              </nav>
              <!-- End Sidebar navigation -->
          </div>
          <!-- End Sidebar scroll-->
      </aside>
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      <div class="body-wrapper">
          <!--  Header Start -->
          <header class="app-header">
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
                          <a
                              href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/"
                              target="_blank"
                              class="btn btn-primary"
                          >Apply For University</a
                          >
                          <li class="nav-item dropdown">
                              <a
                                  class="nav-link nav-icon-hover"
                                  href="javascript:void(0)"
                                  id="drop2"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                              >
                                  <img
                                      src="{{asset("images/profile/user-1.jpg")}}"
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
                                      <a
                                          href="./authentication-login.html"
                                          class="btn btn-outline-primary mx-3 mt-2 d-block"
                                      >Logout</a
                                      >
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </nav>
          </header>
          <!--  Header End -->
          <div class="container-fluid">
              <!--  Student Profile -->
              <div class="row">
                  <div class="col-lg-12 d-flex align-items-strech">
                      <div class="card w-100">
                          <div class="card-body">
                              <div
                                  class="d-sm-flex d-block align-items-center justify-content-between mb-9"
                              >
                                  <div class="mb-3 mb-sm-0">
                                      <h4 class="card-title fw-semibold">Student Profile</h4>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-6 col-lg-2 col-md-3 col-sm-4">
                                      <div class="profile-picture border border-silver">
                                          <img
                                              src="{{asset("images/profile/user-1.jpg")}}"
                                              alt="Profile Picture"
                                              class="img-fluid"
                                          />
                                      </div>
                                  </div>
                                  <div class="col-6 col-lg-10 col-md-9 col-sm-8">
                                      <h5 class="fw-semibold">Marko Barisic</h5>
                                      <h6 class="fw-semibold text-muted">barisicm@gmail.com</h6>
                                      <div class="platinum-package">
                                          <span class="text">PLATINUM</span>
                                      </div>
                                      <div class="mt-3">
                                          <a class="text-primary text-hover t05" href="#"
                                          >Change Profile Picture</a
                                          >
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!--  Personal Information -->
              <div class="row">
                  <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                          <div class="card-body p-4">
                              <div class="row">
                                  <div class="col-8">
                                      <h5 class="card-title fw-semibold mb-4">
                                          Personal Information
                                      </h5>
                                  </div>
                                  <div class="col-4 text-end">
                                      <button
                                          type="button"
                                          class="btn btn-success btn-block m-1 d-none"
                                          id="btnSave"
                                      >
                                          Save
                                      </button>
                                      <button
                                          type="button"
                                          class="btn btn-danger btn-block m-1 d-none"
                                          id="btnCancel"
                                      >
                                          Cancel
                                      </button>
                                      <button
                                          type="button"
                                          class="btn btn-danger btn-block m-1"
                                          id="btnEdit"
                                      >
                                          Edit
                                      </button>
                                  </div>
                              </div>
                              <form id="userForm" class="mt-4 d-none">
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="nameInput" class="form-label">Name</label>
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="nameInput"
                                                  aria-describedby="emailHelp"
                                              />
                                              <div id="emailHelp" class="form-text d-none">
                                                  We'll never share your email with anyone else.
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="surnameInput" class="form-label"
                                              >Surname</label
                                              >
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="surnameInput"
                                                  aria-describedby="emailHelp"
                                              />
                                              <div id="emailHelp" class="form-text d-none">
                                                  We'll never share your email with anyone else.
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="dobInput" class="form-label"
                                              >Date of Birth</label
                                              >
                                              <input
                                                  type="date"
                                                  class="form-control"
                                                  id="dobInput"
                                              />
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="phoneInput" class="form-label"
                                              >Phone</label
                                              >
                                              <input
                                                  type="tel"
                                                  class="form-control"
                                                  id="phoneInput"
                                              />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="citizenshipInput" class="form-label"
                                              >Citizenship</label
                                              >
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="citizenshipInput"
                                              />
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label for="passportInput" class="form-label"
                                              >Passport</label
                                              >
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="passportInput"
                                              />
                                          </div>
                                      </div>
                                  </div>
                              </form>
                              <form id="displayForm" class="mt-4">
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Name</label>
                                              <p id="displayName" class="form-control-static">
                                                  Marko
                                              </p>
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Surname</label>
                                              <p id="displaySurname" class="form-control-static">
                                                  Barisic
                                              </p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Date of Birth</label>
                                              <p id="displayDOB" class="form-control-static"></p>
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Phone</label>
                                              <p id="displayPhone" class="form-control-static"></p>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Citizenship</label>
                                              <p
                                                  id="displayCitizenship"
                                                  class="form-control-static"
                                              ></p>
                                          </div>
                                      </div>
                                      <div class="col-lg-4">
                                          <div class="mb-3">
                                              <label class="form-label">Passport</label>
                                              <p
                                                  id="displayPassport"
                                                  class="form-control-static"
                                              ></p>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @vite(['resources/scss/styles.scss',
              'resources/libs/jquery/dist/jquery.min.js',
              'resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
              'resources/js/dashboard.js',
              'resources/js/main.js',
              'resources/libs/apexcharts/dist/apexcharts.min.js',
              'resources/libs/simplebar/dist/simplebar.js'])

  </body>
</html>
