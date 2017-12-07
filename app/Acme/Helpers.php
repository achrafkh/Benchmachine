<?php
function cleanCache($id)
{
    Cache::forget($id);
    $file = public_path() . '/static/app/benchmark-' . $id . '.html';
    if (file_exists($file)) {
        unlink($file);
    }

    return true;
}

function getPaymentProvider()
{
    $country = getCountryByIp();

    if ('TN' == $country) {
        return 'gpg';
    }
    return 'stripe';
}

function getCountryByIp($ip = null)
{
    if (is_null($ip)) {
        $ip = getUserIP();
    }

    if ('127.0.0.1' == $ip) {
        $ip = '196.178.76.97';
    }

    return geoip_country_code_by_name($ip);
}

function getUserIP()
{
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

// Post request to url + params
function cpost($url, $params)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

// get a page likes number from kpeiz core
function getLikes($id)
{
    return call(env('CORE') . '/platform/likes/' . $id);
}

// get request for a url
function call($url)
{
    // create curl resource
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string
    $output = curl_exec($ch);
    curl_close($ch);

    return json_decode($output);
}

function inEuro($price)
{
    $taux = call('http://free.currencyconverterapi.com/api/v3/convert?q=EUR_TND&compact=y')->EUR_TND->val;

    return $taux * $price;
}

/**
 * calculated variation between two numbers and return an array
 */
function calcVariation($old, $new, $test = false)
{
    $class = '';
    $sign = '';
    $prct = 0;

    if ($new > $old) {
        $class = 'up';
        $sign = '+';
        if (0 != $old) {
            $prct = round((($new - $old) / $old) * 100, 1);
        }
    } elseif ($new < $old) {
        $class = 'down';
        $sign = '-';
        if (0 != $new) {
            $prct = round((($old - $new) / $new) * 100, 1);
        }
    }

    return compact('class', 'sign', 'prct');
}

/**
 * Dumps the provided data on the browser
 */
function d()
{
    array_map(function ($x) {
        (new Illuminate\Support\Debug\Dumper)->dump($x);
    }, func_get_args());
}

/**
 * will return header html (for static render)
 */
function getHtmlHeader($name, $image, $id)
{
    $header = file_get_contents(public_path() . '/static/header.html');
    $header = str_replace('|name|', $name, $header);
    $header = str_replace('|image|', $image, $header);
    $header = str_replace('|action|', url('/benchmarks/wkdownload/' . $id), $header);
    $header = str_replace('|url|', url('/'), $header);

    $header = str_replace('|csrf|', csrf_field(), $header);

    return replace($header);
}

//Adds a string after first occurence
function str_insert($str, $search, $insert)
{
    $index = strpos($str, $search);
    if (false === $index) {
        return $str;
    }
    return substr_replace($str, $search . $insert, $index, strlen($search));
}

// empty white spaces in html
function replace($html)
{
    $preg = [
        "/\n([\S])/" => '$1',
        "/\r/" => '',
        "/\n/" => '',
        "/\t/" => '',
        "/ +/" => ' ',
        "/> +</" => '><',
    ];
    return preg_replace(array_keys($preg), array_values($preg), $html);
}

//Check if provided param is a laravel collection
function isCollection($data)
{
    if ($data instanceof Illuminate\Support\Collection) {
        return true;
    }
    if ($data instanceof Illuminate\Database\Eloquent\Collection) {
        return true;
    }

    return false;
}

// Shorten a given Number EX: Convert 3000 to 3k etc
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

// Get a post image using post real id
function postImage($id, $token = null)
{
    $app_token = env('FACEBOOK_ID') . '|' . env('FACEBOOK_SECRET');
    $fetch_token = ((auth()->check()) ? auth()->user()->token : $app_token);

    if (isset($token)) {
        $fetch_token = $app_token;
    }
    $url = 'https://graph.facebook.com/' . $id . '?fields=full_picture&access_token=' . $fetch_token;

    // create curl resource
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL, $url);
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string
    $output = curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($output);

    if (isset($resp->error) && (null == $token)) {
        return postImage($id, $app_token);
    }
    $img = head(json_decode($output));
    if (!is_string($img)) {
        return '';
    }
    return $img;
}

// Check if string is written in arabic
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
    // if there is more than 1% words writen in arabic return true
    $pct = 0.1;
    if (($arabic_count / $total_count) > $pct) {
        return true;
    }
    return false;
}

// StackOverflow, Only god knows wtf is this
function uniord($u)
{
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
}
