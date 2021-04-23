<?php
session_start();
require 'admin/config.php';
$meSql = "SELECT * FROM food where foodtype_id='4'";
$meQuery = $db->query($meSql);
?>
<hr>
<h3 align="center"><b>หมวดหมู่ของหวาน</b></h3>
<hr>
<div class="product-cart">
<h4 class="page-banner-sm">รายการ</h4>
    <div class="wrapper">
        <div class="product-collection">
            <?php
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){
            ?>
            <div class="product-item">
                <form action="?page=dessert_session" method="post" class="myForm">
                <input type="hidden" name="food_name" value="<?=$row["food_name"]?>">
                <!-- <input type="hidden" name="food_price" value="<?=$row["food_price"]?>"> -->
                    <div class="product-product">
                    <?php 
                $image=$row["food_img"];
                if ($image=="") {?>
                    <a class="fancybox img-thumbnail" title="<?=$row['food_name'];?>" rel="ligthbox" href="admin/img/food.jpg">
                        <img class="img-responsive" alt="<?=$row['food_name'];?>" src="admin/img/food.jpg"/>
                    </a>
                <?php } else{ ?>
                    <a class="fancybox img-thumbnail" title="<?=$row['food_name'];?>" rel="ligthbox" href="admin/img/<?=$row['food_img'];?>">
                        <img class="img-responsive" alt="<?=$row['food_name'];?>" src="admin/img/<?=$row["food_img"]?>"/>
                    </a>
                <?php } ?>
                        <div class="product-product-info">
                            <input type="hidden" name="food_id" value="<?php echo $row["food_id"];?>">
                            <input type="hidden" name="foodtype_id" value="<?php echo $row["foodtype_id"];?>">
                            <p class="product-product-name"><?php echo $row["food_name"];?></p>
                            <p class="product-price-sm">ราคา <?php echo $row["food_price"];?> บาท</p>
                            <input type="hidden" name="food_price" value="<?php echo $row["food_price"];?>">
                            <small>x 1</small>
                        </div>
                    </div>
                    <div class="product-controls-sm">
                        <div class="product-quantity-controls-sm">
                            <button type="button" class="dec button">-</button>
                                <input type="number" name="food_unit" value="1" min="1" max="99" id="message"> 
                            <button type="button" class="inc button">+</button> 
                        </div> 
                        <button class="btn btn-primary" type="submit" style="margin-left: 10px;">เพิ่มรายการ</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script> 
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
            // bind 'myForm' and provide a simple callback function 
            $('.myForm').ajaxForm(function() { 
                //alert("Thank you for your comment!"); 
                $.ajax({
                       type : "POST",
					   url: "session.php",
					   /* data: $("").serialize(), */
                       data : {},
					   success: function(result) {
							//alert(result.message); 
                            /* if(result.status == 1) // Success
							{
								alert(result.message1); 
							}
							else if(result.status == 2) // Err
							{
								alert(result.message2);
							}else if(result.status == 3)
							{
								alert(result.message3);
							}else{
                                alert("---"); 
                            } */
					   }
					 });
            }); 
        }); 
</script>
