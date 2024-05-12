<?php

$db_host = 'localhost';
$db_name = 'e-learning';
$db_charset = 'utf8';
$user_name = 'root';
$user_password = '';
$db_connection_string = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
$conn = new PDO($db_connection_string, $user_name, $user_password);

   function unique_id() {
      $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $rand = array();
      $length = strlen($str) - 1;
      for ($i = 0; $i < 20; $i++) {
          $n = mt_rand(0, $length);
          $rand[] = $str[$n];
      }
      return implode($rand);
   }
?>