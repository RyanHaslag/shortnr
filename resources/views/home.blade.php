@extends('layouts.app')

@section('title')
    <title>Welcome to Shortnr</title>
@endsection

@section('content')
    <div id="app">
        <url-shortener></url-shortener>
        @if(!empty($result) && $result == 'error')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative w-1/3 mx-auto" role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">{{ $message }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
              </span>
            </div>
        @endif
    </div>
@endsection
