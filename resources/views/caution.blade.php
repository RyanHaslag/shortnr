@extends('layouts.app')

@section('title')
    <title>Welcome to Shortnr</title>
@endsection

@section('content')
    <div id="app">
        <caution :url="'{{ $fullURL }}'"></caution>
    </div>
@endsection
