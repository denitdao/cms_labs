@extends('base', ['path' => "/page/create", $lang])

@section('title', 'Створення сторінки')

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script defer src="{{ asset('js/set_editors.js') }}" type="text/javascript"></script>
    <script defer src="{{ asset('js/create_page.js') }}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@endsection

@section('content')
    <div class="mdl-cell mdl-cell--2-offset-desktop mdl-cell--8-col mdl-color-text--grey-800 mdl-shadow--2dp mdl-color--white my-post-content">
        <div class="container">
            <h3>Створення сторінки</h3>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                <input class="mdl-textfield__input" type="text" id="caption_ua" maxlength="160">
                <label class="mdl-textfield__label" for="caption_ua">Заголовок Українською</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                <input class="mdl-textfield__input" type="text" id="caption_en" maxlength="160">
                <label class="mdl-textfield__label" for="caption_en">Caption English</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                <textarea class="mdl-textfield__input" type="text" rows="1" id="intro_ua" maxlength="400"></textarea>
                <label class="mdl-textfield__label" for="intro_ua">Опис Українською</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                <textarea class="mdl-textfield__input" type="text" rows="1" id="intro_en" maxlength="400"></textarea>
                <label class="mdl-textfield__label" for="intro_en">Intro English</label>
            </div>

            <h5>Контент Українською</h5>
            <div id="editor_content_ua">
                <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"></div>
            </div>

            <h5>Content English</h5>
            <div id="editor_content_en">
                <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"></div>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                <input class="mdl-textfield__input" type="text" id="code" maxlength="160">
                <label class="mdl-textfield__label" for="code">Унікальний код сторінки</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="number" id="order_num">
                <label class="mdl-textfield__label" for="order_num">Порядковий номер</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="parent_code" maxlength="160">
                <label class="mdl-textfield__label" for="parent_code">Код сторінки контейнера</label>
            </div>
            <br>
            <button id="create" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Create</button>
            <div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div>
        </div>
    </div>
@endsection
