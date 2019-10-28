<?php

namespace LoiPham\Language\Supports;

class Language
{

    protected static $languages = [
        'en'             => ['en', 'en', 'English', 'ltr', 'en'],
        'fr_BE'          => ['fr_BE', 'fr_BE', 'Français', 'ltr', 'fr_BE'],
        'id_ID'          => ['id_ID', 'id_ID', 'Bahasa Indonesia', 'ltr', 'id_ID'],
        'ko_KR'          => ['ko_KR', 'ko_KR', '한국어', 'ltr', 'ko_KR'],
        'vi'             => ['vi', 'vi', 'Tiếng Việt', 'ltr', 'vi'],
        'zh_CN'          => ['zh_CN', 'zh_CN', '中文 (中国)', 'ltr', 'zh_CN'],
    ];

    /**
     * @return array
     * @modified Sang Nguyen
     */
    public static function getListLanguages()
    {
        return self::$languages;
    }
}
