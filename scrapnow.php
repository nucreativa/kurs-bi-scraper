<?php
/**
 * Created by PhpStorm.
 * User: Ary Wibowo (nucreativa@gmail.com)
 * Date: 1/22/16
 * Time: 8:17 PM
 */

// PHP Configurations
ini_set("auto_detect_line_endings", true);
date_default_timezone_set('Asia/Jakarta');

include_once 'vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

$selector = 'table.table1 td';
$client = new \Goutte\Client();
$crawler = $client->request('GET', 'http://www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx');
$i = 0;
$csv = '';
$crawler->filter($selector)->each(function ($node) {
    global $i, $csv;
    if (($i % 2) == 0) {
        $csv .= trim($node->text());
    }
    if (($i % 2) == 1) {
        $csv .= ', ' . trim(str_replace(",","",$node->text())) . "\n";
    }
    $i++;
});

file_put_contents('kurs.csv', $csv);
echo $csv;