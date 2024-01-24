@extends('master')
@section('title')
    <h1 class="pagetitle">HOME</h1>
@endsection

@section('content')
    <script src="{{ url('js/home.js?time=') . rand() }}"></script>

    <div class="container-fluid">
    </div>
@endsection
