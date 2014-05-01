<?php 
/*
  index.php
  Exchange conversion function 
  INPUT: User enters numeric amount and selects two currencies from dropdown menus.
  OUTPUT: returns original amount and currency selections with new converted amount
*/
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>
<h1>Exchange Conversion</h1>

<form method="post" action="index.php" >
	<fieldset>
  		<label for="amount">Enter Amount</label></br>
  		<input type="text" name="amount" maxlength="10" <? if($_POST['amount']>0) {echo "value=\"" . $_POST['amount']."\"";}?> />
  		</br>
        </br>
  		<!--label for="currencyA">Select Starting Currency</label-->
        
  		<select name="currencyA" id="currencyA" >
<?php
// see lib/functions.php for getCurrencies() info
$currencies = getAllCurrencies($con);
echo "<option value=''>Please select a source currency...</option>";
foreach($currencies as $value) {
	if($_POST['currencyA']==$value[1]) {
		echo "\t\t\t<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>\n";
	} else {
		echo "\t\t\t<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>\n";
	}	
}
?>
  		</select>
  		&nbsp;&nbsp;
  		<img src="images/transfer.png">
  		
  		<!--label for="currencyB">Select New Currency</label>-->
        
  		<select name="currencyB" id="currencyB">
<?php
echo "<option value=''>Please select a destination currecny...</option>";
foreach($currencies as $value) {
	if($_POST['currencyB']==$value[1]) {
		echo "\t\t\t<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>\n";
	} else {
		echo "\t\t\t<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>\n";
	}	
}
?>
  		</select>
  		</br>
        </br>
  		<input type="submit" value="Submit" />
  </fieldset>
</form>
</br>
<?php
// functions for database requests (see functions.php for more info)
$rate1 = getRate($con, $_POST['currencyA']);
$rate2 = getRate($con, $_POST['currencyB']);
$name1 = getCurrency($con, $_POST['currencyA']);
$name2 = getCurrency($con, $_POST['currencyB']);
// removing hidden characters
$amount = trim($_POST['amount']); 
 
if($amount!=NULL && is_numeric($amount) && $amount>0) { 
	// for successful input    
	echo "<h3>".number_format($amount)." " .$name1[2]. "s equal " 
		.number_format(round((1/$rate1[2]*$rate2[2]*$amount), 3)). " " .$name2[2]. "s</h3></br>";
} else if($amount!= NULL && is_numeric($amount)) {
	echo  "You've entered a number outside the allowable range.  Please enter a positive numeric amount.";
} else if ($amount!= NULL && !is_numeric($amount)) {
	// for characters other than numeric
	echo  "You've entered non-numeric characters.  Please enter a positive numeric amount.";
} else {
	// for NULL value (default)
	echo "";
}

echo "<br/>";
include("Connections/close.php");
include("footer.php");
?>
