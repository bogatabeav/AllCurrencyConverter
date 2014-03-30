<?php 
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]--> 
<script language="javascript" type="text/javascript" src="scripts/jquery.min.js"></script> 
<script language="javascript" type="text/javascript" src="scripts/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />
<h1>Timeline Chart</h1>
<form method="post" action="timeline.php" >
  <label for="currency">Select Currency: </label>
  <select name="currChart" id="currChart">
<?php
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currChart']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>".$value[2]. " (" . $value[1]. ")</option>";
	} else {
        echo "<option value=\"" .$value[1]. "\">".$value[2]. " (" . $value[1]. ")</option>";
	}	
}
?>

  </select>
  </br></br>
  <input type="radio" name="timePeriod" value="6" <? if($_POST['timePeriod'] == 6) {echo " checked";}?> />
  6 Hours
  <input type="radio" name="timePeriod" value="12"<? if($_POST['timePeriod'] == 12) {echo " checked";}?> />
  12 Hours
  <input type="radio" name="timePeriod" value="24"<? if($_POST['timePeriod'] == 24) {echo " checked";}?> />
  24 Hours
  <input type="radio" name="timePeriod" value="48"<? if($_POST['timePeriod'] == 48) {echo " checked";}?> />
  48 Hours </br></br>
  <input type="submit" value="Submit" />
</form></br>
<div id="chartdiv" ></div>

<?php
$history = getNumRates($con, $_POST['currChart'], $_POST['timePeriod']);
$currency = getCurrency($con, $_POST['currChart']);
$greatest = 0;
$lowest = 10;
?>

<script>
var history = <? 
echo "[";
$count = 0;
foreach($history as $value) {
	if($value[2]>$greatest) {$greatest = ($value[2]+$value[2]/64);}
	if($value[2]<$lowest) {$lowest = ($value[2]-$value[2]/64);}
	if($count == $_POST['timePeriod']) {
		echo "['".($count+1)."',".$value[2]."]";
	} else {
		echo "['".($count+1)."',".$value[2]."],";
	}
	$count++;
} 
echo "]";?>;

$.jqplot('chartdiv',  [history],
{<?php if($_POST['timePeriod']>0) {
	echo "title: {text: '".$currency[2]." Timeline (".$currency[1].")', show: true},";}
else {
	echo "title: {text: '', show: true,},";
}?>

  axes:{
	yaxis:{min:<? echo $lowest; ?>, max:<? echo $greatest; ?>},
  	xaxis:{min:1, max:<? echo $_POST['timePeriod']; ?>},

  },
  series:[{color:'#5FAB78',lineWidth: 1.5, showMarker:false}]
});
</script> 
</br>

<?php
include("Connections/close.php");
include("footer.php");
?>
