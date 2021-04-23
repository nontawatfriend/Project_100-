
<?php
session_start();
foreach( $_POST["session_id"] as $stuff ) { //บรรทัดของ session
$_SESSION["strfoodunit"][$stuff]=$_POST['unit_food_'.$stuff];
//$_SESSION["strfoodunit"][$stuff]=$_POST['unit_food_mobile_'.$stuff];
}
/* $message = "อัพเดทรายการแล้ว";
echo "<script type='text/javascript'>alert('$message');</script>"; */
echo '<meta http-equiv="refresh"content="0;url=?page=order_confirm">';
?>
