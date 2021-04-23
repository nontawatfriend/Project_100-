<?php
session_start();
require 'admin/config.php';
date_default_timezone_set('Asia/Bangkok');
$today=date("Y-m-d");
$food_statusid=1;
for($i=0;$i<count($_POST["food_id"]);$i++){
  $sum=$_POST["price_"][$i]*$_POST["unit_food_"][$i];
  $total+=$sum;
}
/* for($i=0;$i<count($_POST["food_id"]);$i++){
  $sum=$_POST["price_"][$i]*$_POST["unit_food_"][$i];
  $total+=$sum;
  echo "ประเภทอาหารที่ ".$_POST["foodtype_id_"][$i]." ไอดีอาหาร ".$_POST["food_id"][$i]." จำนวน ".$_POST["unit_food_"][$i]." ราคาต่อหน่วย ".$_POST["price_"][$i]." รวมราคา ".$sum." หมายเหตุ ".$_POST['food_note_'][$i]."  ".$_POST['food_water_'][$i]." ท็อปปิ้ง ".$_POST['food_topping_'][$i]." ".$_POST["food_price_"][$i].'<br>';
}
echo "ราคารวมทั้งหมด ".$total;
exit(0); */

if($_SESSION["id_table"]=="ทดสอบ"){ //เอาไว้ทดสอบระบบ
    //unset ตะกร้า
    unset($_SESSION["intLine"]);
    unset($_SESSION["strfoodid"]);
    unset($_SESSION["strProductID"]);
    unset($_SESSION['strFlavors']);
    unset($_SESSION["strType"]);
    unset($_SESSION["strType2"]);
    unset($_SESSION["strType2_name"]);
    unset($_SESSION["strfoodunit"]);
    unset($_SESSION["strDetail"]);
    unset( $_SESSION["strfoodname"]);
    unset( $_SESSION["strfoodprice"]);
    unset( $_SESSION["strtypeID"]);
    $_SESSION["sumcart"]=0;
    {?>
        <script type="text/javascript">
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ทดสอบระบบแล้ว',
            footer: '<b style="font-size: 18px;">'+'เหลืออีก '+ '2' +' คิว' + '<br>'+'<a href="https://docs.google.com/forms/d/e/1FAIpQLScL8vY9CRTs29i-2eMvs_AcmbD9fUecPqjX_Hb4nDKYv83SbA/viewform">ลิ้งแบบสอบถาม</a>'+'</b>',
            html:  '<b style="font-size: 16px;">'+'ยอดรวมทั้งหมด '+ <?php echo $total ?> +' บาท'+'<br>'+'<h1><a href="?page=recommended_menu" class="btn btn-primary">ตกลง</a></h1>',
            showConfirmButton: false,
          })
        </script>
    <?php }
  exit(0); //ปิดทดสอบ
}
if(!isset($_SESSION["intLine"])){?>
  <meta http-equiv="refresh" content="1;url=?page=cart"/>
  <?php
  exit(0);
}else{
//exit(0);
//echo 'สถานะเสตตัสของออร์เดอร์ '.$food_statusid.'<br>';
//for($i=0;$i<count($_POST["food_id"]);$i++){
    //echo 'ไอดีอาหาร '.'".$_POST['food_id'][$i]."'.' จำนวน '.$_POST['unit_food_'][$i].' ประเภทไอดีอาหาร '.$_POST['foodtype_id_'][$i].' ประเภทน้ำ/แห้ง-> '.$_POST['food_water_'][$i].' ชื่อประเภทราคาอาหาร '.$_POST['food_price_'][$i].' โน๊ด '.$_POST['food_note_'][$i].' ท็อปปิ้ง '.$_POST['food_topping_'][$i].'<br>';
//}
//echo 'ราคาทั้งหมด '.$total.' บาท'.'<br>';
//echo 'หมายเลขโต๊ะ '.$_POST["id_table"].'<br>';
$sqlSelect="SELECT * from orders where table_id='".$_POST["id_table"]."'  order by order_id desc";/*  */
$resultSelect=$db->query($sqlSelect);
$rowSelect=$resultSelect->fetch_array(MYSQLI_ASSOC);
$orderID=$rowSelect["order_id"];
//echo 'ไอดีออร์เดอร์'.$orderID.'<br>';
//echo 'โต๊ะ'.$rowSelect["table_id"].'<br>';
//echo 'ราคารวม'.$rowSelect["order_price"].'<br>';
$totaladd=$rowSelect["order_price"]+$total; //บวกราคาออร์เดอร์ที่เข้ามาใหม่+ฐานข้อมูล
//echo 'ราคารวม'.$totaladd.'<br>';
//echo 'ไอดีสถานะออร์เดอร์'.$rowSelect["food_statusid"].'<br>';

if($_POST["id_table"]==$rowSelect["table_id"] and $rowSelect["food_statusid"]=='1' or $rowSelect["food_statusid"]=='2' or $rowSelect["foodstatusid_dessert_drink"]=='1' or $rowSelect["foodstatusid_dessert_drink"]=='2' or $rowSelect["foodstatusid_hell"]=='1' or $rowSelect["foodstatusid_hell"]=='2'){ //ถ้าไอดีโต๊ะ...สถานะคือ 1 คือรับออร์เดอร์แล้วให้ไปเพิ่มรายการ
/*     $sql="UPDATE orders set table_id='".$_POST["id_table"]."', food_statusid='1',foodstatusid_dessert_drink='1',foodstatusid_hell='1', order_price='$totaladd' where order_id='$orderID'";
    $result=$db->query($sql); */
    for($i=0;$i<count($_POST["food_id"]);$i++){
      if($_POST['foodtype_id_'][$i]=='3' or $_POST['foodtype_id_'][$i]=='6' or $_POST['foodtype_id_'][$i]=='7'){ //ถ้าประเภทไอดีเท่ากับ หมวดเมนูก๋วยเตี๋ยว3,เมนูนรก6,เกาเหลา7 ให้อัพเดท
        $sqli="UPDATE orders set table_id='".$_POST["id_table"]."',food_statusid='1',order_price='$totaladd' where order_id='$orderID'";
        $resulti=$db->query($sqli);
      }else if($_POST['foodtype_id_'][$i]=='4'){//ถ้าประเภทไอดีเท่ากับของหวาน4 ให้อัพเดท
        $sqli="UPDATE orders set table_id='".$_POST["id_table"]."',foodstatusid_dessert_drink='1',order_price='$totaladd' where order_id='$orderID'";
        $resulti=$db->query($sqli);
      }else if($_POST['foodtype_id_'][$i]=='5'){//ถ้าประเภทไอดีเท่ากับเครื่องดื่ม5 ให้อัพเดท
        $sqli="UPDATE orders set table_id='".$_POST["id_table"]."',foodstatusid_hell='1',order_price='$totaladd' where order_id='$orderID'";
        $resulti=$db->query($sqli);
      }
        $sql="INSERT INTO order_list (order_id,food_id,order_unit,food_statusid,order_note,food_topping,food_water,price_categoryname,food_typeid) VALUES ('$orderID','".$_POST['food_id'][$i]."','".$_POST['unit_food_'][$i]."','1','".$_POST['food_note_'][$i]."','".$_POST['food_topping_'][$i]."','".$_POST['food_water_'][$i]."','".$_POST['food_price_'][$i]."','".$_POST['foodtype_id_'][$i]."')"; 
        $result=$db->query($sql);
    }
    if($result){
        //unset ตะกร้า
        unset($_SESSION["intLine"]);
        unset($_SESSION["strfoodid"]);
        unset($_SESSION["strProductID"]);
        unset($_SESSION['strFlavors']);
        unset($_SESSION["strType"]);
        unset($_SESSION["strType2"]);
        unset($_SESSION["strType2_name"]);
        unset($_SESSION["strfoodunit"]);
        unset($_SESSION["strDetail"]);
        unset( $_SESSION["strfoodname"]);
        unset( $_SESSION["strfoodprice"]);
        unset( $_SESSION["strtypeID"]);
        $_SESSION["sumcart"]=0;

        $sqlSelectq="SELECT * from orders where (food_statusid='1' OR foodstatusid_dessert_drink='1' OR foodstatusid_hell='1') and order_id<='$orderID'";
        /* ตรวจสถานะที่เท่ากับ 1 คือยังไม่ได้รับอาหาร */
        $result=$db->query($sqlSelectq);
        $recordQ=mysqli_num_rows($result);
        $Q=$recordQ-1;
        ?>
        <script type="text/javascript">
            Swal.fire({
            position: 'center',
            title: 'ออเดอร์ถูกเพิ่มแล้ว',
            icon: 'success',
            footer: '<b style="font-size: 18px;">'+'เหลืออีก '+ <?php echo $Q ?> +' คิว'+'</b>',
            html:  '<b style="font-size: 16px;">'+'ยอดรวมทั้งหมด '+ <?php echo $totaladd; ?> +' บาท'+'<br>'+'<h1><a href="?page=recommended_menu" class="btn btn-primary">ตกลง</a></h1>',
            showConfirmButton: false,
          })
        </script>
        <?php }else
        {?>
        <script type="text/javascript">
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'ไม่สำเร็จ',
            text: 'ลองใหม่ครั้ง',
          })
        </script>
        <meta http-equiv="refresh" content="2;url=?page=cart"/>
        <?php }
}else{ //เพิ่มรายการใหม่/เปิดโต๊ะใหม่เข้าไปเลย
    $sql="INSERT INTO orders (order_date,table_id,food_statusid,foodstatusid_dessert_drink,foodstatusid_hell,order_price) VALUES ('$today', '".$_POST["id_table"]."', '1', '1', '1', '".$total."')";/* ปรับเปลี่ยนมาอัพเดทราคารวมทั้งหมดในหน้านี้ $_POST["food_total" */
    $result=$db->query($sql);

    $sqlSelect="SELECT order_id from orders order by order_id desc";
    $resultSelect=$db->query($sqlSelect);
    $rowSelect=$resultSelect->fetch_array(MYSQLI_ASSOC);
    $lastID=$rowSelect["order_id"];

    for($i=0;$i<count($_POST["food_id"]);$i++){
    $sql="INSERT INTO order_list (order_id,food_id,order_unit,food_statusid,order_note,food_topping,food_water,price_categoryname,food_typeid) VALUES ('$lastID','".$_POST['food_id'][$i]."','".$_POST['unit_food_'][$i]."','1','".$_POST['food_note_'][$i]."','".$_POST['food_topping_'][$i]."','".$_POST['food_water_'][$i]."','".$_POST['food_price_'][$i]."','".$_POST['foodtype_id_'][$i]."')"; 
    $result=$db->query($sql);
    }

    if($result){
        //unset ตะกร้า
        unset($_SESSION["intLine"]);
        unset($_SESSION["strfoodid"]);
        unset($_SESSION["strProductID"]);
        unset($_SESSION['strFlavors']);
        unset($_SESSION["strType"]);
        unset($_SESSION["strType2"]);
        unset($_SESSION["strType2_name"]);
        unset($_SESSION["strfoodunit"]);
        unset($_SESSION["strDetail"]);
        unset( $_SESSION["strfoodname"]);
        unset( $_SESSION["strfoodprice"]);
        unset( $_SESSION["strtypeID"]);
        $_SESSION["sumcart"]=0;
        $sqlSelectq="SELECT * from orders where (food_statusid='1' OR foodstatusid_dessert_drink='1' OR foodstatusid_hell='1')";/* ตรวจสถานะที่เท่ากับ 1 คือยังไม่ได้รับอาหาร */
        $result=$db->query($sqlSelectq);
        $recordQ=mysqli_num_rows($result);
        $Q=$recordQ-1;
        ?>
        <script type="text/javascript">
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ออเดอร์ถูกส่งแล้ว',
            footer: '<b style="font-size: 18px;">'+'เหลืออีก '+ <?php echo $Q ?> +' คิว'+'</b>',
            html:  '<b style="font-size: 16px;">'+'ยอดรวมทั้งหมด '+ <?php echo $total ?> +' บาท'+'<br>'+'<h1><a href="?page=recommended_menu" class="btn btn-primary">ตกลง</a></h1>',
            showConfirmButton: false,
            /* showConfirmButton: true, */ //show ปุ่มให้กด
            //timer: 1500
          })
        </script>
        <?php }else
        {?>
        <script type="text/javascript">
            Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'ไม่สำเร็จ',
            text: 'ลองใหม่ครั้ง',
          })
        </script>
        <meta http-equiv="refresh" content="2;url=?page=cart"/>
        <?php }
    ?>
<?php 
} 
}
?>




