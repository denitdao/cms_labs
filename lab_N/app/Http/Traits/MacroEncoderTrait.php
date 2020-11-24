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
}
