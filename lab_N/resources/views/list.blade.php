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
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800">
        <h2>{{ $lang == 'ua' ? $caption_ua ?? '' : $caption_en ?? '' }}</h2>
        <h5>{{ $lang == 'ua' ? $intro_ua ?? '' : $intro_en ?? '' }}</h5>
        {!! $lang == 'ua' ? $content_ua ?? '' : $content_en ?? '' !!}
    </div>

    @foreach($items as $item)
        <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-grid mdl-shadow--2dp mdl-color--white">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-card">
                <div class="mdl-card--expand my-card-background" style="background-image: url({{ asset('storage/images/'.($item->page_photo_path ?? 'default.png')) }});"></div>
            </div>
            <div class="mdl-cell mdl-cell--8-col-desktop mdl-card">
                <div class="mdl-card__title">
                    <h4 class="mdl-card__title-text">{{ $lang == 'ua' ? $item->caption_ua ?? '' : $item->caption_en ?? '' }}</h4>
                </div>
                <div class="mdl-card__supporting-text mdl-card--expand">
                    {{ $lang == 'ua' ? $item->intro_ua ?? '' : $item->intro_en ?? '' }}
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="{{ $lang == 'ua' ? "/$item->code" : "/$item->code/en" }}">
                        {{ $lang == 'ua' ? 'Дізнатися більше' : 'Read more' }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@endsection
