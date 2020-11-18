@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-1">
        <div class="col-md-12 col-md-offset-1">
            <x-user-table :users="$users"/>
            <div class="mt-3">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection