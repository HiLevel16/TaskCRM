<?php

if (!function_exists('convert_currency')) {
    function convert_currency($from, $to, $amount)
    {
        $url = file_get_contents_curl('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra&apiKey=ef63c6bcd5abb1b56dc7');
        $json = json_decode($url, true);
        $rate = implode(" ",$json);
        $total = $rate * $amount;
        $rounded = round($total);
        return $total;
    }
}

if (!function_exists('get_five_currencies')) {
    function get_five_currencies($currency_base, $currency_value)
    {
        $currencies = [
            'usd',
            'eur',
            'btc',
            'uah',
            'rub'
        ];

        if(($key = array_search($currency_base, $currencies)) !== FALSE){
            unset($currencies[$key]);
        }
        $result = [$currency_base => $currency_value];

        foreach ($currencies as $currency) {
            $result[$currency] = convert_currency($currency_base, $currency, $currency_value);
        }
        return $result;
    }
}

if (!function_exists('file_get_contents_curl')) {
    function file_get_contents_curl( $url ) {

      $ch = curl_init();

      curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
      curl_setopt( $ch, CURLOPT_HEADER, 0 );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt( $ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

      $data = curl_exec( $ch );
      curl_close( $ch );

      return $data;

    }
}

?>