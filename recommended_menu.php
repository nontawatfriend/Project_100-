<?php
session_start();
require 'admin/config.php';

$meSql = "SELECT * FROM food where food_recommend='1' ORDER BY foodtype_id DESC";
$meQuery = $db->query($meSql);
$num=mysqli_num_rows($meQuery);

?> 
<hr>
<h3 align="center"><b>หมวดหมู่เมนูแนะนำ</b></h3>
<hr>
<?php
if($num>0){?>
    <div class="product-cart">
    <h4 class="page-banner-sm">รายการ</h4>
        <div class="wrapper">
            <div class="product-collection">
                <?php
                    while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){
                ?>
                <div class="product-item">
                <form action="?page=recommended_menu_session" method="POST" class="myForm">
                <input type="hidden" name="food_name" value="<?=$row["food_name"]?>">
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
                                    <input type="number" value="1" min="1" max="99" name="food_unit">
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
    <?php 
} else{
    echo "<div class=\"alert alert-warning\" align='center'>ยังไม่มีเมนูแนะนำ</div>";
}
?>
<script> 
        $(document).ready(function() { 
            $('.myForm').ajaxForm(function() { 
                $.ajax({
                       type : "POST",
					   url: "session.php",
                       data : {},
					   success: function(result) {
					   }
					 });
            }); 
        }); 
</script>