@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/book.css')}} />
@append

@section('content')
<div class="internal">
    <div class='first_section'></div>
</div>
@endsection
