@extends('layouts.app1')

@section('content')
    <div class="container">
        <ul class="list-group">
            @include ('activities.list')
        </ul>
    </div>
@stop