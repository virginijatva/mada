@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add new Master</div>

                <div class="card-body">
                    <form method="POST" action="{{route('master.store')}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="master_name" class="form-control" value="{{old('master_name')}}">
                            <small class="form-text text-muted">Masters name.</small>
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="master_surname" class="form-control" value="{{old('master_surname')}}">
                            <small class="form-text text-muted">Masters surname.</small>
                        </div>
                        <div class="form-group">
                            <label>Portrait</label>
                            <input type="file" name="master_portrait" class="form-control">
                            <small class="form-text text-muted">Masters portrait.</small>
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
