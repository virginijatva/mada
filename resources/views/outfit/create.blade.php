@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Make new outfit</div>

                <div class="card-body">
                    <form method="POST" action="{{route('outfit.store')}}">
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" name="outfit_type" class="form-control" value="{{old('outfit_type')}}">
                            <small class="form-text text-muted">Outfit type</small>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="outfit_color" class="form-control" value="{{old('outfit_color')}}">
                            <small class="form-text text-muted">Outfit color</small>
                        </div>
                        <div class="form-group">
                            <label>Size</label>
                            <input type="text" name="outfit_size" class="form-control" value="{{old('outfit_size')}}">
                            <small class="form-text text-muted">Outfit size</small>
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea name="outfit_about" id="summernote" class="form-control">{{old('outfit_about')}}</textarea>
                            <small class="form-text text-muted">Client or Master comments about outfit</small>
                        </div>

                        <div class="form-group">
                        <label>Master</label>
                            <select name="master_id" class="form-control">
                            <option value="0">Select Master</option>
                                @foreach ($masters as $master)
                                <option value="{{$master->id}}" @if($master->id == old('master_id', 0)) selected @endif>{{$master->name}} {{$master->surname}}</option>
                                @endforeach
                            </select>
                        </div>

                        @csrf
                        <button type="submit">Make</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
