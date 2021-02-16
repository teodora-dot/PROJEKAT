<?php

$url="https://date.nager.at/api/v2/PublicHolidays/2020/RS";
$curl=curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, false);
$curl_odgovor = curl_exec($curl);
curl_close($curl);
echo $curl_odgovor;

?>