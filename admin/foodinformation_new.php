<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] =="" || $_SESSION["password"] =="" and !isset($_COOKIE["yourusername"]) || $_COOKIE["yourusername"] =="" || $_COOKIE["yourpassword"] ==""){
	echo'<meta http-equiv="refresh" content="0;url=login.php">';
	exit(0);
} ?>
<style>
/* .input-group-btn{
	z-index: 2048;
} */
.main-content {
    padding: 40px;
    margin-top: 0;
    padding: 0;
    padding-top: 44px;
    height: 100%;
    overflow: visible;
}

.image-preview-input {
    position: relative;
    overflow: hidden;
    margin: 0px;
    color: #333;
    background-color: #fff;
}

.image-preview-input input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

.image-preview-input-title {
    margin-left: 2px;
}
</style>
<script src="js/bootstrap.min.img.js"></script>
<!--     <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
<script type="text/javascript">
window.alert = function() {};
var defaultCSS = document.getElementById('bootstrap-css');

function changeCSS(css) {
    if (css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="' + css +
        '" type="text/css" />');
    else $('head > link').filter(':first').replaceWith(defaultCSS);
}
$(document).ready(function() {
    var iframe_height = parseInt($('html').height());
    window.parent.postMessage(iframe_height, 'https://bootsnipp.com');
});
</script>
<div class="title"><i class="fa fa-plus-circle" aria-hidden="true"></i> เพิ่มข้อมูลอาหาร</div><br>
<div class="row">
    <form id="frm" method="post" class="form-horizontal" action="?page=foodinformation_save"
        enctype="multipart/form-data" accept-charset="UTF-8">
        <div class="form-group">
            <label class="col-sm-5 control-label">ชื่อข้อมูลอาหาร</label>
            <div class="col-sm-3 food_name">
                <input type="text" class="form-control" name="food_name" id="food_name" required="required"
                    onBlur="chkfood_name();" value="<?=$row["restaurant_name"]?>"></input>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">หมวดหมู่อาหาร</label>
            <div class="col-sm-3 foodtype_id">
                <select class="form-control" name="foodtype_id" id="foodtype_id" onBlur="chkfoodtype_id();">
                    <option value="">--- เลือกหมวดหมู่อาหาร ---</option>
                    <?php
				$sql="SELECT * from food_type where foodtype_id!=1 and foodtype_id!=2";
				$result=$db->query($sql);
				while($row=$result->fetch_array(MYSQLI_ASSOC)){
				?>
                    <option value="<?=$row['foodtype_id']?>"><?=$row['foodtype_name']?></option>
                    <?php
        		}
				?>
                    <input type="hidden" name="<?=$row['foodtype_id']?>" value="<?=$row['foodtype_id']?>" />
                </select>
            </div>
        </div>
        <div class="form-group price" style="display:none">
            <label class="col-sm-5 control-label">ราคาอาหาร</label><!-- <span class="required" style="color:red;">*
                หมวดหมู่ก๋วยเตี๋ยวไม่ต้องใส่ราคา หรือ ใส่เครื่องหมาย -</span> -->
            <div class="col-sm-1 food_price">
                <input type="text" class="form-control" OnKeyPress="return chkNumber(this)" name="food_price"
                    id="food_price" required="required" onBlur="chkfood_price();"
                    value="<?=$row["food_price"]?>">
				</input>
            </div>
        </div>






        <!-- --------------------เริ่มพรีวิวเลือกรูป ------------------ -->
        <div class="form-group">
            <label class="col-sm-5 control-label">เลือกรูป</label>
            <div class="col-sm-3">
                <div class="input-group image-preview">
                    <!-- <div class="input-group image-preview">เดิม -->
                    <input type="text" class="form-control image-preview-filename" disabled="disabled">
                    <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                            <span class="glyphicon glyphicon-remove"></span> Clear
                        </button>
                        <!-- image-preview-input -->
                        <div class="btn btn-default image-preview-input">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            <span class="image-preview-input-title">Browse</span>
                            <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" name="food_img"
                                id="food_img" /> <!-- rename it ตรงname เอา input-file-preview ออก -->
                        </div>
                    </span>
                </div><!-- /input-group image-preview [TO HERE]-->
            </div>
        </div>
        <!-- --------------------จบพรีวิวเลือกรูป ------------------ -->
        <div class="form-group" align="center">
            <button class="btn btn-primary" type="button" style="font-size:16px" title="บันทึก"
                onClick="confirmdata();"><i class="fa fa-save"></i> บันทึกข้อมูลอาหาร</button>
        </div>
    </form>
</div>

<script>
$(function() {
  $('#foodtype_id').change(function(){
    $('.price').hide();
    $('#' + $(this).val()).show();
    if($(this).val() != '3') { //ถ้าไม่ใช่ก๋วยเตี๋ยวให้แสดงใส่ราคาได้
      $('.price').show();
    }
  });
});
function chkfood_price() {
    if (document.getElementById('food_price').value == "") {
        $('#frm .food_price').addClass('has-error');
        $('#frm .food_price').removeClass('has-success');
        return false;
    } else {
        $('#frm .food_price').addClass('has-success');
        $('#frm .food_price').removeClass('has-error');
    }
}

function chkfoodtype_id() {
    if (document.getElementById('foodtype_id').value == "") {
        $('#frm .foodtype_id').addClass('has-error');
        $('#frm .foodtype_id').removeClass('has-success');
        return false;
    } else {
        $('#frm .foodtype_id').addClass('has-success');
        $('#frm .foodtype_id').removeClass('has-error');
    }
}

function chkfood_name() {
    if (document.getElementById('food_name').value == "") {
        $('#frm .food_name').addClass('has-error');
        $('#frm .food_name').removeClass('has-success');
        return false;
    } else {
        $('#frm .food_name').addClass('has-success');
        $('#frm .food_name').removeClass('has-error');
    }
}

function confirmdata() {
    if (document.getElementById('foodtype_id').value == "") {
        chkfoodtype_id();
        $('#foodtype_id').focus();
        return false;
    }
    if (document.getElementById('food_name').value == "") {
        chkfood_name();
        $('#food_name').focus();
        return false;
    }
    document.getElementById("frm").submit();
    $("#buttontext").html("โปรดรอสักครู่...");
    document.getElementById("buttontext").disabled = true;
    return true;
}
</script>

<!-- --------------------เริ่มพรีวิวเลือกรูป ------------------ -->
<script type="text/javascript">
$(document).on('click', '#close-preview', function() {
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function() {
            $('.image-preview').popover('show');
        },
        function() {
            $('.image-preview').popover('hide');
        }
    );
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class", "close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
        content: "There's no image",
        placement: 'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function() {
        $('.image-preview').attr("data-content", "").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function() {
        var img = $('<img/>', {
            id: 'dynamic',
            width: 250,
            height: 'auto'
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function(e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
});
</script>
<!-- --------------------end พรีวิวเลือกรูป ------------------ -->
<script language="JavaScript">
function chkNumber(ele) {
    var vchar = String.fromCharCode(event.keyCode);
    if ((vchar < '0' || vchar > '9') && (vchar != '.') && (vchar != '-')) return false;
    ele.onKeyPress = vchar;
}
</script>
<!-- --------------------เลือกรูป ------------------ -->
<script>
$('#equipment_img').change(function() {
    var fileExtension = ['jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        alert("กรุณาอัพโหลดไฟล์ให้ถูกต้อง JPG, PNG, files.");
        this.value = '';
        return false;
    }
});
</script>
<!-- --------------------จบเลือกรูป ------------------ -->