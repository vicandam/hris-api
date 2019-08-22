<?php
function set_response_param($results, $auth=null, $input=null) {
    if(env('APP_ENV') != 'production') {
        if(!empty($input)) {
            $results['param'] = $input;
        }

        if(!empty($auth)) {
            $results['auth'] = $auth;
        }
    }

    return $results;
}

function parse_number($number, $dec_point = null)
{
    if (empty($dec_point)) {
        $locale = localeconv();
        $dec_point = $locale['decimal_point'];
    }
    return floatval(str_replace($dec_point, '.', preg_replace('/[^\d' . preg_quote($dec_point) . ']/', '', $number)));
}

function page_reload_increment($init = null)
{

    if ($init == null) {
        // Retrieve a piece of data from the session...
        $pageReloadIncrement = session('pageReloadIncrement');
        $pageReloadIncrement++;
        // Specifying a default value...
    } else {
        $pageReloadIncrement = 1;
    }

    return session('pageReloadIncrement', $pageReloadIncrement);
}

function getIp()
{
//    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
//        if (array_key_exists($key, $_SERVER) === true) {
//            foreach (explode(',', $_SERVER[$key]) as $ip) {
//                $ip = trim($ip); // just to be safe
//
//                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
//                    return $ip;
//                }
//            }
//        }
//    }

//    $clientIps = array();
//    $ip = $this->server->get('REMOTE_ADDR');
//    if (!$this->isFromTrustedProxy()) {
//        return array($ip);
//    }
//    if (self::$trustedHeaders[self::HEADER_FORWARDED] && $this->headers->has(self::$trustedHeaders[self::HEADER_FORWARDED])) {
//        $forwardedHeader = $this->headers->get(self::$trustedHeaders[self::HEADER_FORWARDED]);
//        preg_match_all('{(for)=("?\[?)([a-z0-9\.:_\-/]*)}', $forwardedHeader, $matches);
//        $clientIps = $matches[3];
//    } elseif (self::$trustedHeaders[self::HEADER_CLIENT_IP] && $this->headers->has(self::$trustedHeaders[self::HEADER_CLIENT_IP])) {
//        $clientIps = array_map('trim', explode(',', $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_IP])));
//    }
//    $clientIps[] = $ip; // Complete the IP chain with the IP the request actually came from
//    $ip = $clientIps[0]; // Fallback to this when the client IP falls into the range of trusted proxies
//    foreach ($clientIps as $key => $clientIp) {
//        // Remove port (unfortunately, it does happen)
//        if (preg_match('{((?:\d+\.){3}\d+)\:\d+}', $clientIp, $match)) {
//            $clientIps[$key] = $clientIp = $match[1];
//        }
//        if (IpUtils::checkIp($clientIp, self::$trustedProxies)) {
//            unset($clientIps[$key]);
//        }
//    }
//    // Now the IP chain contains only untrusted proxies and the client IP
//    return $clientIps ? array_reverse($clientIps) : array($ip);
}


function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function lightSize($kb) {
    $deduct = 3;
    $interval = 40000;
    $kb_increment = 0;
    $size = 75;

    do {
        $size -= $deduct;

        if($size < 5) {
            $size = 25;
        }

        $kb_increment += $interval;

        //print " <br> size $size kb increment $kb_increment";

    } while($kb_increment < $kb);

    return $size;
}

function date_db_format($date) {
    return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->toDateString();
}


function yt_exists($videoID) {


    $theURL = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";
    $headers = get_headers($theURL);

    return (substr($headers[0], 9, 3) !== "404");
}
function vm_exists($videoID) {
    $headers = get_headers('https://vimeo.com/api/oembed.json?url=https://vimeo.com/' . $videoID);

    $status = '';

    $status = (!empty($headers[0]) ? $headers[0] : null);

    if(strpos($status, '200') > -1) {
      return true;
    }

    return false;
}

function to_slug($string, $type, $limit = 50) {
    $slug = str_slug(substr($string, 0, $limit));

    if(empty($slug)) {
        return $type;
    }

    return $slug;
}

function to_slug_generate_if_empty($post) {

}

function short_text($string, $limit = 50) {
    $short_text = substr($string, 0, 50);

    return $short_text;
}

function image_decrease_in_size($source, $extension) {
    // Image intervention don't read fake source
    if(env('APP_ENV') != 'testing') {
        $img = Image::make($source);

        $img->save($source, 40)->encode($extension, 75);
    }
}

function to_keyword($string) {
    $string = str_replace('/', '', $string);

    $string = preg_replace('/\s+/', ',', $string);

    return $string;
}

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}


