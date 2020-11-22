@extends('layouts.app')

@section('content')
<div class="row mt-1">
    <div class="col-md-12 col-md-offset-1">

        <x-task-filter :filters="$taskFilters" :current="$currentFilters" />
        <x-task-card :tasks="$tasks"/>
        <div class="mt-3">
        {{$tasks->links()}}
        </div>
    </div>
</div>
@endsection