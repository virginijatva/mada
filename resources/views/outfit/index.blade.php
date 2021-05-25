@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h1>Masters</h1>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($outfits as $outfit)
                        <li class="list-group-item">
                            <div class="list-bin">

                                <div class="list-title">
                                    {{$outfit->type}} {{$outfit->outfitMaster->name}} {{$outfit->outfitMaster->surname}}
                                </div>

                                <div class="list-btn">
                                    <a href="{{route('outfit.edit',$outfit)}}" class="btn btn-info">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{route('outfit.destroy', $outfit)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </form>
                                </div>
                                
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


