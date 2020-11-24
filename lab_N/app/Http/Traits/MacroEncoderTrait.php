<?php
namespace App\Http\Traits;

use App\Models\Page;

trait MacroEncoderTrait
{
    private static function macroEncodeUa($content) {
        //debug(preg_replace('/~{\s*'."link, covid-19-only-one-region-ready-for-lifting-curbs, some title".'\s*}~/', "_", "~{link, covid-19-only-one-region-ready-for-lifting-curbs, some title }~"));

        foreach (self::findMacros($content) as $macro) {
            debug($macro);
            $commands = array_map('trim', explode(';', $macro));
            switch ($commands[0]){
                case 'link': {
                    self::linkReplaceUa($content, $macro, @$commands[1], @$commands[2]);
                    break;
                }
                case 'tiles': {
                    self::tilesReplaceUa($content, $macro, @$commands[1], @$commands[2]);
                    break;
                }
                default:
                    break;
            }

        }
        return $content;
    }

    private static function macroEncodeEn($content) {
        foreach (self::findMacros($content) as $macro) {
            debug($macro);
            $commands = array_map('trim', explode(';', $macro));
            switch ($commands[0]){
                case 'link': {
                    self::linkReplaceEn($content, $macro, @$commands[1], @$commands[2]);
                    break;
                }
                case 'tiles': {
                    self::tilesReplaceEn($content, $macro, @$commands[1], @$commands[2]);
                    break;
                }
                default:
                    break;
            }
        }
        return $content;
    }

    private static function findMacros($content){
        preg_match_all('#~{(.*?)}~#', $content, $macros);
        return $macros[1];
    }

    private static function linkReplaceUa(&$content, $macro, $code, $text){
        $page = Page::firstWhere('code', $code);
        if(!is_null($page)) {
            $content = preg_replace('/~{\s*'.$macro.'\s*}~/','<a href="/'.$page->code.'" style="background-color: transparent; color: rgb(31, 31, 38);">'.($text ?? $page->caption_ua).'</a>', $content);
        }
    }

    private static function linkReplaceEn(&$content, $macro, $code, $text){
        $page = Page::firstWhere('code', $code);
        if(!is_null($page))
            $content = preg_replace('/~{\s*'.$macro.'\s*}~/','<a href="/'.$page->code.'/en" style="background-color: transparent; color: rgb(31, 31, 38);">'.($text ?? $page->caption_en).'</a>', $content);
    }

    private static function tilesReplaceUa(&$content, $macro, $code, $amount){
        $page = Page::getPage($code);
        if(!isset($page->items)) return;
        $tiles ='<div class="mdl-cell mdl-cell--12-col mdl-color-text--grey-800 mdl-grid">';
        foreach($page->items->slice(0, $amount) as $item) {
            $tiles .=
            '<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--4-col-desktop mdl-card mdl-shadow--3dp">
                <div class="mdl-card__title mdl-card--expand my-card-background" style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0,0,0,0.49) 100%), url('.asset('storage/images/'.($item->page_photo_path ?? 'default.png')).');">
                    <h5 class="mdl-card__title-text">'.($item->caption_ua ?? "").'</h5>
                </div>
                <div class="mdl-card__supporting-text">'.($item->intro_ua ?? "").'</div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="/'.($item->alias_of_page()->first()->code ?? $item->code).'">
                        Дізнатися більше
                    </a>
                </div>
            </div>';
        }
        $tiles .= '</div>';
        if(!is_null($tiles)) {
            $content = preg_replace('/~{\s*'.$macro.'\s*}~/',$tiles, $content);
        }
    }

    private static function tilesReplaceEn(&$content, $macro, $code, $amount){
        $page = Page::getPage($code);
        if(!isset($page->items)) return;
        $tiles ='<div class="mdl-cell mdl-cell--12-col mdl-color-text--grey-800 mdl-grid">';
        foreach($page->items->slice(0, $amount) as $item) {
            $tiles .=
                '<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--4-col-desktop mdl-card mdl-shadow--3dp">
                <div class="mdl-card__title mdl-card--expand my-card-background" style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0,0,0,0.49) 100%), url('.asset('storage/images/'.($item->page_photo_path ?? 'default.png')).');">
                    <h5 class="mdl-card__title-text">'.($item->caption_en ?? "").'</h5>
                </div>
                <div class="mdl-card__supporting-text">'.($item->intro_en ?? "").'</div>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="/'.($item->alias_of_page()->first()->code ?? $item->code).'/en">
                        Read more
                    </a>
                </div>
            </div>';
        }
        $tiles .= '</div>';
        if(!is_null($tiles)) {
            $content = preg_replace('/~{\s*'.$macro.'\s*}~/',$tiles, $content);
        }
    }
}
