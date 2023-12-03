<?php

if (!function_exists('limitSentences')) {
    function limitSentences($text, $limit)
    {
        $sentences = strtok($text, '.');
        $result = '';
        $counter = 0;

        while ($sentences !== false && $counter < $limit) {
            $result .= $sentences . '.';
            $sentences = strtok('.');
            $counter++;
        }

        return trim($result);
    }
}


if (!function_exists('limit_words')) {
    function limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit));
    }
}


?>
