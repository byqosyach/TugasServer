<?php
require 'vendor/autoload.php';
$server = new soap_server();

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$server->configureWSDL('Menu');
$server->wsdl->schemaTargetNamespace = $namespace;

function selamatdatang_msg($nama) {
    return "Selamat datang $nama!";
}

$server->register('selamatdatang_msg',
    array('nama' => 'xsd:string'),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Pesan Selamat Datang'
);

function get_info_promo($tipe_menu, $hari) {
    if ($tipe_menu == "makanan" and $hari == "senin"){
        return "Selamat anda mendapat voucher sebesar 10% untuk $hari kamu!";
    } 
    elseif ($tipe_menu == "minuman" and $hari == "sabtu"){
        return "Selamat anda mendapat voucher sebesar 10% untuk $hari kamu!";
    }
    else {
        return "Maaf tidak ada promo untuk hari ini";
    }
}

$server->register('get_info_promo',
    array(
        'tipe_menu' => 'xsd:string',
        'hari' => 'xsd:string'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Mencari informasi promo untuk client'
);

function hitung_diskon($diskon, $harga_menu){
    $harga_diskon = $harga_menu-($harga_menu*$diskon);
    return "Total kamu menjadi Rp.$harga_diskon";
}

$server->register('hitung_diskon',
    array(
        'diskon' => 'xsd:float',
        'harga_menu' => 'xsd:int'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Mencari hasil harga diskon menu'
);

function recommended_menu($dessert){
    if($dessert == 'es krim') {
        $e_recommended = join(', ', array(
            "Es Krim Vanilla", "Es Krim Cokelat", "Es Krim Stroberi"
        ));
        return "Menu recommended minggu ini: <br>$e_recommended";
    }
    elseif($dessert == 'kue'){
        $k_recommended = join(', ', array(
            "Cheesecake", "Cookies", "Rainbow Cake"
        ));
        return "Menu recommended minggu ini:: <br>$k_recommended";
    }
    else {
        return "Menu yang dimasukkan saat ini bukan termasuk recommended menu.";
    }
}

$server->register('recommended_menu',
    array('dessert' => 'xsd:string',),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Melihat menu recommended'
);

$server->service(file_get_contents("php://input"));
exit();