<?php
session_start();
require 'admin/config.php';
?>
<hr>
<h3 align="center"><b>หมวดหมู่ยอดนิยม</b></h3>
<hr>

<div class="product-cart">
<h4 class="page-banner-sm">ของหวาน</h4>
    <div class="wrapper">
        <div class="product-collection">
        <?php
        $sql="SELECT id.food_id from (select food_id, count(food_id) from order_list where food_typeid='4' group by food_id order by count(food_id) desc limit 1) as id";/* จำนวนแถวที่มากที่สุดคือเลขนี้ของประเภทไอดีเท่ากับ4 */
        /* $sql="SELECT * from(select food_id, count(food_id) as amount from order_list group by food_id where food_typeid='4') as lmt order by lmt.amount desc limit 1 ";  *//* จำนวนแถวที่มากที่สุดคือเลขนี้ */
       /* $sql="SELECT lmt.food_id, lmt.amount from(select food_id, count(food_id) as amount from order_list group by food_id) as lmt order by lmt.amount desc limit 1"; */ /* รวมนับว่ามีทั้งหมดกี่ตัว */
       /*  $sql="SELECT count(food_id) from order_list group by food_id order by count(food_id) desc limit 1"; */
        /* $sql="SELECT food_id from order_list order by food_id DESC"; */
        /* $sql = "SELECT MAX(food_id) MAXIMUM FROM order_list"; */
        /* $sql="SELECT food_id From order_list Order by food_id Limit 0,1"; */ /* อันนี้คือหาค่ามาก */
        /* $sql="SELECT food_id FROM order_list GROUP BY food_id HAVING count(food_id) > 1"; */ //โชว์ไอดีที่มีคนสั่งเยอะที่สุด **แสดงค่า ค่าที่มากกว่า 1 ตัว
        /* $sql="SELECT food_id,food_typeid FROM order_list WHERE food_id IN (SELECT food_id FROM order_list GROUP BY food_id HAVING count(food_id) > 1)"; */
        $food_id=$db->query($sql);
        //echo  $sql;exit(0);
        while ($rowid=$food_id->fetch_array(MYSQLI_BOTH)){
            //echo $rowid["food_id"];exit(0); //ไอดีที่มีออร์เดอร์สั่งเยอะที่สุด **เท่ากับมีจำนวนทั้งหมด**
        ?>
            <?php
                $meSql = "SELECT * FROM food INNER JOIN order_list on food.food_id=order_list.food_id where order_list.food_typeid='4' and order_list.food_id='".$rowid["food_id"]."' GROUP BY order_list.food_typeid desc";
                $meQuery = $db->query($meSql);
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){  
            ?>
            <div class="product-item">
                <form action="?page=popular_menu_session" method="post" class="myForm">
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
                        <button class="btn btn-primary" type="submit" style="margin-left: 10px;">หยิบใส่ตะกร้า</button>
                    </div>
                </form>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>
<div class="product-cart">
<h4 class="page-banner-sm">เครื่องดื่ม</h4>
    <div class="wrapper">
        <div class="product-collection">
        <?php
        $sql2="SELECT id.food_id from (select food_id, count(food_id) from order_list where food_typeid='5' group by food_id order by count(food_id) desc limit 1) as id";/* จำนวนแถวที่มากที่สุดคือเลขนี้ของประเภทไอดีเท่ากับ5 */
        $food_id2=$db->query($sql2);
        while ($rowid2=$food_id2->fetch_array(MYSQLI_BOTH)){
        ?>
            <?php
                $meSql = "SELECT * FROM food INNER JOIN order_list on food.food_id=order_list.food_id where order_list.food_typeid='5' and order_list.food_id='".$rowid2["food_id"]."' GROUP BY order_list.food_typeid desc";
                $meQuery = $db->query($meSql);
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){  
            ?>
            <div class="product-item">
                <form action="?page=popular_menu_session" method="post" class="myForm">
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
                                <input type="number" name="food_unit" value="1" min="1" max="99" id="message"> 
                            <button type="button" class="inc button">+</button> 
                        </div> 
                        <button class="btn btn-primary" type="submit" style="margin-left: 10px;">หยิบใส่ตะกร้า</button>
                    </div>
                </form>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>
<div class="product-cart">
<h4 class="page-banner-sm">เมนูนรก</h4>
    <div class="wrapper">
        <div class="product-collection">
        <?php
        $sql2="SELECT id.food_id from (select food_id, count(food_id) from order_list where food_typeid='6' group by food_id order by count(food_id) desc limit 1) as id";/* จำนวนแถวที่มากที่สุดคือเลขนี้ของประเภทไอดีเท่ากับ6 */
        $food_id2=$db->query($sql2);
        while ($rowid2=$food_id2->fetch_array(MYSQLI_BOTH)){
        ?>
            <?php
                $meSql = "SELECT * FROM food INNER JOIN order_list on food.food_id=order_list.food_id where order_list.food_typeid='6' and order_list.food_id='".$rowid2["food_id"]."' GROUP BY order_list.food_typeid desc";
                $meQuery = $db->query($meSql);
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){  
            ?>
            <div class="product-item">
                <form action="?page=popular_menu_session" method="post" class="myForm">
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
                                <input type="number" name="food_unit" value="1" min="1" max="99" id="message"> 
                            <button type="button" class="inc button">+</button> 
                        </div> 
                        <button class="btn btn-primary" type="submit" style="margin-left: 10px;">หยิบใส่ตะกร้า</button>
                    </div>
                </form>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>
<div class="product-cart">
<h4 class="page-banner-sm">เกาเหลา</h4>
    <div class="wrapper">
        <div class="product-collection">
        <?php
        $sql2="SELECT id.food_id from (select food_id, count(food_id) from order_list where food_typeid='7' group by food_id order by count(food_id) desc limit 1) as id";/* จำนวนแถวที่มากที่สุดคือเลขนี้ของประเภทไอดีเท่ากับ7 */
        $food_id2=$db->query($sql2);
        while ($rowid2=$food_id2->fetch_array(MYSQLI_BOTH)){
        ?>
            <?php
                $meSql = "SELECT * FROM food INNER JOIN order_list on food.food_id=order_list.food_id where order_list.food_typeid='7' and order_list.food_id='".$rowid2["food_id"]."' GROUP BY order_list.food_typeid desc";
                $meQuery = $db->query($meSql);
                while ($row=$meQuery->fetch_array(MYSQLI_BOTH)){  
            ?>
            <div class="product-item">
                <form action="?page=popular_menu_session" method="post" class="myForm">
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
                                    <input type="number" name="food_unit" value="1" min="1" max="99" id="message"> 
                                <button type="button" class="inc button">+</button> 
                            </div> 
                            <button class="btn btn-primary" type="submit" style="margin-left: 10px;">เพิ่มรายการ</button>
                        </div>
                </form>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>
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