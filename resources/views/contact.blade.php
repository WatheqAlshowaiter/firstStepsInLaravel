@extends('layouts.app')

@section('content')
<h1>Contact Page</h1>

@if(count($people))
<ul>
    @foreach($people as $person)
    <li>{{$person}}</li>
    @endforeach
</ul>
@endif

@endSection
@section('footer')
<script>
    // alert('footer sctipt for contact page') // just for testing
</script>
@stop
