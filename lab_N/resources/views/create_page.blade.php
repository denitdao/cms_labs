@extends('admin_base', ['path' => "/page/create", $lang])

@section('title', 'Створення сторінки')

@section('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script defer src="{{ asset('js/general_admin.js') }}" type="text/javascript"></script>
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

            <div id="page_settings">
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" style="margin-right: 40px" for="publication">
                    <input type="radio" id="publication" class="mdl-radio__button" name="page_type" value="publication" checked>
                    <span class="mdl-radio__label">Publication</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" style="margin-right: 40px" for="container">
                    <input type="radio" id="container" class="mdl-radio__button" name="page_type" value="container">
                    <span class="mdl-radio__label">Container</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="alias">
                    <input type="radio" id="alias" class="mdl-radio__button" name="page_type" value="alias">
                    <span class="mdl-radio__label">Alias</span>
                </label>
            </div>

            <div id="container_settings">
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" style="margin-right: 40px" for="list">
                    <input type="radio" id="list" class="mdl-radio__button" name="view_type" value="list" checked>
                    <span class="mdl-radio__label">List</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="tiles">
                    <input type="radio" id="tiles" class="mdl-radio__button" name="view_type" value="tiles">
                    <span class="mdl-radio__label">Tiles</span>
                </label>
                <br>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" style="margin-right: 40px" for="date_desc">
                    <input type="radio" id="date_desc" class="mdl-radio__button" name="order_type" value="date_desc" checked>
                    <span class="mdl-radio__label">Date</span>
                </label>
                <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="order_num_asc">
                    <input type="radio" id="order_num_asc" class="mdl-radio__button" name="order_type" value="order_num_asc">
                    <span class="mdl-radio__label">Order number</span>
                </label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <h5>Зображення для сторінки</h5>
                <img class="my-image-preview" id="image_preview_container" src="{{ asset('storage/images/'.($item->page_photo_path ?? 'default.png')) }}"
                     alt="preview image">
                <input class="mdl-textfield__input" type="file" id="page_photo">
            </div>

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

            <div id="container_content">
                <h5>Контент Українською</h5>
                <div id="editor_content_ua">
                    <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"></div>
                </div>

                <h5>Content English</h5>
                <div id="editor_content_en">
                    <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"></div>
                </div>
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
            <button id="create" class="mdl-button mdl-js-button mdl-button--raised mdl-color--green">Create</button>
            <a href="{{request()->headers->get('referer')}}" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Cancel</a>
            <div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div>
        </div>
    </div>
@endsection
