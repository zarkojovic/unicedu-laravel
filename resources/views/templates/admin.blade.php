@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col"><h1>{{$pageTitle}}</h1></div>
            <div class="col"><a href="{{route('insertPages')}}" class="text-end btn btn-primary">Insert new</a></div>
        </div>
        <table class="table">
            <thead>
            <tr>
                @foreach($columns as $col)
                    <th scope="col">{{$col}}</th>
                @endforeach
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    @foreach($columns as $col)
                        @if($col == 'created_at' || $col == 'updated_at')
                            <td>{{\Carbon\Carbon::parse($page[$col])->diffForHumans()}}</td>
                        @elseif(str_contains($col,'icon'))
                            <td><i class="{{$page[$col]}}"></i></td>
                        @else
                            <td>{{$page[$col]}}</td>
                        @endif
                    @endforeach
                    <th scope="col">
                        <a class="btn btn-save" href="{{url()->current().'/'.$page->page_id.'/edit'}}">
                            Edit
                        </a>
                    </th>
                    <th scope="col">
                        <button class="btn btn-danger">Delete</button>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
