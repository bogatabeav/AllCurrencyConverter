<?php 
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>
<!-- Add to stylesheet-->
<style>
.styled-select select {
	font-size: 16px;
   line-height: 1;
   border: 0;
   border-radius: 0;
   height: 34px;
   -webkit-appearance: none;
}
</style>


<h1>Currency Converter</h1>
<form method="post" action="test.php" >
 
  <label for="from">From: </label>
  <select name="currencyA" id="currencyA" class="styled-select">
    
<?php
// see lib/functions.php for getCurrencies() info
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currencyA']==$value[1]) {
		echo "<optgroup label=\"".$value[1]."\">";
		echo "<option value=\"" .$value[1]. "\" selected>" .$value[2]. "</option>";
		echo "</optgroup>";
	} else {
        echo "<optgroup label=\"".$value[1]."\">";
		echo "<option value=\"" .$value[1]. "\">" .$value[2]. "</option>";
		echo "</optgroup>";
	}	
}

?>

  </select>

</form>


<?php
include("Connections/close.php");
include("footer.php");
?>