<?php 
if(isset($_POST["mytext1"])){
    echo "<pre>";
    print_r($_POST);
    print_r($_FILES);   
    echo "</pre>";    
exit;
}
?>