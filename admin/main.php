<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] =="" || $_SESSION["password"] =="" and !isset($_COOKIE["yourusername"]) || $_COOKIE["yourusername"] =="" || $_COOKIE["yourpassword"] ==""){
	echo'<meta http-equiv="refresh" content="0;url=login.php">';
	exit(0);
} ?>
<?php
date_default_timezone_set('Asia/Bangkok');
$today=date("Y-m-d");
$today2=date("d/m/Y");

?>
<style>
	/* td{
		text-align: center;
	} */
	.widget {
	/* flex-basis: 300px; */
	flex-basis: 100%;
	flex-grow: 10;
	height: auto;
	margin: 15px;
	border-radius: 6px;
	background-color: #ffffff;
	position: relative;
}
</style>
			<div class="title">ยอดขาย</div>
			<div class="main">
				<div class="widget" style="text-align: center; flex-basis: 98%; height: 100px; padding: 0 10px 10px 10px; font-size: 1.1em">
					<div class="title-ad"> 
		            </div>
					<br>
					<b>ยอดขายวันนี้ <b id="showData2"></b> บาท (<?php echo $today2; ?>)</b>
					<br><br>
					<b>ยอดขายทั้งหมด  <b id="showData1"></b> บาท</b>
				</div>
				
				<div class="widget">
					<div class="title">ยอดขายต่อวัน</div>
					<div class="chart"><br>
						<table class="table table-hover table-bordered" id="example1" width="100%">
							<thead style="background-color: #35475e">
							<tr>
								<th>วันที่</th>
								<th>ยอดขายรวม (บาท)</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$sql="SELECT order_date,order_price,order_id, SUM(order_price) as order_price FROM orders GROUP BY order_date order by order_date DESC";
								$result=$db->query($sql);
        						while($row=$result->fetch_array(MYSQLI_BOTH)){ 
									$row["order_date"]=show_tdate($row["order_date"]);
							?>
								<tr>
									<td style="text-align: center;"><?php echo $row["order_date"];?></td>
									<td style="text-align: right;"><?php echo number_format($row["order_price"]);?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="widget">
					<div class="title">ยอดขายต่อเดือน</div>
					<div class="chart"><br>
					<table class="table table-hover table-bordered" id="example2" width="100%">
						<thead style="background-color: #35475e">
							<tr>
								<th>เดือน</th>
								<th>ยอดขายรวม (บาท)</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$sql="SELECT order_date,order_price,order_id, MONTH(order_date) as order_datemonth, YEAR(order_date) as order_dateyear , SUM(order_price) as order_price FROM orders GROUP BY order_dateyear,order_datemonth order by order_date DESC";
								$result=$db->query($sql);
        						while($row=$result->fetch_array(MYSQLI_BOTH)){
									$row["order_date"]=show_mdate($row["order_date"]);
							?>
								<tr>
									<td style="text-align: center;"><?php echo $row["order_date"]/* .$row["order_dateyear"].'-'.$row["order_datemonth"] */;?></td>
									<td style="text-align: right;"><?php echo number_format($row["order_price"]);?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="widget">
					<div class="title">ยอดขายต่อปี</div>
					<div class="chart"><br>
					<table class="table table-hover table-bordered" id="example3" width="100%">
						<thead style="background-color: #35475e">
							<tr>
								<th>ปี</th>
								<th>ยอดขายรวม (บาท)</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$sql="SELECT order_date,order_price,order_id, YEAR(order_date) as order_dateyear , SUM(order_price) as order_price FROM orders GROUP BY order_dateyear order by order_date DESC";
								$result=$db->query($sql);
        						while($row=$result->fetch_array(MYSQLI_BOTH)){
									$row["order_date"]=show_ydate($row["order_date"]);
							?>
								<tr>
									<td style="text-align: center;"><?php echo $row["order_date"]/* $row["order_dateyear"] */;?></td>
									<td style="text-align: right;"><?php echo number_format($row["order_price"]);?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
<script type="text/javascript">
$(function(){
    setInterval(function(){ // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
        // 1 วินาที่ เท่า 1000
        // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
        var getData=$.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
                url:"gdata.php",
                data:"rev=1",
                async:false,
                success:function(getData){
                    $("b#showData1").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
                }
        }).responseText;
    },1500);    
});
</script>
<script type="text/javascript">
$(function(){
    setInterval(function(){ // เขียนฟังก์ชัน javascript ให้ทำงานทุก ๆ 30 วินาที
        // 1 วินาที่ เท่า 1000
        // คำสั่งที่ต้องการให้ทำงาน ทุก ๆ 3 วินาที
        var getData=$.ajax({ // ใช้ ajax ด้วย jQuery ดึงข้อมูลจากฐานข้อมูล
                url:"gdata.php",
                data:"rev=2",
                async:false,
                success:function(getData){
                    $("b#showData2").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
                }
        }).responseText;
    },1500);    
});
</script>
<script>
	$(document).ready(function() {
    //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
		$('#example1').DataTable( {
			"bSort": false,
            /* "type": "date-th", // ชื่อ ที่เรากำหนด ใน plugin  
            "targets": -1, */   // คอลัมน์ที่เราจะใช้ นับ ซ้ายไปขวา ให้เริ่มจาก 0 นับจาก  
            // คอลัมน์ขวามาซ้าย ให้เริ่มจาก -1 ดังนี้ ค่าในที่นี้คือ -1 ก็คือคลัมน์สุดท้าย  
            // ที่รูปแบบวันที่เป็นภาษาไทย  
			/* "order": [[ 0, "desc" ]], */ //ให้เรียงจากมากไปน้อย
			"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "ทั้งหมด"]],
			"oLanguage": {
			"sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
			"sZeroRecords": "ไม่พบข้อมูล",
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
</script><script>
	$(document).ready(function() {
    //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
		$('#example2').DataTable( {
			"bSort": false,
			"order": [[ 0, "desc" ]], //ให้เรียงจากมากไปน้อย
			"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "ทั้งหมด"]],
			"oLanguage": {
			"sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
			"sZeroRecords": "ไม่พบข้อมูล",
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
<script>
	$(document).ready(function() {
    //กำหนดให้  Plug-in dataTable ทำงาน ใน ตาราง Html ที่มี id เท่ากับ example
		$('#example3').DataTable( {
			"order": [[ 0, "desc" ]], //ให้เรียงจากมากไปน้อย
			"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "ทั้งหมด"]],
			"oLanguage": {
			"sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
			"sZeroRecords": "ไม่พบข้อมูล",
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
<?php
function  show_tdate($date_in) // กำหนดชื่อของฟังชั่น show_tdate และสร้างตัวแปล $date_in ในการรับค่าที่ส่งมา
{
	$month_arr = array("มกราคม" , "กุมภาพันธ์" , "มีนาคม" , "เมษายน" , "พฤษภาคม" , "มิถุนายน" , "กรกฏาคม" , "สิงหาคม" , "กันยายน" , "ตุลาคม" ,"พฤศจิกายน" , "ธันวาคม" ) ; //กำหนด อาร์เรย์ $month_arr  เพื่อเก็บ ชื่อเดือน ของไทย
	// ใช้ฟังชั่น strtok เพื่อแยก ปี เดือน วัน
	// โดยเริ่มจาก ปีก่อน
	$tok = strtok($date_in, "-"); //สร้างตัวแปล $tok เพื่อเก็บค่าแยกของปี ออกมา
	$year = $tok ; //กำหนดค่าให้ ตัวแปล $year มีค่าเท่ากับ ปีที่ ถูกแยกออกมาจาก ตัวแปล $tok 
	//ต่อไปคือส่วนของ เดือน
	$tok  = strtok("-");// ส่วนนี้เราจะมีไว้เพื่อทำการแยกเดือน
	$month = $tok ;//สร้างตัวแปล$monthเพื่อเก็บค่าแยกของเดือน ออกมา
	//ต่อไปส่วนสุดท้ายคือ ส่วนของวันที่
	$tok = strtok("-");//ส่วนนี้เราจะมีไว้เพื่อทำการแยกเดือน
	$day = $tok ;//สร้างตัวแปล $$dayเพื่อเก็บค่าแยกของเดือน ออกมา
	//เมื่อได้ส่วนแยกของ วัน เดือน ปี มาแล้วว แต่ ปี ยังเป็นรูปแบบของ ค.ศ. ดังนั้นเราต้องแปล เป็น พ.ศ.  ก่อนด้ววิธีกรนนี้
	$year_out = $year + 543 ;// สร้างตัวแแปลขึ้นมาเพื่อเก็บค่าที่ได้จากการนำปี ค.ศ. มาบวกกับ 543  ก็จะได้ปีที่เป็น  พ.ศ. ออกมา
	$cnt = $month-1 ;// เราตัองสร้างตัวแปล มาเพื่อเก็บค่าเดือน โดยจะต้องเอาเดือนที่ได้มา ลบ 1 เพราะว่า เราจะต้องใช้ในการเทียบกับ ค่าที่อยู่ได้อาร์เรย์ เนื่องจาก อาร์เรย์จะมีค่า เริ่มจาก 0
	$month_out = $month_arr[$cnt] ;// ทำการเทียบค่าเดือนที่ได้กับเดือนที่เก็บไว้ในอาร์เรย์ แล้วเก็บลงใน ตัวแปล
	$t_date = $day." ".$month_out." ".$year_out ; //สร้างตัวแปลเก็บค่า วัน เดือน ปี ที่แปลเป็นไทยแล้ว
	return $t_date ;// ส่งค่ากลับไปยังส่วนที่ส่งมา
}
function  show_mdate($date_inn)
{
	$month_arr = array("มกราคม" , "กุมภาพันธ์" , "มีนาคม" , "เมษายน" , "พฤษภาคม" , "มิถุนายน" , "กรกฏาคม" , "สิงหาคม" , "กันยายน" , "ตุลาคม" ,"พฤศจิกายน" , "ธันวาคม" ) ;
	$tok = strtok($date_inn, "-");
	$year = $tok ;
	$tok  = strtok("-");
	$month = $tok ;
	$year_out = $year + 543 ;
	$cnt = $month-1 ;
	$month_out = $month_arr[$cnt] ;
	$m_date = $month_out." ".$year_out ;
	return $m_date ;
}
function  show_ydate($date_innn)
{
	$month_arr = array("มกราคม" , "กุมภาพันธ์" , "มีนาคม" , "เมษายน" , "พฤษภาคม" , "มิถุนายน" , "กรกฏาคม" , "สิงหาคม" , "กันยายน" , "ตุลาคม" ,"พฤศจิกายน" , "ธันวาคม" ) ;
	$tok = strtok($date_innn, "-");
	$year = $tok ;
	$tok  = strtok("-");
	$month = $tok ;
	$year_out = $year + 543 ;
	$y_date = $year_out ;
	return $y_date ;
}
?>