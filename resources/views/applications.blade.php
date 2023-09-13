<?php $pageTitle = "My Applications" ?>
@extends("layouts.student")

@section('main-content')
    @php
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp

    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100 mb-0 rounded-5">
                    <div class="card-body">
                        <div class="row pb-3 border-bottom">
                            <h4 class="card-title fw-semibold">My Applications</h4>
                        </div>
                        @foreach($userDeals as $application)
                            @if($application->active == 1)
                            <div class="row p-3 border-bottom align-items-baseline">
                            <div class="col-12 col-lg-10">
                                <div class="row mb-lg-3">
                                    <div class="col-12 col-md-6">
                                        <label for="" class="form-label">University</label>
                                        <p class="fs-4">{{$application->university}}</p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="" class="form-label">Degree</label>
                                        <p class="fs-4">{{$application->degree}}</p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="" class="form-label">Prep year</label>
                                        <p class="fs-4">{{$application->intake}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="" class="form-label">Program</label>
                                        <p class="fs-4">{{$application->program}}</p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label for="" class="form-label">Applied</label>
                                        <p class="fs-4">{{$application->created_at->format('j.n.Y - G:i')}}</p>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <label for="" class="form-label">Status</label>
                                        <div class="d-block">
                                            <span class="badge bg-danger rounded-3">New Application</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 d-flex justify-content-end align-items-start mt-3">
                                <button class="btn btn-outline-danger rounded-3" data-deal-id="{{ $application->deal_id }}" data-bs-toggle="modal" data-bs-target="#deleteApplicationModal">Delete</button>

                            </div>
                        </div>
                            @endif
                        @endforeach
                        <div class="modal fade" id="deleteApplicationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content rounded-5 p-2">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Are you sure that you want to delete this application?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">No</button>
                                        <button type="submit" id="confirmDeleteButton" class="btn btn-success rounded-3">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
        @endsection
        @section('scripts')
            @vite(['resources/js/userDeleteDeal.js']);
        @endsection




