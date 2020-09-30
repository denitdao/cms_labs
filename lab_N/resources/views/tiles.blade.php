@extends('base', ['path' => "/$code", $lang])

@section('title', $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '')

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800">
        <h2>{{ $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '' }}</h2>
        <h5>{{ $lang == 'ua' ? $intro_ua ?? '' : $intro_en ?? '' }}</h5>
        {!! $lang == 'ua' ? $content_ua ?? '' : $content_en ?? '' !!}
    </div>

    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800 mdl-grid">
        @foreach($items as $item)
            <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--4-col-tablet mdl-card my-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-card--expand my-card-background" style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0,0,0,0.49) 100%), url({{ asset('storage/images/'.($item->page_photo_path ?? 'default.png')) }});">
                    <h5 class="mdl-card__title-text">{{ $lang == 'ua' ? $item->caption_ua ?? '' : $item->caption_en ?? '' }}</h5>
                </div>
                <div class="mdl-card__supporting-text">
                    {{ $lang == 'ua' ? $item->intro_ua ?? '' : $item->intro_en ?? '' }}
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="{{ $lang == 'ua' ? "/$item->code" : "/$item->code/en" }}">
                        {{ $lang == 'ua' ? 'Дізнатися більше' : 'Read more' }}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
