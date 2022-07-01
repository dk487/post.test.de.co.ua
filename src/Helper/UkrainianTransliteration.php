<?php
declare(strict_types=1);

namespace Helper;

// https://zakon.rada.gov.ua/laws/show/55-2010-%D0%BF

class UkrainianTransliteration
{
    const ENCODING = 'UTF-8';

    public const TRANSLIT_FIRST = [
        'є' => 'ye',
        'ї' => 'yi',
        'й' => 'y',
        'ю' => 'yu',
        'я' => 'ya',
    ];

    public const TRANSLIT_TWO = [
        'зг' => 'zgh',
    ];

    public const TRANSLIT = [
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'h',
        'ґ' => 'g',
        'д' => 'd',
        'е' => 'e',
        'є' => 'ie',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'y',
        'і' => 'i',
        'ї' => 'i',
        'й' => 'i',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'kh',
        'ц' => 'ts',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'shch',
        'ю' => 'iu',
        'я' => 'ia',
        'ь' => '',
        '\'' => '',
    ];

    public function convertWord(string $input): string
    {
        $input = mb_strtolower($input, self::ENCODING);
        $len = mb_strlen($input, self::ENCODING);
        $isFirst = true;
        $result = '';

        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($input, $i, 1, self::ENCODING);
            $c2 = mb_substr($input, $i, 2, self::ENCODING);

            if ($isFirst && array_key_exists($c, self::TRANSLIT_FIRST)) {
                $result .= self::TRANSLIT_FIRST[$c];
            } elseif (array_key_exists($c2, self::TRANSLIT_TWO)) {
                $result .= self::TRANSLIT_TWO[$c2];
                $i++;
            } elseif (array_key_exists($c, self::TRANSLIT)) {
                $result .= self::TRANSLIT[$c];
            } else {
                $result .= iconv(self::ENCODING, 'ASCII//TRANSLIT', $c);
            }

            $isFirst = false;
        }

        return $result;
    }

    function convertToSlug(string $input): string
    {
        $words = preg_split('/[^\w\d\']+/u', $input);
        return join('-', array_map(fn($w) => $this->convertWord($w), $words));
    }

}
