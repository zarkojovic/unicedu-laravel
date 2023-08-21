<?php $pageTitle = "Documents" ?>
@extends("layouts.student")

@section('main-content')
    <div class="container-fluid">
        <!--  Documents -->
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div
                            class="d-sm-flex d-block align-items-center justify-content-between mb-9"
                        >
                            <div class="mb-3 mb-sm-0">
                                <h4 class="card-title fw-semibold">Documents</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <!-- Document -->
                                    <div class="form-group mb-3 d-flex flex-column align-items-start">
                                        <!-- Field Title -->
                                        <label class="form-label">
                                            Diploma
                                        </label>
                                        <!-- Upload Button (label with for) -->
                                        <label class="upload-document-label" for="document"><span>Upload Document</span></label>
                                        <!-- Hidden Input -->
                                        <input type="file" name="document" id="document" class="form-control d-none">
                                    </div>
                                    <!-- Document -->
                                    <div class="form-group mb-3 d-flex flex-column align-items-start">
                                        <!-- Field Title -->
                                        <label class="form-label">
                                            Transcript
                                        </label>
                                        <div class="d-flex d-inline-block">
                                            <!-- Upload Button (label with for) -->
                                            <label class="document-uploaded-label" for="document">
                                            <span>Document Uploaded</span>
                                            <i class="ti ti-file-check"></i>
                                        </label>
                                            <!-- Hidden Input -->
                                            <input type="file" name="document" id="document-uploaded" class="form-control d-none">
                                        <button type="button" class="btn btn-outline-success m-1 ms-4">
                                            Replace
                                        </button>
                                        <button type="button" class="btn btn-outline-danger m-1">
                                            Remove
                                        </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
