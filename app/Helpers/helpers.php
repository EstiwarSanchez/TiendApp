<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * Check if route is active
 *
 * @return Boolean
 */
function activeRoute($routeName)
{
    $routeName = $routeName != null ? $routeName : '';
    if (isset($routeName->sublinks)) {
        return activeRouteSubLink($routeName->sublinks);
    }
    return request()->routeIs($routeName);
}

function activeRouteSubLink($sublinks)
{
    $result = false;
    foreach ($sublinks as $link) {
        if (isset($link->sublinks)) {
            $result = activeRouteSubLink($link->sublinks);
            if ($result) {
                break;
            }
        }
        if (request()->routeIs($link->route)) {
            $result = true;
            break;
        }
    }
    return $result;
}

function getTour()
{
    return session()->get('tour') ?? null;
}

function notificationType($type)
{
    $type = explode("\\", $type);
    return end($type);
}

function getUserToken(){
    return session()->get('actor') ? json_decode(session()->get('actor')) : null;
}

function getReceiverToken(){
    return session()->get('receiver') ? json_decode(session()->get('receiver')) : null;
}

function isStandarUser(){
    return auth()->id() && auth()->id()>2;
}

function removeTags($str)
{
    $tags = [
        '<div>', '<span>', '<strong>', '<ul>', '<li>', '<ol>', '<pre>', '<blockquote>', '<em>',
        '</div>', '</span>', '</strong>', '</ul>', '</li>', '</ol>', '</pre>', '</blockquote>', '</em>',
        '<br>', '<h1>', '</h1>', '<b>','</b>'
    ];
    foreach ($tags as $tag) {
        $str = str_replace($tag, "", $str);
    }

    while (strpos($str, "<a") !== false && strpos($str, "</a") !== false) {
        $last_a = strpos($str, "<a");
        $last_ac = strpos($str, "</a") + 4;
        $str1 = substr($str, 0, $last_a);
        $str2 = substr($str, $last_ac, strlen($str));
        $str = $str1 . $str2;
    }

    return trim($str);
}

function ___($key = null, $replace = [], $lower = true, $locale = null)
{
    if (is_null($key)) {
        return $key;
    }

    if (!empty($replace) && $lower) {
        $replace = array_map('nestedLowercase', $replace);
    }
    return trans($key, $replace, $locale);
}


function nestedLowercase($value) {
    if (is_array($value)) {
        return array_map('nestedLowercase', $value);
    }
    return Str::lower($value);
}



/**
 * Check if view exist
 *
 * @return Boolean
 */
function viewExists($viewName = '')
{
    return View::exists($viewName);
}

/**
 * Retrieve our Locale instance
 *
 * @return App\Locale
 */
function locale()
{
    return app()->getLocale();
}


function getUser()
{
    if(is_null(session()->get('user.guest'))){
        return json_decode(session()->get('user'))->user ?? auth()->user();
    }

}

function guestPhoto()
{
    return 'https://ui-avatars.com/api/?name='.urlencode(getUserToken() ? getUserToken()->name : __('Guest')).'&color=7F9CF5&background=EBF4FF';
}

/**
 *  Retrieve status color
 *
 * @return String $color
 */
function getStatusColor($status)
{
    $status = getStatus($status);

    $color = 'gray';
    if ($status == 1) {
        $color = 'psi-green';
    }
    if ($status == 2) {
        $color = 'psi-orange';
    }
    if ($status == 3) {
        $color = 'psi-blue';
    }
    if ($status == 4) {
        $color = 'purple';
    }
    return $color;
}


function getValueTable($column, $item, $default = '')
{
    $val = $default;
    if (is_array($column)) {
        if (is_array($column[1])) {
            if (Str::contains($column[1][1], '.')) {
                $column[1][1] = explode('.', $column[1]);
                $column[1][1] = $column[1][1];
            }
            if (isset($item[$column[0]][$column[1][0]][$column[1][1]])) {
                $val = $item[$column[0]][$column[1][0]][$column[1][1]];
            }
        } else {
            if (Str::contains($column[1], '.')) {
                $column[1] = explode('.', $column[1]);
                $column[1] = $column[1][1];
            }
            if (isset($item[$column[0]][$column[1]])) {
                $val = $item[$column[0]][$column[1]];
            }
        }
    } else {
        if (Str::contains($column, '.')) {
            $column = explode('.', $column);
            $column = $column[1];
        }
        $val = $item[$column] ?? $default;
    }

    return $val;
}


/**
 *  Generate ramdom string
 *
 *  @return String $randomString
 */
function randomString($length = 10, $specialCharts = false)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters .= $specialCharts ? '!@#$%^&*-+=' : '';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    if ($specialCharts && !preg_match('/^.{' . $length . ',' . $length . '}$(?=.*\d)|(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $randomString)) {
        $randomString = randomString($length, $specialCharts);
    }
    return $randomString;
}

/**
 *  Generate random array color hex code
 *  @return Array $result
 */
function ramdomColors($num = 0)
{
    $colors = [
        '#f8b4b4',
        '#e02424',
        '#9b1c1c',
        '#faca15',
        '#9f580a',
        '#723b13',
        '#84e1bc',
        '#057a55',
        '#03543f',
        '#B1DA83',
        '#72BC23',
        '#4E8018',
        '#71CEE7',
        '#03A8D5',
        '#037391',
        '#F0BD81',
        '#E4891F',
        '#9B5F15',
    ];
    $result = [];
    $index = array_rand($colors, $num);
    foreach ($index as $i) {
        $result[] = $colors[$i];
    }
    return $result;
}

/**
 * Validate date
 *
 * @param $date
 * @param $format = 'Y-m-d'
 *
 * @return Boolean
 */

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Check if date is greater than other date
 *
 * @param $first_date
 * @param $second_date
 *
 * @return Boolean $result
 */

function dateGreater($first_date, $second_date)
{
    $first_date = new Carbon($first_date);
    $second_date = new Carbon($second_date);

    $result = $first_date->gt($second_date);
    dd($result);
}

/**
 * Add days to date
 *
 * @param $date
 * @param $days = 0
 *
 * @return String $date
 */

function addDaysToDate($date, $days = 0, $format = 'Y-m-d')
{
    if (!validateDate($date)) {
        return false;
    }
    $date = Carbon::createFromFormat($format, $date);
    return $date->addDays($days)->format($format);
}


function money($val = 0, $decimals = 0)
{
    if (is_numeric($val)) {
        $value = number_format($val, $decimals, ',', '.');
        if ($decimals > 0) {
            $checkZero = explode(',', $value);
            return (int)$checkZero[1] > 0 ? $value : $checkZero[0];
        } else {
            return $value;
        }
    } else {
        return 0;
    }
}


function decimals($val, $decimals)
{
    if (is_numeric($val)) {
        $value = number_format($val, $decimals, '.', '');
        $checkZero = explode('.', $value);
        return (int)$checkZero[1] > 0 ? (float)$value : (int)$checkZero[0];
    } else {
        return 0;
    }
}

function getStatus($str)
{
    $s = $str == 1 ? __('Active') : __('Inactive');
    if ($s === 'Inactive' || $s === 'Inactivo') {
        $val = 0;
    } else if ($s === 'Activo' || $s === 'Active' ) {
        $val = 1;
    }

    return $val;
}

function stristr_in_array($str, $array)
{
    foreach ($array as $value){ if (stristr($value, $str) !== false){ return true;}}
    return false;
}

function formatSizeUnits($bytes, $withUnit = false)
    {
        $unit = '';
        if ($bytes >= 1073741824)
        {
            $unit = ' GB';
            $bytes = number_format($bytes / 1073741824, 2);
        }
        elseif ($bytes >= 1048576)
        {
            $unit = ' MB';
            $bytes = number_format($bytes / 1048576, 2);
        }
        elseif ($bytes >= 1024)
        {
            $unit = ' KB';
            $bytes = number_format($bytes / 1024, 2);
        }
        elseif ($bytes > 1)
        {
            $unit = ' bytes';
        }
        elseif ($bytes == 1)
        {
            $unit = ' byte';
        }
        else
        {
            $unit = ' bytes';
            $bytes = 0;
        }

        if ($withUnit) {
            $bytes = [$bytes,$unit];
        }else{
            $bytes = $bytes.$unit;
        }
        return $bytes;
}

function dateToHuman($date, $hour = false)
{
    $date = new Carbon($date);
    $format = $hour ? 'M j, Y H:i' : 'M j, Y';
    return Str::ucfirst($date->translatedFormat($format));
}

function monthToHuman($date)
{
    $date = new Carbon($date);
    return Str::ucfirst($date->translatedFormat('M Y'));
}


function getParamsValues($item, $params)
{
    $values = [];
    if (is_array($params)) {
        foreach ($params as $param) {
            if (is_array($param)) {
                $values[] =  isset($item[$param[0]][$param[1]]) ? '`' . $item[$param[0]][$param[1]] . '`' : '`' . $param[0][$param[1]] . '`';
            }else{
                $values[] =  isset($item[$param]) ? '`' . $item[$param] . '`' : '`' . $param . '`';
            }

        }
        $values = implode(', ', $values) . ', $dispatch';
    } else {
        $values = '`' . (isset($item[$params]) ? $item[$params] : $params) . '`, $dispatch';
    }
    return $values;
}
