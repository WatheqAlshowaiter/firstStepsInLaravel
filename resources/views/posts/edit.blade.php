@extends('layouts.app')

@section('content')
<h1>My Form</h1>

<form method="post" action="/posts/{{$post->id}}">
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="title" placeholder="Enter Title" value="{{$post->title}}">
    <input type="submit" value="update">
</form>

<form method="post" action="/posts/{{$post->id}}">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="delet">
</form>

@endSection
@section('footer')

@stop
