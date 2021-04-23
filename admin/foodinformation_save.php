<?php
$sql=("SELECT food_name from food where food_name='".$_POST["food_name"]."'");
$result=$db->query($sql);
$num=mysqli_num_rows($result);
if($num>0){
  ?>
  <script type="text/javascript">
    Swal.fire({
    position: 'Top-center',
    icon: 'error',
    title: 'กรุณาทำรายการใหม่!',
    text: "เนื่องจากมีชื่อนี้แล้ว",
    html:  "เนื่องจากมีชื่อนี้แล้ว"+'<h1><a href="?page=foodinformation_new" class="btn btn-primary">ตกลง</a></h1>',
    showConfirmButton: false,
    //timer: 20000
    })
  </script>	
<?php
exit(0);
}else{
  $food_img=$_FILES["food_img"]["tmp_name"];
  $food_img_name=$_FILES["food_img"]["name"];
  $array_lastname=explode(".",$food_img_name);//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
  $c=count($array_lastname)-1; //0 คือไม่มีรูปเข้ามา 1 คือมีรูปเข้ามา
  $lastname=strtolower($array_lastname[$c]); //แปลงนามสกุลให้ตัวพิมพ์เล็ก
  if(!$food_img){
    $food_img_name="";
  }
  else{
    if($lastname=='jpg' or $lastname=='gif' or $lastname=='png' or $lastname=='jpeg'){
    $food_img_name="food_".time().".".$lastname; //ตั้งชื่อ_ตามเวลา ป้องกันชื่อซ้ำ
    copy($food_img,"img/".$food_img_name);
    unlink($food_img);
    }
  }
  $sql="INSERT into food (food_name,foodtype_id,food_flag,food_price,food_img,food_recommend) values('".$_POST["food_name"]."','".$_POST["foodtype_id"]."','1','".$_POST["food_price"]."','$food_img_name','')";

  $result=$db->query($sql);
  if($result){
  ?>
  <script type="text/javascript">
      Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'บันทึกข้อมูลเรียบร้อย',
      showConfirmButton: false, //show ปุ่มให้กด
      timer: 1500
    })
  </script>
  <meta http-equiv="refresh" content="1;url=?page=foodinformation_new"/>
  <?php 
  exit(0);
  }else
    {?>
    <script type="text/javascript">
        Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'ไม่สำเร็จ',
        text: 'ลองใหม่ครั้ง',
      })
    </script>
    <meta http-equiv="refresh" content="2;url=?page=foodinformation_new"/>
    <?php
    exit(0);
    }
}
?>

