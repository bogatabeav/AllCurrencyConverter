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
  <input type="submit" value="Submit" />
</form>

<?php
// see lib/functions.php for getRate() info
$rate1 = getRate($con, $_POST['currencyA']);
$rate2 = getRate($con, $_POST['currencyB']);

// see lib/functions.php for getCurrency() info
$name1 = getCurrency($con, $_POST['currencyA']);
$name2 = getCurrency($con, $_POST['currencyB']);
 
if($_POST['amount']>0) {     
	echo $_POST['amount']." " .$name1[2]. "s to " .$name2[2]. "s equals " 
		.(1/$rate1[2]*$rate2[2]*$_POST['amount']). " " .$name2[2]. "s</br>";
} 
?>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]--> 
<script language="javascript" type="text/javascript" src="scripts/jquery.min.js"></script> 
<script language="javascript" type="text/javascript" src="scripts/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />
<h1>Timeline Chart</h1>
<form method="post" action="test.php" >
  <label for="currency">Select Currency: </label>
  <select name="currChart" id="currChart">
    
<?php
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currChart']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>".$value[1]."  "  .$value[2]. "</option>";
	} else {
        echo "<option value=\"" .$value[1]. "\">".$value[1]."  "  .$value[2]. "</option>";
	}	
}
?>

  </select>
  </br>
  <input type="radio" name="timePeriod" value="6" <? if($_POST['timePeriod'] == 6) {echo " checked";}?> />
  6 Hours
  <input type="radio" name="timePeriod" value="12"<? if($_POST['timePeriod'] == 12) {echo " checked";}?> />
  12 Hours
  <input type="radio" name="timePeriod" value="24"<? if($_POST['timePeriod'] == 24) {echo " checked";}?> />
  24 Hours
  <input type="radio" name="timePeriod" value="48"<? if($_POST['timePeriod'] == 48) {echo " checked";}?> />
  48 Hours </br>
  <input type="submit" value="Submit" />
</form>
<div id="chartdiv" style="height:250px;width:800px; "></div>

<?php
$history = getNumRates($con, $_POST['currChart'], $_POST['timePeriod']);
$greatest = 0;
$lowest = 0;
?>

<script>
var history = "<? echo $history[5][2] ?>";
$.jqplot('chartdiv',  [[<?
$count = 1;
foreach($history as $value) {
	if($value[2]>$greatest) {$greatest = ceil($value[2]+$value[2]/8);}
	if($value[2]<$lowest) {$lowest = floor($value[2]);}
	if($count == $_POST['timePeriod']) {
		echo "[".$count.",".$value[2]."]";
	} else {
		echo "[".$count.",".$value[2]."],";
	}
	$count++;
}
?>
]],
{ title:'Currency Timeline',
  axes:{yaxis:{min:<? echo $lowest; ?>, max:<? echo $greatest; ?>},
  xaxis:{min:0, max:<? echo $_POST['timePeriod']+1; ?>}},
  series:[{color:'#5FAB78'}]
});
</script> 
</br>

<?php
include("Connections/close.php");
include("footer.php");
?>