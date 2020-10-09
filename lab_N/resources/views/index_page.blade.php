@extends('admin_base', ['path' => "/page", $lang])

@section('title', 'Список сторінок')

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800">
        <h2>Список Сторінок</h2>
        <a href="/page/create" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored my-floating-button mdl-shadow--4dp">
            <i class="material-icons">add</i>
        </a>
    </div>

    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800 mdl-grid">
        @foreach($containers as $container)
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-card my-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-card--expand my-card-background" style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0,0,0,0.49) 100%), url({{ asset('storage/images/'.($container->page_photo_path ?? 'default.png')) }});">
                    <h5 class="mdl-card__title-text">{{ $lang == 'ua' ? $container->caption_ua ?? '' : $container->caption_en ?? '' }}</h5>
                </div>
                <div class="mdl-card__supporting-text">
                    {{ $lang == 'ua' ? $container->intro_ua ?? '' : $container->intro_en ?? '' }}
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="{{ $lang == 'ua' ? "/$container->code" : "/$container->code/en" }}">
                        {{ $lang == 'ua' ? 'Переглянути' : 'Show' }}
                    </a>
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href={{ "/page/$container->code/edit" }}>
                        Редагувати
                    </a>
                    <form style="display: inline-block" action="{{ url('/page', ['id' => $container->code]) }}" method="post">
                        <button id="delete_btn" class="mdl-button mdl-button--colored mdl-color-text--red mdl-js-button mdl-js-ripple-effect" onclick="Ask(event);" {{--type="submit"--}}>Видалити</button>
                        @method('delete')
                        @csrf
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @foreach($items as $item)
        <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-grid mdl-shadow--2dp mdl-color--white">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-card">
                <div class="mdl-card--expand my-card-background" style="background-image: url( {{ asset('storage/images/'.($item->page_photo_path ?? 'default.png')) }});"></div>
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
                        <button id="delete_btn" class="mdl-button mdl-button--colored mdl-color-text--red mdl-js-button mdl-js-ripple-effect" onclick="Ask(event);" type="submit">Видалити</button>
                        @method('delete')
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function Ask(event) {
            e = event || window.event;
            if(confirm('Ви впевнені, що хочете видалити цей пост?'))
                console.log('yes');
            else
                e.preventDefault();
        }
    </script>
@endsection
