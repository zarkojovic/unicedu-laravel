@php
    $isUpdate = isset($data);
@endphp
@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>{{$pageTitle}}</h1>
            </div>
            <div class="col-sm-6">
                <p class="text-end">
                    <a href="{{route('showUsers')}}">Go back</a>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <img src="{{ asset("storage/profile/thumbnail/{$data->profile_image}")}}" width="100px"
                     alt="Profile image" class="mt-3">
                <h3 class="mt-3">{{$data->first_name}} {{$data->last_name}}</h3>
            </div>
        </div>
        <h4 class="mt-4">User history</h4>
        <ul>
            @foreach($history as $log)
                <li> {{$log->description}}
                    - {{\Carbon\Carbon::parse($log->created_at)->diffForHumans()}}</li>
            @endforeach
        </ul>

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


