<?php
require 'vendor/autoload.php';

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$namespace = str_replace('client.php','server.php', $namespace);
$client = new nusoap_client($namespace);

$response = $client->call('selamatdatang_msg', array(
    'nama' => 'Byqo'
));
echo $response;

echo '<br>';

$response = $client->call('get_info_promo', array(
    'tipe_menu' => 'makanan',
    'hari' => 'senin'
));
echo $response;

echo '<br>';

$response = $client->call('hitung_diskon', array(
    'diskon' => 0.1,
    'harga_menu' => 40000
));
echo $response;

echo '<br>';

$response = $client->call('recommended_menu', array(
    'dessert' => "es krim"
));
echo $response;