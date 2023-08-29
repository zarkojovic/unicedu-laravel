<?php $pageTitle = "Admin Panel" ?>
@extends("layouts.student")

@section('main-content')

    <div class="container-fluid pt-0">
        <h1>Admin panel</h1>

        @foreach($categories as $category)
            <form action="/add_fields" method="POST" id="form-{{$category->field_category_id}}">
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-header p3">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h5>{{$category->category_name}}</h5>
                                    </div>
                                    <div class="col-4 text-end">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                            @csrf
                            <input type="hidden" value="{{$category->field_category_id}}" name="category_id">
                            <div class="card-body">
                                <div class="container-fluid">
{{--                                    <div class="row">--}}
{{--                                        <div class="col-lg-10 col-sm-12">--}}
                                            <div class="row row-sortable">
                                                @foreach($fields as $field)
                                                    @if ($field->field_category_id === $category->field_category_id)
                                                        <div
                                                            class="col-lg-5 col-sm-4 border mb-3 me-4 p-3 rounded position-relative sortable-item">
                                                            <div class="d-flex justify-content-between">
                                                                <label class="{{ $field->is_required ? 'primary-color' : '' }}">{{$field->title != null ? $field->title : $field->field_name}}</label>

                                                                <i class="ti ti-adjustments-alt panel-field-settings"
                                                                   id="icon_{{$field->field_id}}"
                                                                   data-field-name="{{$field->field_name}}"></i>
                                                                <div class="checkboxes d-none">
                                                                    <label class="d-flex align-items-center mb-1" for="{{$field->field_name}}">
                                                                    <input type="checkbox" id="{{$field->field_name}}"
                                                                           value="{{$field->field_id}}"
                                                                           name="fields[]" checked="checked">
                                                                        Is
                                                                        Active</label>
                                                                    <label class="d-flex align-items-center" for="required_{{$field->field_name}}">
                                                                    <input type="checkbox" id="required_{{$field->field_name}}"
                                                                           value="{{$field->field_id}}"
                                                                           name="requiredFields[]"
                                                                        {{$field->is_required ? 'checked' : ''}}>
                                                                    Is Required</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <div class="col-lg-5 col-sm-4 border mb-3 me-4 p-3 rounded position-relative">
                                                    <div class="add-category d-flex justify-content-between" id="{{ $category->field_category_id }}">
                                                        <div class="add-category-text">
                                                            <label>Add new field</label>
                                                        </div>
                                                        <div class="add-category-icon">
                                                            <i class="ti ti-plus fs-4"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    @endforeach
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/adminpanel.js']);
@endsection

