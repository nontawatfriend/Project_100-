<?php
session_start();
require 'admin/config.php';

$meSql = "SELECT * FROM food where foodtype_id='7'";
$meQuery = $db->query($meSql);

?>
<hr>
<h3 align="center"><b>หมวดหมู่เกาเหลา</b></h3>
<hr>
<div class="product-cart">
<h4 class="page-banner-sm">รายการ</h4>
    <div class="wrapper">
        <div class="product-collection">
<!--             <div class="product-header">
                <p>Item</p>
                <p>quantity</p>
                <p>Unit price</p>
                <p>Total</p>
            </div> -->
            <?php
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){
            ?>
            <div class="product-item">
            <form action="?page=chinese_soup_session" method="post">
            <input type="hidden" name="food_name" value="<?=$row["food_name"]?>">
                    <div class="product-product">
                        <!-- <div class="product-image" style="background-image:url(admin/img/<?php echo $row["food_img"];?>)"></div> -->
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
                                <input type="number" value="1" min="1" name="food_unit">
                            <button type="button" class="inc button">+</button>  
                        </div>
                        <button class="btn btn-primary" type="submit" style="margin-left: 10px;">หยิบใส่ตะกร้า</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>