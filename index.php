<?php include("admin/config.php");
if($_GET["id_table"]!=""){ //มีหมายเลขโต๊ะ
  session_start ();  
  $_SESSION["id_table"]=base64_decode($_GET["id_table"]); //รับเข้ารหัสมาแปลงเป็นตัวเลขเป็นปกติ
  unset($_SESSION["timeLasetdActive"]);//มีหมายเลขโต๊ะมาให้เริ่มนับเวลา session ใหม่
  echo '<meta http-equiv="refresh"content="0;url=?page=noodle">'; //รับไอดีโต๊ะแล้วให้มันกลับไปหน้า index
}else
session_start ();
    $sessionlifetime = 900; //กำหนดเป็นวินาที 900 วิ เท่ากับ 15นาที
    if(isset($_SESSION["timeLasetdActive"])){
      $seclogin = (time()-(int)$_SESSION["timeLasetdActive"]);
        if($seclogin>$sessionlifetime){
          unset($_SESSION["id_table"]);
        }else{
          $_SESSION["timeLasetdActive"] = time();
        }
    }else{
          $_SESSION["timeLasetdActive"] = time();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>order</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <?php 
			$sqlimg="SELECT * from restaurant";
			$resultimg=$db->query($sqlimg);
			while($rowimg=$resultimg->fetch_array(MYSQLI_ASSOC)){
			?>
		<link rel="icon" href="admin/img/<?=$rowimg["restaurant_img"]?>">
			<?php }?>
    <link rel="stylesheet" href="fonts/Mali.css">
    <link rel="stylesheet" href="fonts/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <script src="js/sweetalert2@10.js"></script> <!--sweetalert2@10-->
    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="js/main.js"></script>
    <!-- สไลด์ดูภาพอุปกรณ์ -->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css" media="screen">
    <script src="js/jquery.fancybox.min.js"></script>
    <!-- ที่สไลค์หมวดหมู่ -->
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!-- js เวลาส่ง form ไปไม่ลิ้งไปหน้าถัดให้มัน ส่งแบบ ajax -->
    <script src="js/jquery.form.js"></script> 

    <script>
    $( function() {
        $( "#tabs" ).tabs();
    } );
  </script>
</head>
<body>
<?php
$sqltable="SELECT tables_number,tables_status FROM tables where tables_number='".$_SESSION["id_table"]."' and tables_status=1"; //ตรวจสอบหมายเลขโต๊ะอาหารว่ามีในฐานข้อมูลไหม
$resulttable=$db->query($sqltable);
$rowtable=$resulttable->fetch_array(MYSQLI_ASSOC);
$rowtableid=$rowtable["tables_number"];

if($rowtableid == $_SESSION["id_table"]){
  if($_SESSION["id_table"]==""){
    echo "<div class=\"alert alert-warning\" align=\"center\">หมดอายุการใช้งานกรุณาสแกน QR Code ใหม่อีกครั้ง</div>";
  }else{
  ?>
  <div class="header_id">
  <!--     <div class="logo">
          <a href="index.php"><i class="fa fa-tachometer"></i> Admin</a>
      </div>
      <a href="#" class="nav-trigger"><span></span></a> -->
      <div class="namesid">โต๊ะ <?php echo $_SESSION["id_table"]; ?></div>
  </div>
  <div class="header_name">
      <?php 
          $sql="SELECT * FROM restaurant";
          $result=$db->query($sql);
          while($row=$result->fetch_array(MYSQLI_ASSOC)){
      ?>
      <div class="namestore"><?=$row["restaurant_name"]?> ยินดีต้อนรับ 🙏</div>
      <?php 
      }
    ?>
  </div>
      <div class="main-content">    
          <div id="">
              <div class="draggable-container"> <!--draggable-container กรอบเมนู-->
                  <ul class="nav nav-tabs draggable" ><!-- style="width: 677px;" -->
                  <?php 
                      $sql="SELECT * from food_type where foodtype_status=1"; 
                      /* inner join foodtype_status on food_type.foodtype_status=foodtype_status.foodtypestatus_id */
                      $result=$db->query($sql);
                      while($row=$result->fetch_array(MYSQLI_ASSOC)){
                  ?>
                      <!-- <li role="presentation" class="active">
                          <a href="#<?php echo $row["foodtype_id"] ?>" aria-controls="<?php echo $row["foodtype_name"] ?>" role="tab" data-toggle="tab"><?php echo $row["foodtype_name"] ?>
                          </a>
                      </li> -->
                    <!-- <?php if($_GET['page']=="index") echo 'class="active"'?> -->
                    <?php 
                      if($row["foodtype_status"]=="1"){
                        if($row["foodtype_id"]=="1"){ ?>
                        <!-- <?php if(!$_GET) $_GET['page']="recommended_menu"?> -->
                          <li <?php if ($_GET['page']=="recommended_menu") echo 'class="active"' ?>>
                              <a href="index.php?page=recommended_menu"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                        <?php } 
                        if($row["foodtype_id"]=="2"){ ?>
                          <li <?php if($_GET['page']=="popular_menu") echo 'class="active"'?>>
                              <a href="index.php?page=popular_menu"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } 
                          if($row["foodtype_id"]=="3"){ ?>
                          <li <?php if($_GET['page']=="noodle") echo 'class="active"'?>>
                              <a href="index.php?page=noodle"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } 
                          if($row["foodtype_id"]=="4"){ ?>
                          <li <?php if($_GET['page']=="dessert") echo 'class="active"'?>>
                              <a href="index.php?page=dessert"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } 
                          if($row["foodtype_id"]=="5"){ ?>
                          <li <?php if($_GET['page']=="drink") echo 'class="active"'?>>
                              <a href="index.php?page=drink"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } 
                          if($row["foodtype_id"]=="6"){ ?>
                          <li <?php if($_GET['page']=="hell_menu") echo 'class="active"'?>>
                              <a href="index.php?page=hell_menu"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } 
                          if($row["foodtype_id"]=="7"){ ?>
                          <li <?php if($_GET['page']=="chinese_soup") echo 'class="active"'?>>
                              <a href="index.php?page=chinese_soup"><?php echo $row["foodtype_name"] ?>
                              </a>
                          </li>
                          <?php } ?>
                      <?php 
                      }
                  }
                  ?>
                  </ul>
              </div><!--ปิดกรอบเมนู-->
          </div>
          <?php
            if(@$_GET['fd'])
              $file=$_GET['fd']."/".$_GET['page'].".php";
            else
              $file=@$_GET['page'].".php";
            if(is_file($file)){
              require_once("$file");
            }
            else{
              $_SESSION["id_table"]=base64_decode($_GET["id_table"]); //แปลงและรับไอดีโต๊ะ
              //require_once("noodle.php");
            }
          ?>
      </div><!-- ปิด main-content -->
<br>
<footer class="text-center">
  <!-- Copyright -->
  <!-- href="https://www.facebook.com/praktakboatnooddletak" -->
  <div class="bg" style="background-color: rgba(0, 0, 0, 0.2); height: auto;">
      <?php 
          $sql="SELECT * FROM restaurant";
          $result=$db->query($sql);
          while($row=$result->fetch_array(MYSQLI_ASSOC)){
      ?>
      <p align="center" style="font-size:16px; padding-top: 10px; padding-bottom: 10px; font-weight: bold;"> <?php echo $row["restaurant_address"];?>
      <?php } ?>
<!--  <label for="" align="center" style="font-size:16px"> © นายนนทวัฒน์ ปัญญาเครือ</label>    
      <label for="" align="center"> นักศึกษาจาก</label><br>
      <label for="" align="center"> มหาวิทยาลัยเทคโนโลยีราชมงคลล้านนา ตาก</label><br>
      <label for="" align="center"> สาขาวิชาเทคโนโลยีสารสนเทศ คณะวิทยาศาสตร์และเทคโนโลยีการเกษตร</label> -->
      <!-- Facebook -->
      <a class="btn btn-primary" style="background-color: #3b5998;" href="https://www.facebook.com/praktakboatnooddletak" target="_blank" role="button" title="ติดต่อ facebook"><i class="fa fa-facebook" style="font-size:18px;"></i></a>
        <!-- ©2021 นายนนทวัฒน์ ปัญญาเครือ -->
      <!-- <a href="https://www.facebook.com/nontawat.friend/" target="_blank" title="ติดต่อ facebook"><i class="fa fa-facebook"></i></a> -->
      </p>
  </div>
  <!-- Copyright -->
</footer>


  <div class="cart-fixed">
    <div class="cart">
        <a href="?page=cart" class="btn btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> รายการทั้งหมด <span class="badge badge-light" id="unit"><?php echo $_SESSION["sumcart"];?></span></a>
    </div>
  </div>
  </div>
  </body>
  <script>
      $(document).ready(function(){
      //FANCYBOX เลื่อนรูป
      //https://github.com/fancyapps/fancyBox
      $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
      });
      });
    </script>
  <script>
      
  // calculate and set .draggable width

  $.fn.draggable_nav_calc = function(options) {
    return this.each( function(i) {
      var $element = $(this);
      if ($element.is(":visible")) {
        // x or y
        if (options.axis === "x") {
          // calculate
          var navWidth = 1;
          $element.find("> *").each( function(i) {
            navWidth += $(this).outerWidth(true);
          });
          // set width
          var parentWidth = $element.parent().width();
          if (navWidth > parentWidth) {
            $element.css("width", navWidth);
          } else {
            $element.css("width", parentWidth);
          }
        } else if (options.axis === "y") {
          // calculate
          var navHeight = 1;
          $element.find("> *").each( function(i) {
            navHeight += $(this).outerHeight(true);
          });
          // set height
          var parentHeight = $element.parent().width();
          if (navHeight > parentHeight) {
            $element.css("height", navHeight);
          } else {
            $element.css("height", parentHeight);
          }
        }
      }
    });
  };

  // check inside bounds

  $.fn.draggable_nav_check = function() {
    return this.each( function(i) {
      var $element = $(this);
      // calculate
      var w = $element.width();
      var pw = $element.parent().width();
      var maxPosLeft = 0;
      if (w > pw) {
        maxPosLeft = - (w - pw);
      }
      var h = $element.height();
      var ph = $element.parent().height();
      var maxPosTop = 0;
      if (h > ph) {
        maxPosTop = h - ph;
      }
      // horizontal
      var left = parseInt($element[0].style.left);
      if (left > 0) {
        $element.css("left", 0);
      } else if (left < maxPosLeft) {
        $element.css("left", maxPosLeft);
      }
      // vertical
      var top = parseInt($element[0].style.top);
      if (top > 0) {
        $element.css("top", 0);
      } else if (top < maxPosTop) {
        $element.css("top", maxPosTop);
      }
    });
  };

  // init draggable nav

  $.fn.draggable_nav = function(options) {
    return this.each( function(i) {
      var $element = $(this);
      // calculate first time, after delay to fix resize bugs
      window.setTimeout( function(e) {
        $element.draggable_nav_calc(options);
      }, 100);
      // on shown tabs recalculate
      $element.find('[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $element.draggable_nav_calc(options);
      });
      // on resize recalculate
      function draggable_nav_resize_after() {
        clearTimeout($element.data("draggable_nav_timeout"));
        var timeout = window.setTimeout( function(e) {
          $element.draggable_nav_calc(options);
          $element.draggable_nav_check();
        }, 0);
        $element.data("draggable_nav_timeout", timeout);
      }
      $(window).on('resize', draggable_nav_resize_after);
      $(window).on('scroll', draggable_nav_resize_after);
      // center clicked element
      if ($element.hasClass("draggable-center")) {
        $element.find('li a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
          var $container = $(this).parents(".draggable-container");
          var $li = $(this).parents("li");
          if (options.axis === "x") {
              var left = - $li.position().left + $container.outerWidth() / 2 - $li.outerWidth() / 2;
              $element.css("left", left);
          } else if (options.axis === "y") {
              var top = - $li.position().top + $container.outerWidth() / 2 - $li.outerWidth() / 2;
              $element.css("top", top);
          }
          // put inside bounds
          $element.draggable_nav_check();
        });
      }
    });
  };
  $(".draggable").draggable_nav({
    axis: 'x' // only horizontally
  });

  // jquery ui draggable

  $(".draggable").draggable({
    axis: 'x', // only horizontally
    drag: function(e, ui) {
      var $element = ui.helper;
      // calculate
      var w = $element.width();
      var pw = $element.parent().width();
      var maxPosLeft = 0;
      if (w > pw) {
        maxPosLeft = - (w - pw);
      }
      var h = $element.height();
      var ph = $element.parent().height();
      var maxPosTop = 0;
      if (h > ph) {
        maxPosTop = h - ph;
      }
      // horizontal
      if (ui.position.left > 0) {
        ui.position.left = 0;
      } else if (ui.position.left < maxPosLeft) {
        ui.position.left = maxPosLeft;
      }
      // vertical
      if (ui.position.top > 0) {
        ui.position.top = 0;
      } else if (ui.position.top < maxPosTop) {
        ui.position.top = maxPosTop;
      }
    }
  });

  // jquey draggable also on touch devices
  // http://stackoverflow.com/questions/5186441/javascript-drag-and-drop-for-touch-devices

  function touchHandler(e) {
    var touch = e.originalEvent.changedTouches[0];
    var simulatedEvent = document.createEvent("MouseEvent");
      simulatedEvent.initMouseEvent({
      touchstart: "mousedown",
      touchmove: "mousemove",
      touchend: "mouseup"
    }[e.type], true, true, window, 1,
      touch.screenX, touch.screenY,
      touch.clientX, touch.clientY, false,
      false, false, false, 0, null);
    touch.target.dispatchEvent(simulatedEvent);
  }
  function preventPageScroll(e) {
      e.preventDefault();
  }
  function initTouchHandler($element) {
    $element.on("touchstart touchmove touchend touchcancel", touchHandler);
    $element.on("touchmove", preventPageScroll);
  }
  initTouchHandler($(".draggable"));
  </script>

  <!-- ปุ่มเพิ่มลบจำนวน -->
  <script>
    $(function() {
  /* $(".numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>'); */
  $(".button").on("click", function() {
    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

      if ($button.text() == "+") {
        var newVal = parseFloat(oldValue) + 1;
      } 
      else {
      // Don't allow decrementing below zero
          if (oldValue > 1) {
          var newVal = parseFloat(oldValue) - 1;
          } else {
          newVal = 1;
          }
      }

    $button.parent().find("input").val(newVal);
  });
  });
  </script>
  <!-- ปิดปุ่มเพิ่มลบจำนวน -->
  <!-- แสดงจำนวนตระกร้าแบบ ajax -->
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
                        $("span#unit").html(getData); // ส่วนที่ 3 นำข้อมูลมาแสดง
                    }
            }).responseText;
        },1500);    
    });
  </script>
    <!-- ปิดแสดงจำนวนตระกร้าแบบ ajax -->
  </html>
  <?php   
  }
}else{
  echo "<div class=\"alert alert-warning\" align=\"center\">ไม่พบสถานะโต๊ะกรุณาสแกน QR Code ใหม่อีกครั้ง</div>";
}
?>