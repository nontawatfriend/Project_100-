<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] =="" || $_SESSION["password"] =="" and !isset($_COOKIE["yourusername"]) || $_COOKIE["yourusername"] =="" || $_COOKIE["yourpassword"] ==""){
	echo'<meta http-equiv="refresh" content="0;url=login.php">';
	exit(0);
} ?>
<style>
th{
    color: #fff;
    text-align: center;
}
td{
    font-size: 18px;
    font-weight: bold;
}
.title a{
    float:right; /*ชิดขวา */
    text-decoration: none; /* underline  อันนี้คือมีขีดเส้นใต้*/
    text-align: right;
}
</style>
<div class="title">ประเภทราคา</div>
<table class="table table-hover table-bordered" id="example" width="100%">
    <thead style="background-color: #35475e">
    <tr>
        <th><h4>ชื่อประเภทราคาก๋วยเตี๋ยว</h4></th>
        <th><h4>ราคา</h4></th>
        <th><h4>แก้ไข/ลบ</h4></th>
    </tr>
    </thead>
    <tbody align="center">
    <?php 
		$sql="select * from price_category";
		$result=$db->query($sql);
		while($row=$result->fetch_array(MYSQLI_BOTH)){
	?>
        <tr>
            <td><?=$row["pricecategory_name"];?></td>
            <td><?=$row["pricecategory_price"];?></td>
            <td>
            <a href="?page=price_category_edit&price_category_id=<?=$row["pricecategory_id"];?>" title="แก้ไข"><span class="btn btn-warning" id="change"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
            <!-- <input type="hidden" name="pricecategory_id" id="pricecategory_id" value="<?php echo $row['pricecategory_id']; ?>"> -->
            </td>
        </tr>
        <?php 
			}
		?>
    </tbody>
</table>