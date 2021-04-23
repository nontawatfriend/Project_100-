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

<div class="title">ข้อมูลอาหาร <a href="?page=foodinformation_new" class="right"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มข้อมูลอาหาร</a></div>
<div class="table-responsive">
<br>
<table class="Datatable table table-hover table-bordered" id="example" width="100%">
    <thead style="background-color: #35475e">
    <tr>
        <th><h4>เมนูแนะนำ</h4></th>
        <th><h4>ชื่อหมวดหมู่</h4></th>
        <th><h4>ชื่ออาหาร</h4></th>
        <th><h4>ราคา</h4></th>
        <th><h4>สถานะของอาหาร</h4></th>
        <th><h4>รูปภาพ</h4></th>
        <th><h4>แก้ไข/ลบ</h4></th>
    </tr>
    </thead>
    <tbody align="center">
    <?php 
		$sql="select * from food inner join food_type on food.foodtype_id=food_type.foodtype_id inner join foodflag_status on (food.food_flag=foodflag_status.foodflagstatus_id)"; // ORDER BY food_flag ASC DESC 
		$result=$db->query($sql);
		while($row=$result->fetch_array(MYSQLI_BOTH)){
	?>
        <tr>
            <td>
                <?php
                    if($row["food_recommend"]=='' && $row["foodtype_id"]!='3'){
                        echo "<a href='?page=recommend_save&food_id=$row[food_id]&food_recommend=''><i class='fa fa-star-o' style='font-size:36px;color:black;' aria-hidden='true'></i></a>";		
                    }
                    else if($row["food_recommend"]=='1' && $row["foodtype_id"]!='3'){
                        echo "<a href='?page=recommend_save&food_id=$row[food_id]&food_recommend=$row[food_recommend]'><i class='fa fa-star' style='font-size:36px;color:black;' aria-hidden='true'></i></a>";
                    }else{
                        echo "-";/* <a href='#'><button type='button' class='btn btn-danger'>$row[food_recommend]</button></a> */
                    }
                
                ?>
            </td>
            <td><?=$row["foodtype_name"]?></td>
            <td><?=$row["food_name"]?></td>
            <td><?=$row["food_price"]?></td>
            <!-- <td><?=$row["foodflagstatus_name"]?></td> -->
            <?php
            if($row["food_flag"] == "1"){
            echo "<td><span style='color:green'>$row[foodflagstatus_name]</span></td>";
            }else if($row["food_flag"] == "2"){
            echo "<td><span style='color:red'>$row[foodflagstatus_name]</span></td>";
            }else if($row["food_flag"] == "3"){
            echo "<td><span style='color:black'>$row[foodflagstatus_name]</span></td>";
            }else{
            echo "<td><span style='color:red'>ข้อมูลไม่แน่ชัด</span></td>";
            }
            ?>

            <td>
            <?php 
                $image=$row["food_img"];
                if ($image=="") {?>
                    <a class="fancybox img-thumbnail" title="<?=$row['food_name'];?>" rel="ligthbox" href="img/food.jpg">
                        <img class="img-responsive" alt="<?=$row['food_name'];?>" src="img/food.jpg" height="75"width="75" />
                    </a>
                <?php } else{ ?>
                    <a class="fancybox img-thumbnail" title="<?=$row['food_name'];?>" rel="ligthbox" href="img/<?=$row['food_img'];?>">
                    <img class="img-responsive" alt="<?=$row['food_name'];?>" src="img/<?=$row["food_img"]?>" height="75"width="75" />
                    </a>
                <?php } ?>
            </td>

            <td>
            <form name="myForm" method="POST" action="?page=foodinformation_delete">
                <a href="?page=foodinformation_edit&food_id=<?=$row["food_id"];?>" class="btn btn-warning" id="change" title="แก้ไข"> <i class="fa fa-pencil-square-o"></i></a>
                <!-- <button onclick="" class="btn btn-danger" id="remove" title="ลบ"> <i class="fa fa-trash"></i></button> -->
                <input type="hidden" name="food_id" id="food_id" value="<?php echo $row["food_id"]; ?>">
                <input type="hidden" name="food_img" id="food_img" value="<?php echo $row["food_img"]; ?>">
                <button type="submit" onclick="deleteConfirmations()" class="btn btn-danger delete_data" title="ลบ" name="<?=$row["food_id"];?>" id="remove"> <i class="fa fa-trash" aria-hidden="true"></i></button>
            </form>
            </td>
        </tr>
        <?php 
			}
		?>
    </tbody>
</table>
</div>
<script>
function deleteConfirmations(){
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
  Swal.fire({
  title: 'ยืนยัน',
  text: '',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: 'ยกเลิก',
  confirmButtonText: 'ตกลง',
}).then((result) => {
  if (result.isConfirmed) {
    form.submit();
    /* Swal.fire(
      'ลบแล้ว!',
      '',
      'success',
    ) */
  }
})
}
</script>
<script>
	$(document).ready(function() {
    //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
		$('#example').DataTable( {
			"order": [[ 1, "asc" ]], //ให้เรียงจากน้อยไปมาก
			"lengthMenu": [[50, 100, -1], [50, 100, "ทั้งหมด"]],
			"oLanguage": {
			"sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
			"sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
			"sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
			"sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
			"sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
			"sSearch": "ค้นหา :",
			"aaSorting" :[[0,'desc']],
			"oPaginate": {
			"sFirst":    "หน้าแรก",
			"sPrevious": "ก่อนหน้า",
			"sNext":     "ถัดไป",
			"sLast":     "หน้าสุดท้าย"
			},
			}
		} );
	} );
</script>