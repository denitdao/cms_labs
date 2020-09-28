@extends('base', ['path' => "/$code", $lang])

@section('title', $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '')

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800 mdl-shadow--2dp mdl-color--white my-post-content">
        <div class="container">
            <div class="mdl-color-text--grey-500">
                {{ (new DateTime($created_at ?? ''))->format('g:i A - F j, Y') }}
            </div>
            <h2>{{ $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '' }}</h2>
            {!! $lang == 'ua' ? $content_ua ?? '' : $content_en ?? '' !!}
        </div>
    </div>
@endsection
