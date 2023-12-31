<?php $pageTitle = "Student profile" ?>
@extends("layouts.student")

@section('main-content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    {{-- Student profile--}}
    <div class="container-fluid pt-0">
        <!--  Student Profile -->
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100 mb-0 rounded-5">
                    <div class="card-body">
                        <div
                            class="d-sm-flex d-block align-items-center justify-content-between mb-9"
                        >
                            <div class="mb-3 mb-sm-0 profile-info">
                                <h4 class="card-title fw-semibold">Student Profile</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-2 col-md-3 col-sm-4 profile-info">
                                <div class="profile-picture border border-silver">
                                    <img src="{{ asset("storage/profile/thumbnail/{$user->profile_image}")  }}"
                                         alt="Profile Picture"
                                         class="img-fluid"
                                         id="profileImage"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-lg-10 col-md-9 col-sm-8 profile-info">
                                <h5 class="fw-semibold">{{ $user->first_name }} {{ $user->last_name }}</h5>
                                <h6 class="fw-semibold text-muted">{{ $user->email }}</h6>
                                <div class="platinum-package bg-gradient">
                                    <span class="text">BRONZE</span>
                                </div>
                                <div class="mt-3">
                                    <form method="POST" enctype="multipart/form-data"
                                          action="{{ route('user.image.update') }}">
                                        @csrf
                                        @method('PUT')
                                        <label class="text-primary text-hover t05 profile-image-label"
                                               for="profile-image-input">Upload Profile Image (Required)</label>
                                        <input type="file" class="d-none" name="profile-image"
                                               id="profile-image-input"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if(isset($errors))
                            @if(count($errors) > 0)
                                <div class="row mt-4 alertNotification">
                                    <div class="alert alert-danger mb-0" role="alert">
                                        <ul class="m-0">
                                            @foreach($errors as $err)
                                                <li>{{$err}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if (session('success'))
                            <div class="row mt-4 alertNotification">
                                <div class="alert alert-success mb-0" role="alert">
                                    <p class="m-0">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="fieldsWrap" class="container-fluid pt-0"></div>

{{--    @php--}}
{{--        $data = ['helloo','ehhe']--}}
{{--    @endphp--}}


{{--        <example-component :user="{{json_encode($data)}}"/>--}}

    <!-- Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm your image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="bodyPhotoModal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveProfilePicture">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

