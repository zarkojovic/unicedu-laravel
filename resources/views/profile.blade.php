<?php $pageTitle = "Student profile" ?>
@extends("layouts.student")

@section('main-content')
    {{-- Student profile--}}
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
                                    @php
                                              $user = \Illuminate\Support\Facades\Auth::user();
//{{--                                        $imagePathRoute = route('profile.image.path', ['directory' => 'thumbnail',--}}
//{{--                                                                                       'imageName' => $user->profile_image]);--}}
                                    @endphp
                                    <img src="{{ asset("storage/profile/thumbnail/{$user->profile_image}")  }}"
                                         alt="Profile Picture"
                                         class="img-fluid"
                                    />

                                    <!--asset("storage/profile/thumbnail/{$user->profile_image}") -->
                                </div>
                            </div>
                            <div class="col-6 col-lg-10 col-md-9 col-sm-8">
                                <h5 class="fw-semibold">{{ $user->first_name }} {{ $user->last_name }}</h5>
                                <h6 class="fw-semibold text-muted">{{ $user->email }}</h6>
                                <div class="platinum-package">
                                    <span class="text">PLATINUM</span>
                                </div>
                                <div class="mt-3">
                                    <form method="POST" enctype="multipart/form-data" action="{{ route('user.image.update') }}">
                                        @csrf
                                        @method('PUT')
                                        <label class="text-primary text-hover t05" for="profile-image-input">Change Profile Picture</label>
                                        <input type="file" name="profile-image" id="profile-image-input"/>
                                        <button type="submit">Update</button>
                                    </form>
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
                                <div id="userFormBtn" class="d-none">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block m-1 "
                                        id="btnSave"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1"
                                        id="btnCancel"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                <div id="displayFormBtn">
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1"
                                        id="btnEdit"
                                    >
                                        Edit
                                    </button>
                                </div>
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
                                            value="{{ $user->first_name }}"
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
                                            value="{{ $user->last_name }}"
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
                                            value="{{ $user->date_birth }}"
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
                                            value="{{ $user->phone }}"
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
                                            value="{{ $user->citizenship }}"
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
                                            value="{{ $user->passport }}"
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
                                            {{ $user->first_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Surname</label>
                                        <p id="displaySurname" class="form-control-static">
                                            {{ $user->last_name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Date of Birth</label>
                                        <p id="displayDOB" class="form-control-static">
                                            {{ $user->date_birth }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <p id="displayPhone" class="form-control-static">
                                            {{ $user->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Citizenship</label>
                                        <p id="displayCitizenship" class="form-control-static">
                                            {{ $user->citizenship }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Passport</label>
                                        <p id="displayPassport" class="form-control-static">
                                            {{ $user->passport }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fieldsWrap" class="container-fluid pt-0"></div>
@endsection

@section('scripts')
    @vite('resources/js/profile.js');
@endsection

