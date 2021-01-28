<?php
date_default_timezone_set("Asia/Bangkok");

function request($url, $data, $headers, $put = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($put) :
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    endif;
    if ($data) :
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    endif;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($headers) :
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    endif;
    curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
    return curl_exec($ch);
}

function regis()
{
    $url = "https://indodax.com/api/webdata/ETHIDR";
    $data = "lang=indonesia";
    $headers = array();
    $headers[] = "Host: indodax.com";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.104 Safari/537.36";
    //$headers [] = "Content-Length: 399";
    $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
    $headers[] = "Cookie: __cfduid=d29087dd042e9d9afbe4dc0ee1dc356bc1611576935; __auc=0a5462ff1773978909f6ff8016b; _fbp=fb.1.1611576939093.739904818; _ga=GA1.2.88803452.1611576939; _gid=GA1.2.1560507211.1611749439; btcid=ad36bfdaa9c53604e882dd88caf90890; __asc=445ca86a177440bd852b339a02b; _gat_gtag_UA_46363731_7=1; _gat_gtag_UA_46363731_11=1";
    $getotp = request($url, $data, $headers);
    $json = json_decode($getotp, true);
    //var_dump($json);
    $last = $json['_24h']['last_price'];
    $buy1 = $json['buy_orders'][0]['sum_rp'];
    $buy2 = $json['buy_orders'][1]['sum_rp'];
    $buy3 = $json['buy_orders'][2]['sum_rp'];
    $buy4 = $json['buy_orders'][3]['sum_rp'];
    $buy5 = $json['buy_orders'][4]['sum_rp'];
    $sell1 = $json['sell_orders'][0]['sum_eth'];
    $sell2 = $json['sell_orders'][1]['sum_eth'];
    $sell3 = $json['sell_orders'][2]['sum_eth'];
    $sell4 = $json['sell_orders'][3]['sum_eth'];
    $sell5 = $json['sell_orders'][4]['sum_eth'];
    $totalbuy = $buy1 + $buy2 + $buy3 + $buy4 + $buy5;
    $totalsell = $sell1 + $sell2 + $sell3 + $sell4 + $sell5;
    $d = date("H:i:s");
    if ($totalbuy > $totalsell) {
        echo "\033[92m $d| $last | $totalbuy | $totalsell|buy\n";
    } else {
        echo "\033[91m $d| $last | $totalbuy | $totalsell|sell\n";
    }
}

for ($i = 0; $i < 999999; $i++) {
    regis();
}
