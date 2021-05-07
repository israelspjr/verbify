<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'language' => 'portugues',
    'language_abbr' => 'pt',
    'lang_uri_abbr' => array("pt" => "portugues", "en" => "english"),
    'lang_ignore' => 'xx', //Note that it will look for a language named 'xx' in i18n. Therefore i18n:get('txt_sometext') will return 'txt_sometext'.
    'lang_desc' => array("en" => "English version", "pt"=>"Portuguese version"),
);