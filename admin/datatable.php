<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] =="" || $_SESSION["password"] =="" and !isset($_COOKIE["yourusername"]) || $_COOKIE["yourusername"] =="" || $_COOKIE["yourpassword"] ==""){
	echo'<meta http-equiv="refresh" content="0;url=login.php">';
	exit(0);
} ?>
<script src="js/bootstrap.min.js"></script> <!-- modal -->
<style>
th{
    color: #fff;
    text-align: center;
}
td{
    font-size: 18px;
}
</style>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>รายละเอียด</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">ปิด</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<div class="title">ข้อมูลโต๊ะอาหาร</div>
<div class="table-responsive"><br>
<table class="Datatable table table-hover table-bordered" id="example" width="100%">
    <thead style="background-color: #35475e">
    <tr>
        <th><h4>แก้ไข</h4></th>
        <th><h4>QR Code</h4></th>
        <th><h4>หมายเลขโต๊ะ</h4></th>
<!--         <th><h4>สถานะ</h4></th> -->
        <th><h4>สถานะ</h4></th>
        <th><h4>ลิ้งโต๊ะ</h4></th>
        <!-- <th><h4>แก้ไข</h4></th> -->
    </tr>
    </thead>
    <tbody align="center">
        <?php
        $sql="select * from tables inner join tables_status on (tables.tables_status=tables_status.tablestatus_id)";
		$result=$db->query($sql);
		while($row=$result->fetch_array(MYSQLI_BOTH)){
	    ?>
        <tr>
            <!-- <td><?=$row["tables_id"]?></td> -->
            <td>
            <a href="?page=datatable_edit&table_id=<?=$row["tables_id"];?>" type="submit" class="btn btn-warning" id="change" title="แก้ไข"> <i class="fa fa-pencil-square-o"></i></a>
            <!-- <button onclick="" class="btn btn-danger" id="remove" title="ลบ"> <i class="fa fa-trash"></i></button> -->
            </td>
            <td>
            <a class="fancybox img-thumbnail" title="<?=$row['tables_images'];?>" rel="ligthbox" href="table_img/<?=$row["tables_images"]?>" class="img-thumbnail">
                <!-- <img class="img-responsive" alt="<?=$row['tables_images'];?>" src="table_img/<?=$row["tables_images"]?>" class="img-thumbnail" height="75"width="75" /> -->
                <button class="btn btn-primary">View QR Code</button>
            </a>
            </td>
            <td><?=$row["tables_number"]?></td>
<!--             <?php
            if($row["tablestatus_id"] == "1"){
            echo "<td><span style='color:green'>$row[tablestatus_name]</span></td>";
            }else if($row["tablestatus_id"] == "2"){
            echo "<td><span style='color:red'>$row[tablestatus_name]</span></td>";
            }else{
            echo "<td><span style='color:red'>ข้อมูลไม่แน่ชัด</span></td>";
            }
            ?> -->
            <td>
            <?php
				if($row["tables_status"]=='1'){
					echo "<a href='?page=datatable_status&tables_id=$row[tables_id]&tables_status=$row[tables_status]'><button type='button' class='btn btn-success'>$row[tablestatus_name]</button></a>";		
				}
				else if($row["tables_status"]=='2'){
					echo "<a href='?page=datatable_status&tables_id=$row[tables_id]&tables_status=$row[tables_status]'><button type='button' class='btn btn-danger'>$row[tablestatus_name]</button></a>";
				}else{
                    echo "<a href='#'><button type='button' class='btn btn-danger'>$row[tablestatus_name]</button></a>";
                }
			
				?>
            </td>
            <td>
                <button data-id=<?php echo $row["tables_id"]; ?> class='btn btn-primary userinfo'>ดูลิ้ง</button>
                <!-- <a href="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=" target="_blank">เว็บแปลง QR CODE</a> -->
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<script>
$(document).ready(function(){
$('.userinfo').click(function(){
  var userid = $(this).data('id');
  // AJAX request
  $.ajax({
   url: 'datatable_ajax.php',
   type: 'post',
   data: {userid: userid},
   success: function(response){ 
     // Add response in Modal body
     $('.modal-body').html(response);

     // Display Modal
     $('#exampleModal').modal('show'); 
   }
 });
});
});
</script>
<script>
	$(document).ready(function() {
    //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
		$('#example').DataTable( {
			"order": [[ 0, "desc" ]], //ให้เรียงจากมากไปน้อย
			"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "ทั้งหมด"]],
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