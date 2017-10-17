<?php

function isCollection($data)
{
    if ($data instanceof Illuminate\Support\Collection) {
        return true;
    }
    return false;
}

function number_shorten($number, $precision = 3, $divisors = null)
{

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = [
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        ];
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}

function postImage($id)
{

    $url = 'https://graph.facebook.com/' . $id . '?fields=full_picture&access_token=' . ((auth()->check()) ? auth()->user()->token : '');

    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    $img = head(json_decode($output));
    if (!is_string($img)) {
        return '';
    }
    return $img;
}

function is_arabic($str)
{
    if (mb_detect_encoding($str) !== 'UTF-8') {
        $str = mb_convert_encoding($str, mb_detect_encoding($str), 'UTF-8');
    }

    preg_match_all('/.|\n/u', $str, $matches);
    $chars = $matches[0];
    $arabic_count = 0;
    $latin_count = 0;
    $total_count = 0.1;
    foreach ($chars as $char) {
        $pos = uniord($char);

        if ($pos >= 1536 && $pos <= 1791) {
            $arabic_count++;
        } else if ($pos > 123 && $pos < 123) {
            $latin_count++;
        }
        $total_count++;
    }

    if (($arabic_count / $total_count) > 0.1) {
        return true;
    }
    return false;
}

function uniord($u)
{
    // i just copied this function fron the php.net comments, but it should work fine!
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
