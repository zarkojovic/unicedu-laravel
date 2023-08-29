@php

    $isUpdate = isset($data);

@endphp
@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <h1>{{$pageTitle}}</h1>
        <form action="{{$isUpdate ? route('update'.$name) : route('create'.$name)}}" method="post">
            @csrf
            <div class="form-group">
                <label for="category_name">Title</label>
                <input name="category_name" id="category_name" value="{{$isUpdate ? $data->category_name : ''}}"
                       required class="form-control"/>
            </div>
            @if($isUpdate)
                <input type="hidden" name="id" value="{{$data->id}}">
            @endif
            <input type="submit" value="Submit" class="btn btn-save mt-3">
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection


