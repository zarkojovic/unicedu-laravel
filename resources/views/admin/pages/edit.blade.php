@php

    $isUpdate = isset($page);

@endphp
@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <h1>{{$pageTitle}}</h1>
        <form action="{{$isUpdate ? route('update'.$name) : route('create'.$name)}}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input name="title" id="title"
                       value="{{$isUpdate ? $page->title : ''}} {{!$isUpdate ? old('title') : ''}} " required
                       class="form-control"/>
            </div>
            <div class="form-group mb-3">
                <label for="route">Route</label>
                <input name="route" id="route" required
                       value="{{$isUpdate ? $page->route : ''}}  {{!$isUpdate ? old('route') : ''}}"
                       class="form-control"/>
            </div>
            <div class="form-group mb-3">
                <label for="icon">Icon</label>
                <div class="container">
                    <input type="text" placeholder="Search icons..." id="iconSearch" class="form-control my-3">
                    <div class="row icon-selection p-2 bg-light" id="iconsWrap">
                        @foreach($icons as $icon)
                            <div class="col-1 my-1">
                                <div class="p-4 bg-primary h3 text-center m-0 rounded icon-item"
                                     data-value="{{'ti '.$icon}}"><i
                                        class="text-white ti {{ $icon }}"></i></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <input type="hidden" required value="ti {{$isUpdate ? $page->icon : ''}}" name="icon" id="icon">
            </div>
            <div class="form-group mb-3">
                <label for="roles" class="fw-bold text-black">Roles</label> <br>

                @foreach ($roles as $role)
                    @if($isUpdate)
                        @php
                            $check = $page->role_id == $role->role_id;
                        @endphp
                    @else
                        @php
                            $check = false;
                        @endphp
                    @endif
                    <input type="radio" name="role_id" {{ $check ? 'checked' : '' }} id="roles-{{ $role->role_id }}"
                           value="{{ $role->role_id }}"> {{ $role->role_name }}<br>
                @endforeach


            </div>
            <div class="form-group">
                <label for="categories" class="fw-bold text-black">Categories</label> <br>


                @foreach ($categories as $category)
                    @if($isUpdate)
                        @php
                            $check = $selectedCategories->contains('field_category_id', $category->field_category_id);
                        @endphp
                    @else
                        @php
                            $check = false;
                        @endphp
                    @endif
                    <label class="d-flex align-items-center">
                        <input type="checkbox" name="categories[]"
                               {{ $check ? 'checked' : '' }} id="categories-{{ $category->role_id }}"
                               value="{{ $category->field_category_id }}"> {{ $category->category_name }}</label><br>
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


