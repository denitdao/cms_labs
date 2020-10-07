@extends('base', ['path' => "/$code", $lang])

@section('title', $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '')

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800">
        @php
            $parent = \App\Models\Page::find($parent_id);
            $arrays = [];
            while($parent_id != $id) {
                array_push($arrays, ['code' => $parent->code, 'caption_ua' => $parent->caption_ua, 'caption_en' => $parent->caption_en]);
                if($parent->parent_id == $parent->id) break;
                $parent = \App\Models\Page::find($parent->parent_id);
            }
        @endphp
        @foreach(array_reverse($arrays) as $array)
            <a href="/{{ $lang == 'ua' ? $array['code'] : $array['code'].'/en' }}" class="mdl-button mdl-js-button mdl-button--primary">{{ $lang == 'ua' ? $array['caption_ua'] : $array['caption_en'] }}</a>
            @if(!$loop->last)<span class="mdl-button--primary"> > </span>@endif
        @endforeach
    </div>
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
