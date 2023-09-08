<?php $pageTitle = "My Applications" ?>
@extends("layouts.student")

@section('main-content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp
    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100 mb-0">
                    <div class="card-body">
                        <div class="row pb-3 border-bottom">
                            <h4 class="card-title fw-semibold">My Applications</h4>
                        </div>

                        <div class="row p-3 border-bottom align-items-baseline">
                            <div class="col-10">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <label for="" class="form-label">University</label>
                                            <p class="fs-4">Warsaw University of Technology</p>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="" class="form-label">Degree</label>
                                            <p class="fs-4">Prep year</p>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="" class="form-label">Applied</label>
                                            <p class="fs-4">8.3.2023 17:47</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"    >
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Program</label>
                                    <p class="fs-4">Warsaw University of Technology</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="" class="form-label">Intake</label>
                                    <p class="fs-4">Prep year</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="" class="form-label">Status</label>
                                    <p class="fs-4">8.3.2023 17:47</p>
                                </div>


                            </div>
                        </div>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-items-start mt-3">
                                    <button class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>


@endsection

