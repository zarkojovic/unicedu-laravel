@extends("layouts.student")
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col"><h1>{{$pageTitle}}</h1></div>
            @if(Route::has('insert'.$name))
                <div class="col"><p class="text-end"><a href="{{route('insert'.$name) }}"
                                                        class="text-end btn btn-primary">Insert new</a></p></div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table ">
                <thead>
                <tr>
                    @foreach($columns as $col)
                        @if($col == 'password')
                            @php
                                continue;
                            @endphp
                        @endif
                        <th scope="col">{{$col}}</th>
                    @endforeach
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        @foreach($columns as $col)
                            @if($col == 'password')
                                @php
                                    continue;
                                @endphp
                            @endif
                            @if($col == 'created_at' || $col == 'updated_at')
                                <td>{{\Carbon\Carbon::parse($item[$col])->diffForHumans()}}</td>
                            @elseif(str_contains($col,'icon'))
                                <td><i class="{{$item[$col]}}"></i></td>
                            @elseif(str_contains($col,'image'))
                                <td><img src="{{ asset("storage/profile/thumbnail/{$item[$col]}")  }}"
                                         alt="profile image" height="70px"></td>
                            @else
                                <td>{{$item[$col]}}</td>
                            @endif
                        @endforeach
                        <th scope="col">
                            <a class="btn btn-save" href="{{url()->current().'/'.$item->id.'/edit'}}">
                                Edit
                            </a>
                        </th>
                        <th scope="col">
                            @if(Route::has('delete'.$name))
                                <form action="{{route('delete'.$name)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
