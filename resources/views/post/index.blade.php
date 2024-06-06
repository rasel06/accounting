@extends('layouts.app')

@section('content')
    <ul>
        @foreach ($posts as $post)
            <li class="px-2 py-1 my-1 bg-slate-300 rounded-lg hover:bg-slate-400">{{ $post->title }}</li>
        @endforeach
    </ul>
@endsection
