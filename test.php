<?php 
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>

<h1>Currency Converter</h1>
<form method="post" action="test.php" >
  <label for="amount">Enter Amount: </label>
  <input type="text" name="amount" <? if($_POST['amount']>0) {echo "value=\"" . $_POST['amount']."\"";}?> />
  </br>
  <label for="from">From: </label>
  <select name="currencyA" id="currencyA">
    
<?php
// see lib/functions.php for getCurrencies() info
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currencyA']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>".$value[1]."  " .$value[2]. "</option>";
	} else {
        echo "<option value=\"" .$value[1]. "\">".$value[1]."  " .$value[2]. "</option>";
	}	
}
?>

  </select>
  </br>
  <label for="to">To: </label>
  <select name="currencyB" id="currencyB">
    
<?php
foreach($currencies as $value) {
	if($_POST['currencyB']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>".$value[1]."  "  .$value[2]. "</option>";
	} else {
        echo "<option value=\"" .$value[1]. "\">".$value[1]."  "  .$value[2]. "</option>";
	}	
}
?>

  </select>
  </br>
  <input type="submit" value="Submit" />  </br>
</form>

<?php
// see lib/functions.php for getRate() info
$rate1 = getRate($con, $_POST['currencyA']);
$rate2 = getRate($con, $_POST['currencyB']);

// see lib/functions.php for getCurrency() info
$name1 = getCurrency($con, $_POST['currencyA']);
$name2 = getCurrency($con, $_POST['currencyB']);
 
if($_POST['amount']>0 && is_numeric($_POST['amount'])) {     
	echo $_POST['amount']." " .$name1[2]. "s to " .$name2[2]. "s equals " 
		.(1/$rate1[2]*$rate2[2]*$_POST['amount']). " " .$name2[2]. "s</br>";
} else if($_POST['amount']!=NULL && !is_numeric($_POST['amount'])) {
	echo  "Please enter a numeric amount.";
} else {
echo "";
}
?>

<?php
include("Connections/close.php");
include("footer.php");
?>