@extends('layouts.app')

@section('content')

<h2><a href="{{route('posts.index')}}">{{$post->title}}</a></h2>

@endSection
