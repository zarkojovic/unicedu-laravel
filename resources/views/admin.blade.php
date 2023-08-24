    <?php $pageTitle = "Admin Panel" ?>
@extends("layouts.student")

@section('main-content')

    <div class="container-fluid pt-0">
        <h1>Admin panel</h1>

        @foreach($categories as $category)
            <form action="/add_fields" method="POST">
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
                                    <div class="row">
                                        <div class="col-lg-10 col-sm-12">
                                            <div class="row">
                                                @foreach($fields as $field)
                                                    @if ($field->field_category_id === $category->field_category_id)
                                                        <div class="col-lg-5 col-sm-4 border mb-3 me-4 p-3 rounded position-relative">
                                                            <div class="d-flex justify-content-between">
                                                                    <label>{{$field->title != null ? $field->title : $field->field_name}}</label>

                                                                    <i class="ti ti-adjustments-alt panel-field-settings"></i>
                                                                    <div class="checkboxes" id="checkboxes-container">
                                                                        <input type="checkbox" id="{{$field->field_name}}"
                                                                               value="{{$field->field_id}}"
                                                                               name="fields[]" {{ $field->field_category_id === $category->field_category_id ? 'checked' : '' }}>
                                                                        <label for="{{$field->field_name}}">Is Active</label>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                {{--                    <input type="text" name="search-fields" id="search-fields" class="d-block w-100 form-control"/>--}}
                {{--                    <select id="search-list" class="w-100 form-select" size="10"></select>--}}

            </form>
    </div>
    </div>
    </div>
    @endforeach
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/adminpanel.js']);
@endsection

