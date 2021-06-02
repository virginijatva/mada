@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="page-title">Masters</h1>
                    <fieldset class="sort">
                    <legend>Search:</legend>
                    <input type="text" id="search-field" placeholder="search">
                    </fieldset>
                    <fieldset class="sort">
                        <legend>Sort by:</legend>
                        <div class="inputs">
                            <label for="_1">name</label><input type="radio" name="sort" value="size" id="_1" checked>
                            <label for="_2">date</label><input type="radio" name="sort" value="date" id="_2">
                            <span class="border"></span>
                            <label for="_3">up</label><input type="radio" name="order" value="asc" id="_3" checked>
                            <label for="_4">down</label><input type="radio" name="order" value="desc" id="_4" </div>
                    </fieldset>
                    <button type="button" class="btn btn-info">Sort</button>
                </div>
                <div class="card-body" id="master-list">
                    {{-- list --}}
                    <div class="center-loader">
                        <div class="lds-ring">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
