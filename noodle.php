<?php
session_start();
require 'admin/config.php';
?>
<style>
body{
    font-size: 20px;
}
h4{
    font-size: 25px;
    margin-top: 18px;
    margin-bottom: 18px;
}
input[type="checkbox"], 
input[type="radio"]{
	position: absolute;
	right: 9000px;
}
label{
    cursor: pointer; /* มีรูปมือขึ้น */
}
/*Check box*/
input[type="checkbox"] + .label-text:before{
    font-size: 18px;
	content: "\f096";
	font-family: "FontAwesome";
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1; /* ระยะห่างบรรทัด */
	-webkit-font-smoothing:antialiased;
	width: 1em;
	display: inline-block;
	margin-right: 5px;
}

input[type="checkbox"]:checked + .label-text:before{
	content: "\f14a";
	color: #8e44ad;
	animation: effect 250ms ease-in;
}

input[type="checkbox"]:disabled + .label-text{
	color: #aaa;
}

input[type="checkbox"]:disabled + .label-text:before{
	content: "\f0c8";
	color: #ccc;
}

/*Radio box*/

input[type="radio"] + .label-text:before{
    font-size: 18px;
	content: "\f10c";
	font-family: "FontAwesome";
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;
	-webkit-font-smoothing:antialiased;
	width: 1em;
	display: inline-block;
	margin-right: 5px;
}

input[type="radio"]:checked + .label-text:before{
	content: "\f192";
	color: #8e44ad;
	animation: effect 250ms ease-in;
}

input[type="radio"]:disabled + .label-text{
	color: #aaa;
}

input[type="radio"]:disabled + .label-text:before{
	content: "\f111";
	color: #ccc;
}


@keyframes effect{
	0%{transform: scale(0);}
	25%{transform: scale(1.3);}
	75%{transform: scale(1.4);}
	100%{transform: scale(1);}
}
</style>
<hr>
<h3 align="center"><b>หมวดหมู่ก๋วยเตี๋ยว</b></h3>
<hr>
<div align="center">
    <form action="?page=noodle_session" method="POST" id="formsession" class="myForm">
        <h4 style="font-weight: bold;">เส้น</h4>
            <?php 
            $sql="select * from food where foodtype_id=3 and food_flag=1 order by food_id ASC";
            $result=$db->query($sql);
            while($row=$result->fetch_array(MYSQLI_BOTH)){
            ?>
            <label class="radio-inline" style="font-weight: bold;">
                <input type="radio" name="food_id" value="<?php echo $row["food_id"];?>" checked>
                    <span class="label-text"><?=$row['food_name']?></span>
                    <span class="bath"> +0.00฿</span>
                <input type="hidden" name="foodtype_id" value="<?php echo $row["foodtype_id"];?>">
            </label>
            <?php } ?>
            <?php 
            $sql="select * from food where foodtype_id=3 and food_flag=2";
            $result=$db->query($sql);
            while($row=$result->fetch_array(MYSQLI_BOTH)){
            ?>
            <div class="radio-inline disabled">
                <label>
                    <input type="radio" name="" value="" disabled><span style="color: red; cursor: default;" disabled><?=$row['food_name']?> (หมด)</span>
                </label>
            </div>
            <?php } ?>
        <h4 style="font-weight: bold;">ท็อปปิ้ง</h4>
        <div class="">
            <?php 
            $sql="select * from food_topping where foodtopping_flag=1";
            $result=$db->query($sql);
            while($row=$result->fetch_array(MYSQLI_BOTH)){
            ?>
            <label class="checkbox-inline" style="font-weight: bold;">
                <input type="checkbox" name="foodtopping_name[]" checked value="<?=$row['foodtopping_name']?>">
                <span class="label-text"><?=$row['foodtopping_name']?></span>
                <input type="hidden" name="foodtopping_id[]" value="<?php echo $row["foodtopping_id"];?>">
                <span class="bath"> +0.00฿</span>
            </label>
            <?php } ?>
            <?php 
            $sql="select * from food_topping where foodtopping_flag=2";
            $result=$db->query($sql);
            while($row=$result->fetch_array(MYSQLI_BOTH)){
            ?>
            <div class="checkbox-inline disabled">
                <label><input type="checkbox" value="" disabled>
                <span style="color: red; cursor: default;"><?=$row['foodtopping_name']?> (หมด)</span></label>
            </div>
            <?php } ?>
        </div>
            <!-- <h1>เลือก</h1> -->
            <br>
                <label class="radio-inline" style="font-weight: bold;">
                    <input type="radio" name="food_water" value="น้ำ" checked>
                        <span class="label-text">น้ำ</span>
                        <span class="bath"> +0.00฿</span>
                </label>
                <label class="radio-inline" style="font-weight: bold;">
                    <input type="radio" name="food_water"  value="แห้ง">
                        <span class="label-text">แห้ง</span>
                        <span class="bath"> +0.00฿</span>
                </label> 
            <br>
        <div>
            <?php 
            $sql="select * from price_category";/*  order by pricecategory_id ASC */
            $result=$db->query($sql);
            while($row=$result->fetch_array(MYSQLI_BOTH)){
            ?>
                <label class="radio-inline" style="font-weight: bold;">
                    <input type="radio" name="food_price" value="<?=$row['pricecategory_price']?>" <?php if($row['pricecategory_id']=='1'){ echo "checked=checked";}  ?>>
                    <span class="label-text"><?=$row['pricecategory_name']?></span>
                    <span class="bath"> <?=$row['pricecategory_price']?> ฿</span>
                </label>
            <?php } ?>
        </div>
        <br>
        <div class="cart-quantity-md-noodle">
            <div class="cart-quantity-controls"> 
            <label style="padding-right: 10px;">จำนวน :</label>
            <button type="button" class="dec button">-</button>
                    <!-- <input type="number" value="1" min="1"> -->
                    <input type="number" name="food_unit" value="1" min="1" max="99"><!--  class="form-control" style="width: 60px;text-align: center;" -->
                <button type="button" class="inc button">+</button> 
            </div> 
        </div>
        <br>
        <div class="col-md-12">
            <label for="" class="col-md-5 col-xs-4" align="right" style="padding:0;">หมายเหตุ: </label>
            <div class="col-md-4 col-xs-7" >
                <input type="text" style="caret-color: red;" name="food_note" class="form-control" placeholder="หมายเหตุ">
            </div>
        </div>
        <br>
        <br>
        <button type="submit" class="btn btn-primary" id="buttontext" >เพิ่มรายการ</button>
    </form>
</div>
<script>
/* $(document).ready(function(){
    $('input[type="submit"]').attr('disabled','disabled');
    $('input[type="text"]').change(function(){
        if($(this).val != ''){
            $('input[type="submit"]').removeAttr('disabled');
        }
    });
}); */
    /* function Submit(){
		document.getElementById("formsession").submit();
		$("#buttontext").html("โปรดรอสักครู่...");
		document.getElementById("buttontext").disabled=true;
		return true;
	} */
</script>
<script> 
$(document).ready(function() { 
    $('.myForm').ajaxForm(function() { 
    //document.getElementById("buttontext").disabled=true;
    //$("#buttontext").html("โปรดรอสักครู่...");
        alert("เพิ่มรายการแล้ว");
        $.ajax({
            type : "POST",
            url: "noodle_session.php",
            data : {},
            success: function(result) {
                //document.getElementById("buttontext").disabled=false;
                //$("#buttontext").html("เพิ่มลงตะกร้า");
            }
        });
    }); 
}); 
/* $("#formsession").submit( function() {
    document.getElementById("buttontext").disabled=true;
    $("#buttontext").html("โปรดรอสักครู่...");
});
        $(document).ready(function() { 
            $('.myForm').ajaxForm(function() { 
                $.ajax({
                       type : "POST",
					   url: "noodle_session.php",
                       data : {},
					   success: function(result) {
                            alert("เพิ่มรายการแล้ว");
                            document.getElementById("buttontext").disabled=false;
                            $("#buttontext").html("เพิ่มลงตะกร้า");
					   }
				});
            }); 
        });  */
</script>