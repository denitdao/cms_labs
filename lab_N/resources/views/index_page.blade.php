@extends('base', ['path' => "/page", $lang])

@section('title', 'Список сторінок')

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800 my-post-content">
        <h3>Список Сторінок</h3>
        <a href="/page/create" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
            <i class="material-icons">add</i>
        </a>
    </div>

    @foreach($items as $item)
        <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-grid mdl-shadow--2dp mdl-color--white">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-card">
                <div class="mdl-card--expand my-card-background" style="background-image: url( {{ asset('images/'.($item->page_photo_path ?? 'default.png')) }});"></div>
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
                        {{ $lang == 'ua' ? 'Переглянути' : 'Show' }}
                    </a>
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href={{ "/page/$item->code/edit" }}>
                        Редагувати
                    </a>
                    <form style="display: inline-block" action="{{ url('/page', ['id' => $item->code]) }}" method="post">
                        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Видалити</button>
                        @method('delete')
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
