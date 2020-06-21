@extends('layouts.app')

@section('content')
<h1>My Form</h1>
{{!! FORM::open()!!}}
<form method="post" action="/posts">
    <input type="text" name="title" placeholder="Enter Title">
    <input type="submit" value="submit">
</form>

@endSection
@section('footer')

@stop
