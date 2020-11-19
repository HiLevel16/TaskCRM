@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-1">
        <div class="col-md-12 col-md-offset-1">
            <x-role-table :roles="$roles"/>
            <div class="mt-3">
                {{$roles->links()}}
            </div>
        </div>
    </div>
</div>
@endsection