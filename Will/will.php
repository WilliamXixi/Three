<?php


echo @color("green","                   

YansWill Record Script

\t┆┈┈┈┈┈┈┈┈┈┈┈┆
         By-YansWill
\t┆┈┈┈┈┈┈┈┈┈┈┈┆
Isi Pulsa Dulu Ya Kak Sebelum Pakai Tools Ini\n
SC GRATIS!!!!! \nJangan Diperjual Belikan !!!\n
Kalau Gagal Coba Lagi Aja mungkin ada gangguan\n");

echo @color('red',"Note: Jika status sukses tetapi pulsa tidak terpotong brati gangguan ya! \n\n");

echo @color('green', "\tNOMERMU KAK(089xxxxnx.com)\n\t: ");
$nomor = trim(fgets(STDIN));
$login = login($nomor);
echo @color('yellow', $login['message']."\n");
echo @color('green', "\tOTP BOS\n\t: ");
$otp = trim(fgets(STDIN));
$login = otplogin($nomor,$otp);
if (strpos(json_encode($login), '"status":true')) {
	$secret = $login['secretKey'];
	$plan = $login['callPlan'];
    $nomor = $login['msisdn'];
    $profil = profil($nomor,$plan,$secret);
    $balance = $profil['creditBalance'];
    $aktif = $profil['activeUntil'];
    $sisakuota = $profil['sumOfInternet'];
    $poin = $profil['stotalPoin'];

	echo @color('blue', "\tIni Pulsa Mu\n\t: ");
	echo @color('green', "$balance\n");
	echo @color('blue', "\tMASA AKTIFMU Kak\n\t: ");
	echo @color('green', "$aktif\n");
    echo @color('blue', "\tPAKETAN MU\n\t: ");
    echo @color('green', "$sisakuota\n");
    echo @color('blue', "\tPOINMU SAYANG\n\t: ");
    echo @color('green', "$poin Poin\n\n\n");
    cek:
    echo @color('red', "Ketik Angka Untuk Memilih:\n\n");
    echo @color("yellow","
    ╔ [1] Reward 5GB 1hari Harga 1Perak :v
    ╠ [2] 25GB 30hari Harga 25.000
    ╠ [3] 55GB 30 Hari Harga 50.000
    ╠ [4] 65GB 30 Hari Harga 60.000
    ╠ [5] 75GB 30 Hari Harga 75.000
    ╠ [6] 90GB 30 Hari Harga 90.000
    ╠ [7] 100GB 30 Hari Harga 90.000
    ╠ [8] 9GB 7 Hari Harga 15.000
    ╚ Segitu Dulu Aja Gw males Nambahin\n\n");
    echo @color('green', "Jadi Pilih Yang Mana :v : ");
    $pilih = trim(fgets(STDIN));
    switch ($pilih) {
            case '1':
            $prodid = '25669';
            break;
            case '2':
            $prodid = '22648';
            break;
            case '3':
            $prodid = '25469';
            break;
            case '4':
            $prodid = '25690';
            break;
            case '5':
            $prodid = '25247';
            break;
            case '6':
            $prodid = '25476';
            break;
            case '7':
            $prodid = '25693';
            break;
            case '8':
            $prodid = '25553';
            break;
        
        default:
            echo @color('red', "Pilih Mau Paket Yang Mana\n\n\n");
            goto cek;
            break;
    }
    $cek = cek($prodid);
    $name = $cek['product']['productName'];
    $price = $cek['product']['productPrice'];
    $deskripsi = $cek['product']['productDescription'];
    echo @color('yellow', "JENENG PAKETMU\t: ");
    echo @color('nevy', "$name\n");
    echo @color('yellow', "REGANE\t\t: ");
    echo @color('nevy', "$price\n");
    echo @color('yellow', "DESKRIPSINE\t: ");
    echo @color('nevy', "$deskripsi\n\n\n");
    echo @color('purple', "LANJUT ORA SAYANG? (y/n) :");
    $aa = trim(fgets(STDIN));
    if(strtolower($aa) !== 'y') {
        goto cek;
    }
    $beli = beli($nomor,$plan,$secret,$prodid);
    if ($beli['status'] == true) {
        echo @color('green', "SUKSES SAYANG\n");
    } else {
        echo @color('red', "GAGAL DHEK ...!!! \n");
    }


} else {
    echo @color('red', $login['message']."\n");
    
}

function login($nomor){
	$host = "bimaplus.tri.co.id";        
    $data = '{"imei":"Android 93488a982824b403","language":1,"msisdn":"'.$nomor.'"}';
    $ceknom = rekuest($host,"POST",'/api/v1/login/otp-request', $data);
        return $ceknom;
}
function otplogin($nomor,$otp){
	$host = "bimaplus.tri.co.id";        
    $data = '{"deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","msisdn":"'.$nomor.'","otp":"'.$otp.'"}';
    $ceknom = rekuest($host,"POST",'/api/v1/login/login-with-otp', $data);
        return $ceknom;
}
function profil($nomor,$plan,$secret){
    $host = "bimaplus.tri.co.id";        
    $data = '{"callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"msisdn":"'.$nomor.'","page":1,"secretKey":"'.$secret.'","subscriberType":"Prepaid"}';
    $ceknom = rekuest($host,"POST",'/api/v1/homescreen/profile', $data);
        return $ceknom;
}

function cek($prodid){
	$host = "my.tri.co.id";        
    $data = '{"imei":"WebSelfcare","language":"","callPlan":"","msisdn":"","secretKey":"","subscriberType":"","productId":"'.$prodid.'"}';
    $ceknom = rekuest($host,"POST",'/apibima/product/product-detail', $data);
        return $ceknom;
}

function beli($nomor,$plan,$secret,$prodid){
    $host = "bimaplus.tri.co.id";        
    $data = '{"addonMenuCategory":"","addonMenuSubCategory":"","balance":"","callPlan":"'.$plan.'","deviceManufactur":"Samsung","deviceModel":"SMG991B","deviceOs":"Android","imei":"Android 93488a982824b403","language":0,"menuCategory":"3","menuCategoryName":"TriProduct","menuIdSource":"","menuSubCategory":"","menuSubCategoryName":"","msisdn":"'.$nomor.'","paymentMethod":"00","productAddOnId":"","productId":"'.$prodid.'","secretKey":"'.$secret.'","servicePlan":"Default","sms":true,"subscriberType":"Prepaid","totalProductPrice":"","utm":"","utmCampaign":"","utmContent":"","utmMedium":"","utmSource":"","utmTerm":"","vendorId":"11"}';
    $ceknom = rekuest($host,"POST",'/api/v1/purchase/purchase-product', $data);
        return $ceknom;
}

function rekuest($host, $method, $url, $data = null){ 
        $headers[] = 'Host: '.$host;
		$headers[] = 'App-Version: 4.2.6';
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $headers[] = 'User-Agent: okhttp/4.9.0';
        
        $c = curl_init("https://".$host.$url);  
        switch ($method){
            case "GET":
            curl_setopt($c, CURLOPT_POST, false);
            break;
            case "POST":               
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
            break;
            case "PUT":               
            curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
            break;
        }
        
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($c, CURLOPT_TIMEOUT, 20);
        $response = curl_exec($c);
        $httpcode = curl_getinfo($c);
        if (!$httpcode){
            return false;
        }
        else {
            $headers = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
            $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        }
        
        curl_close($c);
        $json = json_decode($body, true);
        return $json;
    }


function color($color = "default" , $text = "")
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
