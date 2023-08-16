<?php $pageTitle = "Categories admin" ?>
@extends("layouts.student")

@section('main-content')
    <div class="container">
        <h1>Admin panel</h1>

        @foreach($categories as $category)

            <h3>{{$category->category_name}}</h3>

                @foreach($fields as $field)
                    @if($field->field_category_id == $category->field_category_id)
                        <p>{{$field->title != null ? $field->title : $field->field_name}}</p>
                    @endif

                @endforeach
        @endforeach
    </div>
@endsection
