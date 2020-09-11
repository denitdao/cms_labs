@extends('base', [$path, $lang])

@section('title', $caption_ua ?? $caption_en ?? '')

@section('content')
    <div class="container">
        <div class="mdl-color-text--grey-500">
            {{ (new DateTime($created_at))->format('g:i A - F j, Y') ?? '' }}
        </div>
        <h2>{{ $caption_ua ?? $caption_en ?? '' }}</h2>
        {!! $content_ua ?? $content_en ?? '' !!}
    </div>
@endsection
