<?php
$baseUrl = 'http://localhost/JobHive1';
function mainUrl($url = '') {
  global $baseUrl;
  echo $baseUrl . $url;
}
?>
