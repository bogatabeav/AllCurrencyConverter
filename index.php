<?php 
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>
<h1>Exchange Conversion</h1>

<form method="post" action="index.php" >
  <label for="amount">Enter Amount</label></br>
  <input type="text" name="amount" maxlength="10" <? if($_POST['amount']>0) {echo "value=\"" . $_POST['amount']."\"";}?> />
  </br></br>
  <label for="currencyA">Select Starting Currency</label></br>
  <select name="currencyA" id="currencyA" >

<?php
// see lib/functions.php for getCurrencies() info
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currencyA']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>";
	} else {
		echo "<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>";
	}	
}
?>

  </select>
  </br></br>
  <label for="currencyB">Select New Currency</label></br>
  <select name="currencyB" id="currencyB">
    
<?php
foreach($currencies as $value) {
	if($_POST['currencyB']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>";
	} else {
		echo "<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>";
	}	
}
?>

  </select>
  </br></br>
  <input type="submit" value="Submit" />
</form></br>
<?php
// see lib/functions.php for getRate() info
$rate1 = getRate($con, $_POST['currencyA']);
$rate2 = getRate($con, $_POST['currencyB']);

// see lib/functions.php for getCurrency() info
$name1 = getCurrency($con, $_POST['currencyA']);
$name2 = getCurrency($con, $_POST['currencyB']);
$amount = trim($_POST['amount']); 
 
if($amount>0 && is_numeric($amount)) {     
	echo $amount." " .$name1[2]. "s to " .$name2[2]. "s equals " 
		.(1/$rate1[2]*$rate2[2]*$amount). " " .$name2[2]. "s</br>";
} else if($amount!= NULL && !is_numeric($amount)) {
	echo  "Please enter a real number.";
} else {
echo "";
}
?>
</br>
<?php
include("Connections/close.php");
include("footer.php");
?>
