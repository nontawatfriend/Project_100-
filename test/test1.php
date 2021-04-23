<!-- <script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="../js/jquery-2.2.0.min.js"></script> -->
<style type="text/css"> 
#qty,#price,#net_price{
width:50px; 
text-align:center;
}
</style> 


<!-- <form action="" method="POST" name="frmborrow" id="frmborrow">
    <input type="number" name="qty" id="qty" onChange="calc_price()"> 
    <input type="number" name="price" id="price" onChange="calc_price()">
    <span name="net_price" id="net_price" ></span> <hr>
    <button type="submit">Send</button>
</form> -->
<!-- <script type="text/javascript" >
    function calc_price(){ 
    var Price = document.getElementById('price'); 
    var Qty = document.getElementById('qty'); // กําหนดค่า โดยใช้สูตร ผลคูณ ราคา X จํานวน 
    var total = parseInt(Price.value)*parseInt(Qty.value);// ใช้แบบปกติ 
    if(isNaN(total)) {
    total = 0;
    }
    var total; // walitua
    document.getElementById('net_price').innerHTML=total;
}

</script> -->

<!-- <script>
    window.addEventListener("load", function(){
    var Price = document.getElementById('price');
    var Qty = document.getElementById('qty');
    Price.addEventListener("change", calc_price);
    Qty.addEventListener("change", calc_price); },false); 
</script> 
    <form action="" method="POST">
        <input type="number" name="qty" id="qty">
        <input type="number" name="price" id="price">
        <input type="number" name="net_price" id="net_price" readonly > <hr>
        <button type="submit">Send</button> 1
    </form> -->

<form action="" method="POST" name="frmborrow" id="frmborrow">
    <input type="number" name="qty[0]" id="qty" class="css_qty"> 
    <input type="number" name="price[0]" id="price" class="css_price">
    <input name="net_price" id="net_price[0]" class="css_net_price"> <hr>

    <input type="number" name="qty[1]" id="qty" class="css_qty"> 
    <input type="number" name="price[1]" id="price" class="css_price">
    <input name="net_price" id="net_price[1]" class="css_net_price"> <hr><br>

    <input name="net_price" id="net_prices" class="sum">
    <span name="net_price" id="net_price" ></span> <hr>

    <button type="submit">Send</button>
</form>

<script type="text/javascript"> 
function calc_price(Price, Qty, netPrice) { // sound1/ Na object ann parameter // กําหนดค่า โดยใช้สูตร ผลคูณ ราคา X จํานวน
    /* var totals=0; */
    var total = parseInt(Price.value)+parseInt(Qty.value); // ใช้แบบปกติ
/*     totals+=parseInt(netPrice); // ใช้แบบปกติ

    document.getElementById('net_price').innerHTML=totals; 
    debugger; */
    if(isNaN(total)){
    
        total=0;
    }
    netPrice.value = total; // nalimuua // netPrice.value = (isNaN(total))?0 total;
}
    window.addEventListener("load", function() {
    var Price = Array.from(document.getElementsByClassName('css_price')); 
    var Qty = Array.from(document.getElementsByClassName('css_qty')); 
    var netPrice = Array.from(document.getElementsByClassName('css_net_price')); // วนลูปเพิ่ม event ให้แต่ละรายการ 
    
    
    Price.forEach(function(element,index) {
        element.addEventListener("change", function() {
        calc_price(Price[index], Qty[index], netPrice[index])
        });
    }); 
    Qty.forEach(function(element,index) {
         element.addEventListener("change", function(){
        calc_price(Price[index], Qty[index], netPrice[index]) 
        });
    });
debugger;
    },false);  

</script>

<form name=form1>
<input type="number" name=input1 value="1" size=10 onfocus="buffer=this.value" onchange="document.getElementById('total').innerHTML=this.value*10">
รวม <span id=total> 00</span>
<input type=button value=" เพิ่ม " 
onclick="document.form1.input1.value++">

<input type=button value=" ลด " 
onclick="document.form1.input1.value--">


                            
                            