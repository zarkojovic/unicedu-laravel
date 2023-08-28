@php

    $isUpdate = isset($page);

@endphp
@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <h1>{{$pageTitle}}</h1>
        <form action="{{$isUpdate ? route('updatePage') : route('createNew')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" id="title" value="{{$isUpdate ? $page->title : ''}}" required class="form-control"/>
            </div>
            <div class="form-group">
                <label for="route">Route</label>
                <input name="route" id="route" required value="{{$isUpdate ? $page->route : ''}}" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="icon">Icon</label>
                <div class="container">
                    <div class="row icon-selection p-2 bg-light">
                        @foreach($icons as $icon)
                            <div class="col my-1">
                                <div class="p-4 bg-primary h3 text-center m-0 rounded icon-item"
                                     data-value="{{'ti '.$icon}}"><i
                                        class="text-white ti {{ $icon }}"></i></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <input type="hidden" required value="ti ti-at" name="icon" id="icon">
            </div>
            <div class="form-group">
                <label for="roles" class="fw-bold text-black">Roles</label> <br>
                @foreach($roles as $role)
                    <input type="checkbox" name="roles[]" id="roles" value="{{$role->role_id}}"> {{$role->role_name}}
                    <br>
                @endforeach
            </div>
            <div class="form-group">
                <label for="categories" class="fw-bold text-black">Categories</label> <br>
                @foreach($categories as $category)
                    <input type="checkbox" name="categories[]" value="{{$category->field_category_id}}"
                           id="categories"> {{$category->category_name}} <br>
                @endforeach
            </div>
            @if($isUpdate)
                <input type="hidden" name="id" value="{{$page->page_id}}">
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


