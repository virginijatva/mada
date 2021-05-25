@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-9">
           <div class="card">
               <div class="card-header"><h1>Edit Master</h1></div>
               <div class="card-body">
               <form method="POST" action="{{route('master.update', $master)}}">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="master_name" class="form-control" value="{{$master->name}}">
                        <small class="form-text text-muted">Masters name</small>
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input type="text" name="master_surname" class="form-control" value="{{$master->surname}}">
                        <small class="form-text text-muted">Masters surname</small>
                    </div>
                     @csrf
                     <button type="submit" class="btn btn-primary">EDIT</button>
                  </form>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
