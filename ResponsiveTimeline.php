<?php 
/*
  timeline.php
  Timeline function designed desktop an tablet viewing.
  INPUT:  User selects currency from dropdown and timeframe radio button.
  OUTPUT:  Displays chart of currency rate over selected time period
*/
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]--> 
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />

<h1>Timeline Chart</h1>
<form method="post" action="ResponsiveTimeline.php" >
	<fieldset>
  		<label for="currChart">Select Currency</label></br>
  		<select name="currChart" id="currChart">
<?php
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currChart']==$value[1]) {
		echo "\t\t\t<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>\n";
	} else {
		echo "\t\t\t<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>\n";
	}	
}
?>
  		</select>
  		</br>
        </br>
  		<label for="timePeriod">Select Time Period</label></br>
  		<input type="radio" name="timePeriod" value="24" <? if($_POST['timePeriod'] == 24) {echo " checked";}?> />1 Day
  		<input type="radio" name="timePeriod" value="48"<? if($_POST['timePeriod'] == 48) {echo " checked";}?> />2 Days
  		<input type="radio" name="timePeriod" value="168"<? if($_POST['timePeriod'] == 168) {echo " checked";}?> />1 Week
  		<input type="radio" name="timePeriod" value="336"<? if($_POST['timePeriod'] == 336) {echo " checked";}?> />2 Weeks 
  		<input type="radio" name="timePeriod" value="720"<? if($_POST['timePeriod'] == 720) {echo " checked";}?> />1 Month
  		</br>
        </br>
  		<input type="submit" value="Submit" />
	</fieldset>
</form>
</br>

<div id="chartdiv" ></div>

<?php
// variables for charting x-axis limits
$endDate = date_create();
$endDate = floor(date_timestamp_get($endDate)/3600)*3600;
$startDate = $endDate - ($_POST['timePeriod']*3600);

if(!$_POST['timePeriod']>0) {
	echo "Please select a time period.";
} else {
	$history = getNumRates($con, $_POST['currChart'], $startDate);
	$currency = getCurrency($con, $_POST['currChart']);
	$min = 10000;
	$max = 0;
	$sql = "select * from rates where rate_code = '" . $_POST['currChart']."' order by rate_time asc";
	$result = mysqli_query($con, $sql);
	
?>





  <script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {

      title:{
      text: "<?=$_POST['currChart']?>"
      },
      axisY:{
        includeZero: false

      },
       data: [
      {
        type: "line",

        dataPoints: [
        <?
        while ($row = $result->fetch_assoc()) {
        	$tempDate = getdate(strtotime ($row['rate_time']));
			//print_r($tempDate);
			
        ?>
        { x: new Date(<?=$tempDate[year]?>, <?=$tempDate[mon]-1?>, <?=$tempDate[mday]?>, <?=$tempDate[hours]?>), y: <?=$row["rate_num"]?> },
        <?
        } //end while loop
        ?>
        ]
      }
      ]
    });

    chart.render();
  }
  </script>
 <script type="text/javascript" src="scripts/canvasjs.min.js"></script></head>
<body>
  <div id="chartContainer" style="height: 300px; width: 100%;">
  </div>

<?php
}
include("Connections/close.php");
include("footer.php");
?>
