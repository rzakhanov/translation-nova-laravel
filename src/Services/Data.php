<?php

namespace Rzakhanov\Translation\Services;

use function Clue\StreamFilter\fun;

class Data
{
    public static function all($search_key = null)
    {
        $lang_path = config('rzakhanov-translation.lang_path');
        $files = scandir($lang_path);
        $lang_indexes = $all_indexes = $groups = [];

        $lang_paths = collect($files)->filter(function ($shortLang,$index) use(&$all_languages){
            if(preg_match("/^[a-z]{2}$/i", $shortLang)) {
                if(in_array($shortLang,array_keys(config('rzakhanov-translation.languages')))){
                    $all_languages[$shortLang] = config('rzakhanov-translation.languages')[$shortLang];
                    return true;
                }
            }
            return false;
        })->values();

        collect($lang_paths)->map(function ($shortLang, $row_lang) use ( &$groups,$lang_paths, $lang_path, &$lang_indexes, &$all_indexes, $search_key) {

            if (in_array($shortLang, array_keys(config('rzakhanov-translation.languages')))) {

                collect(scandir($lang_path . $shortLang))->map(function ($index) use ( &$groups,&$lang_indexes, &$all_indexes, $lang_path, $shortLang, $search_key, $row_lang, $lang_paths) {
                    $group_pattern = '/^([A-z0-9.-]+)\.php$/i';
                    if (preg_match($group_pattern, $index)) {

                        $group = htmlspecialchars(preg_replace($group_pattern, "$1", $index));

                        $group_result = (!$search_key || (preg_match("/".preg_quote($search_key)."/i",$group)));
                        $index_result = (!$search_key || preg_match("/".preg_quote($search_key)."/i",$index));

                        if (!in_array($group, config('rzakhanov-translation.disabled_groups'))) {
                            if(!in_array($group,$groups)) {
                                $groups[] = $group;
                            }

                            $data = collect(array_reverse(require($lang_path . $shortLang . '/' . $index)))->mapWithKeys(function ($item, $key) use ($group_result, &$all_indexes, &$lang_indexes, $lang_paths, $group, $shortLang, $search_key,) {

                                $result = ((!$search_key || (preg_match("/".preg_quote($search_key)."/i",$item))) || (preg_match("/".preg_quote($search_key)."/i",$key)) || $group_result)?[htmlspecialchars($key) => htmlspecialchars($item)]:[];

                                if ($result || $group_result) {
                                    collect($lang_paths)->map(function ($shLang) use (&$lang_indexes, &$all_indexes, $shortLang, $group, $key) {
                                        if ($shortLang !== $shLang && !isset($lang_indexes[$group][$shLang][$key])) {

                                            $lang_indexes[$group][$shLang][$key] = $all_indexes[$group][$key] = null;
                                        }
                                    });

                                    $lang_indexes[$group][$shortLang][$key] =  $all_indexes[$group][$key] =  $item;
                                }

                                return $result;
                            })->toArray();
                        }
                    }
                });
            }
        });

        return compact('lang_path', 'groups','all_languages', 'files', 'lang_paths', 'lang_indexes', 'all_indexes');
    }

    public static function languages()
    {
        return self::all()['all_languages'];
    }

    public static function groups()
    {
        return self::all()['groups'];
    }


    public static function replaceToContent($array): string
    {
        $content = '<?php ' . PHP_EOL . ' return [ ' . PHP_EOL;

        foreach ($array as $key => $item) {
            $content .= "\t'" . (string)str_replace("'", "\'", $key) . "' => '" . str_replace("'", "\'", $item) . "'," . PHP_EOL;
        }
        $content .= PHP_EOL . '];';
        return $content;
    }

    public static function replaceToPureContent($array): string
    {
        $content = ' [ ' . PHP_EOL;

        foreach ($array as $key => $item) {
            $content .= "\t'" . (string)str_replace("'", "\'", $key) . "' => '" . str_replace("'", "\'", $item) . "'," . PHP_EOL;
        }
        $content .= PHP_EOL . ']';
        return $content;
    }
}
