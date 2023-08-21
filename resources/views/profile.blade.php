<?php $pageTitle = "Student profile" ?>
@extends("layouts.student")

@section('main-content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
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
                                    <img src="{{ asset("storage/profile/thumbnail/{$user->profile_image}")  }}"
                                         alt="Profile Picture"
                                         class="img-fluid"
                                    />
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
                                    </form>
                                </div>
                            </div>
                        </div>
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

