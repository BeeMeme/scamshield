<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('getSub')) {
    function getSub($ipAddress)
    {
        $sub = '';
        if (strlen($ipAddress) < 20) {
            $splited = explode('.', $ipAddress);
            $sub = $splited[0] . '.' . $splited[1] . '.' . $splited[2];
        } else {
            $splited = explode(':', $ipAddress);
            $sub = $splited[0] . ':' . $splited[1] . ':' . $splited[2] . ':' . $splited[3];
        }
        return $sub;
    }
}
if (!function_exists('get_domain_host')) {
    function get_domain_host($domain)
    {
        $parsed = parse_url(base_url());
        if (isset($parsed['host'])) {
            return $parsed['host'];
        }
        return '';
    }
}
if (!function_exists('compare_links')) {
    function compare_links($a, $b)
    {
        if ($a['rmnViews'] == 0) {
            return 1;
        }
        if ($b['rmnViews'] == 0) {
            return -1;
        }

        if ($a['reward'] > $b['reward']) {
            return -1;
        } else if ($a['reward'] < $b['reward']) {
            return 1;
        } else {
            if ($a['energy'] == $b['energy']) {
                return ($a['rmnViews'] > $b['rmnViews']) ? 1 : -1;
            }
        }
    }
}
if (!function_exists('normalize_email')) {
    function normalize_email($email)
    {
        $email = strtolower($email);
        $parts    = explode('@', $email);

        if (in_array($parts[1], ['gmail.com', 'googlemail.com'])) {
            $before_plus    = strstr($parts[0], '+', TRUE);
            $before_at      = str_replace('.', '', $before_plus ? $before_plus : $parts[0]);
            $email    = $before_at . '@gmail.com';
        }

        return $email;
    }
}
if (!function_exists('getRandomColor')) {
    function getRandomColor($id, $t, $cover = false)
    {
        $colors = [];
        $colors[0] = $id * 4423 % (255 - 2 * $t);
        $colors[1] = $id * 2234 % (255 - 2 * $t);
        $colors[2] = $id * 2763292 % (255 - 2 * $t);
        if ($cover) {
            return 'rgba(' . implode(', ', $colors) . ', 1)';
        }
        return '"rgba(' . implode(', ', $colors) . ', 1)"';
    }
}
