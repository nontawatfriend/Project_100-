<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <title>Document</title>
</head>
 
<body>
 
 
<br />
<form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1">
<input type="text" name="mytext1" id="mytext1"><br>
<input type="file" name="pic_upload" id="pic_upload" />
<input type="submit" name="bt_upload" id="bt_upload" value="Submit" />
</form>
 
 
<br>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>     
<script type="text/javascript">
 
$(function(){
     
    // เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล        
    $("#myform1").on("submit",function(e){
        e.preventDefault(); // ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax
 
        // เตรียมข้อมูล form สำหรับส่ง
       var formData = $(this).serialize();
 
        // ส่งค่าแบบ POST ไปยังไฟล์ show_data.php
        $.post("show_data.php",formData,function(data){
                console.log(data);  // ทดสอบแสดงค่า  ดูผ่านหน้า console
                /*การใช้งาน console log เพื่อ debug javascript ใน chrome firefox และ ie 
                http://www.ninenik.com/content.php?arti_id=692 via @ninenik                 
*/      });
         
    });
     
     
});
</script>
</body>
</html>