<?php $pageTitle = "Admin Panel" ?>
@extends("layouts.student")

@section('main-content')
    <div class="container">
        <h1>Admin panel</h1>

        @foreach($categories as $category)
            <h3>{{$category->category_name}}</h3>

            <form action="/add_fields" method="POST">
                @csrf
                <input type="hidden" value="{{$category->field_category_id}}" name="category_id">

                @foreach($fields as $field)
                    @if ($field->field_category_id === $category->field_category_id)
                        <div class="form-group">
                            <input type="checkbox" id="{{$field->field_name}}" value="{{$field->field_id}}" name="fields[]" checked>
                            {{$field->title != null ? $field->title : $field->field_name}}
                        </div>
                    @else
                        <div class="form-group">
                            <input type="checkbox" id="{{$field->field_name}}" value="{{$field->field_id}}" name="fields[]">
                            {{$field->title != null ? $field->title : $field->field_name}}
                        </div>
                    @endif
                @endforeach

                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        @endforeach

    </div>
@endsection
