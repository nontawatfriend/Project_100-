<?php
session_start();
require 'admin/config.php';
if(isset($_GET["foodID"])){
    unset($_SESSION['strfoodname'][$_GET["foodID"]]);
    unset($_SESSION["strProductID"][$_GET["foodID"]]);
    echo '<meta http-equiv="refresh"content="0;url=?page=cart&a=removed">';
}
?>
<?php
$action = isset($_GET['a']) ? $_GET['a'] : "";
    if ($action == 'removed')
    {
        echo "<div class=\"alert alert-warning\">ลบรายการเรียบร้อย</div>";
    }
?>
<style>
    .ct{
        margin-top:50%;
        }
    @media screen and (min-width: 600px) {
        .ct{
           margin-top:50%;
        }
    }@media screen and (min-width: 800px) {
        .ct{
            margin-top:10%;
        }
    }
</style>
<!-- Modal -->
<div class="modal fade ct" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" align="center"><b>ยืนยันรายการโต๊ะ <?php echo $_SESSION["id_table"]; ?></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <div class="modal-body"></div> -->
      <div class="modal-footer" style="text-align: center;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-primary" onClick="Submit();" id="buttontext"><i class="fa fa-hand-o-right" aria-hidden="true"></i> สั่งรายการอาหาร</button>
      </div>
    </div>
  </div>
</div>
<!-- ปิด Modal -->

<div class="product-cart">
    <hr>
    <h4 class="page-banner-sm" align="center"><b>รายการ (โต๊ะ <?php echo $_SESSION["id_table"]; ?>)</b></h4>
    <hr>
    <?php
    if($_SESSION["sumcart"]==0){
        echo "<div class=\"alert alert-warning\">ยังไม่มีรายการ</div>";
    }else{?>
    <div class="wrapper">
        <div class="cart-collection">
            <div class="cart-header">
                <p>รายการ</p>
                <p style="margin-right:30px;">จำนวน</p>
                <p>ราคาต่อหน่วย</p>
                <p>ราคารวม</p>
                <p>ลบรายการ</p>
            </div>
            <form action="?page=order_confirm" method="post" name="form" id="frmsave">
            
           <!--  ของหมวดหมู่ก๋วยเตี๋ยว -->
            <?php
            $total_price_noodle=0;
            $sumnoodle=0;
            for($i=0;$i<=(int)$_SESSION["intLine"];$i++){
	            if($_SESSION["strProductID"][$i] != ""){
                $total_price_noodle = $total_price_noodle + ($_SESSION["strType2"][$i]*$_SESSION["strfoodunit"][$i]); //ผลรวมราคาของหมวดหมู่ก๋วยเตี๋ยว
            ?>
            <div class="cart-item">
                    <div class="cart-product">
                      <!--   <div class="cart-image" style="background-image:url(admin/img/เตี๋ยวเรือ.jpg)"></div> -->
                        <a class="fancybox img-thumbnail" title="เตี๋ยวเรือ" rel="ligthbox" href="admin/img/เตี๋ยวเรือ.jpg">
                            <img class="img-responsive" alt="เตี๋ยวเรือ" src="admin/img/เตี๋ยวเรือ.jpg"/>
                         </a>
                        <div class="cart-product-info">
                            <p class="cart-product-name"><?php echo $_SESSION["strProductID"][$i];$teste=$_SESSION["strFlavors"][$i]; foreach ($teste as $key => $id){ echo '/'.$id;} echo ','.$_SESSION["strType"][$i].',('. "<u>"; echo $_SESSION["strType2_name"][$i]."</u>".')'; echo "<span style='color:red'>"; echo '*'.$_SESSION["strDetail"][$i]; "</span>";?></p>
                            <p class="cart-price-sm"><?php echo $_SESSION["strType2"][$i]; ?> บาท(หน่วย)</p>
                            <!-- <p class="cart-price-sm">1520</p> -->
                            <!-- <small>x 1</small> -->
                        </div>
                    </div>
                    <!-- <input type="hidden" name="session_id[]" value="<?php echo $i;?>"> -->
                     <input type="hidden" name="food_topping_[]" value="<?php $teste=$_SESSION["strFlavors"][$i];foreach ($teste as $key => $id){ echo '/'.$id;} ?>">
                        <input type="hidden" name="food_note_[]" value="<?php echo $_SESSION["strDetail"][$i] ?>">
                        <input type="hidden" name="food_price_[]" value="<?php echo $_SESSION["strType2_name"][$i] ?>">
                        <input type="hidden" name="food_id[]" value="<?php echo $_SESSION["strfoodid"][$i]; ?>">
                        <input type="hidden" name="food_water_[]" value="<?php echo $_SESSION["strType"][$i] ?>">
                        <input type="hidden" name="foodtype_id_[]" value="<?php echo $_SESSION["strtypeID"][$i] ?>">
                        <input type="hidden" name="price_[]" value="<?php echo $_SESSION["strType2"][$i] ?>">
                        <!-- <input type="hidden" name="unit_food_<?php echo $_SESSION["strfoodid"][$i];?>" min="1" value="<?php echo  $_SESSION["strfoodunit"][$i] ?>"> -->

                    <div class="cart-quantity-md">
                        <!-- จอคอม -->
                        <div class="cart-quantity-controls">
                            <button type="button" class="dec button delQty">-</button> <!-- ปุ่มลบจำนวน -->
                                <input type="number" name="unit_food_[]" min="1" value="<?php echo  $_SESSION["strfoodunit"][$i] ?>"> 
                                <!-- จำนวนรายการที่สั่ง -->
                            <button type="button" class="inc button addQty">+</button> <!-- ปิดปุ่มเพิ่มจำนวน -->
                            <!-- <input type="hidden" name="session_id[]" value="<?php echo $i;?>"> --> <!-- แถวของ session -->
                        </div>
                        <div class="remove">
                            <a class="btn btn-danger" href="?page=cart&foodID=<?php echo $i;?>" role="button"><span class="fa fa-trash"></span> ลบทิ้ง</a>
                        </div>
                        <!-- ปิดจอคอม -->
                    </div>
                    <div class="cart-unit-price">
                        <h4><?php echo $_SESSION["strType2"][$i]; ?></h4> <!-- ราคาต่อหน่วย -->
                    </div>
                    <div class="cart-product-total">
                        <h4><?php echo $_SESSION["strType2"][$i]* $_SESSION["strfoodunit"][$i] ?></h4><!-- ราคารวม = ราคาต่อหน่วย * จำนวน -->
                    </div>
                    <div class="cart-controls-sm">
                        <div class="remove">
                            <a class="btn btn-danger" href="?page=cart&foodID=<?php echo $i;?>" role="button"><span class="fa fa-trash"></span> ลบทิ้ง</a>
                        </div>
                    </div>
                
                </div>
                <?php
                $sumnoodle=$sumnoodle+$_SESSION["strfoodunit"][$i]; //จำนวนของรายการ เท่ากับ ผลรวมทั้งหมดของรายการก๋วยเตี๋ยว
                    	}
                    } 
                ?>
                <!--  ปิดของหมวดหมู่ก๋วยเตี๋ยว -->
                <!--  ของหมวดหมู่ของหวาน ฯลฯ -->
            <?php
            $total_price_food=0;
            $sumfood=0;
            for($i=0;$i<=(int)$_SESSION["intLine"];$i++){
	            if($_SESSION["strfoodname"][$i] != ""){
                $total_price_food = $total_price_food + ($_SESSION["strfoodprice"][$i] * $_SESSION["strfoodunit"][$i]); //ผลรวมราคาของหมวดหมู่อื่นๆ
                $meSql = "SELECT * FROM food WHERE food_name='".$_SESSION["strfoodname"][$i]."';";
                $meQuery = $db->query($meSql);
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH))
                {
            ?>
            <div class="cart-item">
                    <div class="cart-product">
                        <?php
                        if($row['food_img']==''){?>
                        <a class="fancybox img-thumbnail" title="food" rel="ligthbox" href="admin/img/food.jpg">
                            <img class="img-responsive" alt="food" src="admin/img/food.jpg"/>
                         </a>
                        <?php }else{
                        ?>
                    <a class="fancybox img-thumbnail" title="<?=$row['food_name'];?>" rel="ligthbox" href="admin/img/<?php echo $row['food_img']; ?>">
                        <img class="img-responsive" alt="<?=$row['food_name'];?>" src="admin/img/<?=$row["food_img"]?>"/>
                    </a>
                    <?php
                    }
                    ?>
                       <!--  <div class="cart-image" style="background-image:url(admin/img/<?php echo $row['food_img']; ?>)"></div> -->
                        <div class="cart-product-info">
                            <p class="cart-product-name"><?php echo $_SESSION["strfoodname"][$i]; ?></p>
                            <p class="cart-price-sm"><?php echo $_SESSION["strfoodprice"][$i]; ?> บาท(หน่วย)</p>
                            <!-- <small>x 1</small> -->
                            <!-- <small>รวม <?php echo $total=$_SESSION["strfoodunit"][$i]*$_SESSION["strfoodprice"][$i]; ?> บาท</small> -->
                        </div>
                    </div>

                    <!-- <input type="hidden" name="unit_food_<?php echo $_SESSION["strfoodid"][$i];?>" min="1" value="<?php echo $_SESSION["strfoodunit"][$i] ?>"> -->
                    <input type="hidden" name="food_id[]" value="<?php echo $_SESSION["strfoodid"][$i]; ?>">
                    <input type="hidden" name="foodtype_id_[]" value="<?php echo $_SESSION["strtypeID"][$i] ?>">
                    <input type="hidden" name="price_[]" value="<?php echo $_SESSION["strfoodprice"][$i]; ?>">


                    <div class="cart-quantity-md">
                        <!-- จอคอม -->  
                        <div class="cart-quantity-controls">
                            <button type="button" class="dec button delQty">-</button><!-- ปุ่มลบจำนวน -->
                                <!-- <input type="number" value="1" min="1"> -->
                                <!-- <input type="number" name="unit_food_<?php echo $i;?>" min="1" max="999" value="<?php echo $_SESSION["strfoodunit"][$i] ?>"> -->
                                 <input type="number" name="unit_food_[]" min="1" max="999" onchange="document.getElementById('total_<?php echo $i;?>').innerHTML=this.value*<?php echo $_SESSION['strfoodprice'][$i]; ?>" id="unitfood[]" value="<?php echo $_SESSION["strfoodunit"][$i] ?>">
                                <!--  จำนวนที่สั่ง -->
                            <button type="button" class="inc button addQty">+</button> <!-- ปุ่มเพิ่มจำนวน -->
                            
                            <!-- รวม <span id=total_<?php echo $i;?>> <?php echo $_SESSION["strfoodprice"][$i]*$_SESSION["strfoodunit"][$i] ?> </span> -->
                            

                        </div>
                        <!-- <input type="hidden" name="session_id[]" value="<?php echo $i;?>"> --> <!-- แถวของ session -->
                        <div class="remove">
                            <a class="btn btn-danger" href="?page=cart&foodID=<?php echo $i;?>" role="button"><span class="fa fa-trash"></span> ลบทิ้ง</a>
                        </div>
                        <!-- ปิดจอคอม --> 
                    </div>
                    <div class="cart-unit-price">
                        <h4><?php echo  $_SESSION["strfoodprice"][$i]; ?></h4><!--ราคาต่อหน่วย -->
                    </div>
                    <div class="cart-product-total">
                        <h4><?php echo  $_SESSION["strfoodprice"][$i]*$_SESSION["strfoodunit"][$i] ?></h4><!-- ราคารวม = ราคาต่อหน่วย * จำนวน -->
                    </div>
                    <div class="cart-controls-sm">
                        <div class="remove">
                            <a class="btn btn-danger" href="?page=cart&foodID=<?php echo $i;?>" role="button"><span class="fa fa-trash"></span> ลบทิ้ง</a>
                        </div>
                    </div>
                </div>
                <?php
                $sumfood=$sumfood+$_SESSION["strfoodunit"][$i]; //จำนวนของรายการ เท่ากับ ผลรวมทั้งหมดของรายการอื่นๆ
                    	}
                    } 
                }
                ?>
                <!--  ปิดของหมวดหมู่ของหวาน ฯลฯ -->
                
            
                <div class="cart-total-holder">
                    <!-- <div class="cart-total">
                        <p>ราคาทั้งหมด: </p>
                        <p><?php $total=$total_price_food+$total_price_noodle; echo ($total); ?> บาท</p> 
                    </div>  -->
                    <!-- นำราคาก๋วยเตี๋ยวกับราคาอื่นๆมาบวกเอาราคารวมทั้งหมด -->
                    <div class="cart-action-button">
                        <!-- <a href="index.php">สั่งรายการต่อ</a> -->
                        <!-- **ปิดปุ่มคำนวนออก** -->   <!-- <button class="btn btn-primary sum" id="submit" type="submit" onClick="submit();"><i class="fa fa-refresh" aria-hidden="true"></i> อัพเดทรายการอาหารใหม่</button> --><!-- fa fa-hand-o-right -->
                        <!-- Button trigger modal -->
                        <a type="button" class="btn btn-success ok" data-toggle="modal" data-target="#exampleModal">ยืนยันรายการ</a>
                    </div>
                </div>
                <!-- <input type="hidden" name="food_total" value="<?php echo $total ?>"> -->
                <input type="hidden" name="id_table" value="<?php echo $_SESSION["id_table"]; ?>">
        </form>
        </div>
    </div>
    <?php } ?>
</div>

<?php
$sumcart=$sumfood+$sumnoodle; //จำนวนของทั้งสองรายการ เท่ากับ ผลรวมทั้งหมด
$_SESSION["sumcart"]=$sumcart; //ได้จำนวนทั้งหมด
?>
<!-- <script src="js/jquery-3.6.0.js"></script>
<script src="js/jquery-migrate-3.3.2.min.js"></script> -->
<script>
function reply_click()
{
    //document.getElementById("unitfood").innerHTML="";
    //document.getElementById("total_"+i).value = "16";
   // alert("-------+++++++++");
}
    $('.delQty').click(function(){
        //var ss= Array document.getElementById("unitfood").value;
        //alert(ss);
    });
    $('.addQty').click(function(){
        
        //var session_id=document.getElementById("session_id").value;
        //alert(session_id);
    });

    
        //ส่งข้อมูลจำนวนที่อยู่ใน input กับ บรรทัด session ที่อยู่ในinput ของกากหมูนรก ไปทาง ajax
        
/*     $(document).ready(function() { 
            $('.myForm').ajaxForm(function() { 
                $.ajax({
                       type : "POST",
					   url: "updatecart.php",
                       data : {},
					   success: function(result) {
					   }
					 });
            }); 
        });  */

    function Submit(){
		document.getElementById("frmsave").submit();
		$("#buttontext").html("โปรดรอสักครู่...");
		document.getElementById("buttontext").disabled = true;
		return true;
	}
</script>


