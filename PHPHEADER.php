<?php
error_reporting(0);
$http_response_header=null;
function get_contents() {
  file_get_contents("http://localhost/service_iain/api2/user?id=adit");
  var_dump($http_response_header[0]);
}
get_contents();
//var_dump($http_response_header);
?>