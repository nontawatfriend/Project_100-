<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] =="" || $_SESSION["password"] =="" and !isset($_COOKIE["yourusername"]) || $_COOKIE["yourusername"] =="" || $_COOKIE["yourpassword"] ==""){
	echo'<meta http-equiv="refresh" content="0;url=login.php">';
	exit(0);
} ?>
<?php $pricecategory_id = $_REQUEST["price_category_id"]; 
?> <!-- รับไอดีแล้วแปลงไอดี -->
 
<div class="title"><i class="fa fa-plus-circle" aria-hidden="true"></i> แก้ไขประเภทราคา</div><br>
<form id="frm" method="post" class="form-horizontal" action="?page=price_category_update" name="frm">
<input type="hidden" name="price_category_id" value="<?php echo $pricecategory_id; ?>" />
     <?php 
		$sql="select * from price_category where pricecategory_id=$pricecategory_id";
		$result=$db->query($sql);
		while($row=$result->fetch_array(MYSQLI_BOTH)){
	    ?>
    <div class="form-group">
		<label class="col-sm-5 control-label"><?=$row["pricecategory_name"]?>:</label>
		<div class="col-sm-3 price_category">
		    <input type="number" class="form-control"  name="price_category" id="price_category" required="required" onBlur="chkprice_category();" value="<?=$row["pricecategory_price"]?>"></input>
        </div>
        <?php } ?>
       
    </div>
		<div class="form-group" align="center">
            <button class="btn btn-primary" type="button" style="font-size:16px" title="บันทึก" onClick="confirmdata();"name="buttontext"><i class="fa fa-save" ></i> อัพเดทราคา</button>
		</div>
  </form>
<script>
	function chkprice_category(){
		if(document.getElementById('price_category').value == "")
		{
			$('#frm .price_category').addClass('has-error');
			$('#frm .price_category').removeClass('has-success');
			return false;
    	}else{
			$('#frm .price_category').addClass('has-success');
			$('#frm .price_category').removeClass('has-error');
		}
	}

	function confirmdata(){
	if(document.getElementById('price_category').value == "")
    {
        chkprice_category();
		$('#price_category').focus();
		return false;
    }
		document.getElementById("frm").submit();
		$("#buttontext").html("ระบบกำลังทำการโปรดรอสักครู่.....");
		document.getElementById("buttontext").disabled = true;
		return true;
	}
</script>
