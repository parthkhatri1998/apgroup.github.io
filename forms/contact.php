<?php
require_once ('send_mail.php');
require_once('db.class.php');
$db = new Database();
$post = $_POST;
$res = $db->Insert($post,'contact_us');
if($res){
//function for mail to customer
  send_mail();
  echo "OK";
  exit();
}
else{
  echo "sorry";
}
?>
