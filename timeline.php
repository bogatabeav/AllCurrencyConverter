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
<form method="post" action="timeline.php" >
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
$endDate = date_timestamp_get($endDate);
$startDate = $endDate - ($_POST['timePeriod']*3600);

if(!$_POST['timePeriod']>0) {
	echo "Please select a time period.";
} else {
	$history = getNumRates($con, $_POST['currChart'], $startDate);
	$currency = getCurrency($con, $_POST['currChart']);
	$min = 10000;
	$max = 0;
?>

<script type="text/javascript" src="scripts/jquery.min.js"></script> 
<script type="text/javascript" src="scripts/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="scripts/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script>
/*
 * There should be no CSS styling of the jqPlot script below.  
 * All styling is done with the API.  Options are found at
 * http://www.jqplot.com/docs/files/jqPlotOptions-txt.html
 * Be forewarned, thar be dragons here
*/
var history = <? 
echo "[";
$count = count($history)-1;
foreach($history as $value) {

	// Sets Y-Axis min/max of chart 
	if($value[2]>$max){$max = $value[2];}
	if($value[2]<$min){$min = $value[2];}

	
	if($count == 0) {
		echo "['".date('Y-m-d g:iA',strtotime($value[3]))."',".$value[2]."]";
	} else {
		echo "['".date('Y-m-d g:iA',strtotime($value[3]))."',".$value[2]."],";
	}
	$count--;
} 
echo "]";?>;

$.jqplot('chartdiv',  [history],
{<?php 
if($_POST['timePeriod']>0) {
	echo "title: {text: '".$currency[2]." Timeline (".$currency[1].")', show: true},";
} else {
	echo "title: {text: '', show: true,},";
}?>
	axesDefaults: {
  		tickOptions: {
 		angle: -30,
 		fontSize: '8pt'
    	}
	},
	axes:{
		xaxis:{
			labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
			min:'<? echo date("Y-m-d g:iA", $startDate); ?>', 
			max:'<? echo date("Y-m-d g:iA", $endDate); ?>',
			renderer:$.jqplot.DateAxisRenderer, 
			tickOptions:{
				formatString:'%#d-%b-%y\n%#I:%M %p',
			}        
		},
		yaxis:{
			label: 'Conversion Rate to US Dollar',
			labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
			min:<? echo $min < $max ? $min : ($min - $min/10); ?>, 
			max:<? echo $min < $max ? $max : ($max + $max/10); ?>,
			tickOptions:{
       			formatString:'%.3f'
			}
		}
	},
	grid: {
		shadow: false, 
		background: '#ffffff', 
		borderWidth: 1.0
	},
	highlighter: {
    	show: true,
   		sizeAdjust: 7.5,
		tooltipLocation: 'n',
		useAxesFormatters: true,
		xAxisFormatString: '%m-%Y',
	},
	cursor: {
 		show: false
	},
	series:[{
		color:'#3286F0', 
		fillAlpha: 0.5, 
		lineWidth: 2, 
		fillAndStroke: true, 
		fill: true, 
		shadow: false, 
		markerOptions: {
			size: 1
			}
	}]
});

$(window).resize(function() {
	plot1.replot({resetAxes:true});
});

</script>

</br>

<?php
}
include("Connections/close.php");
include("footer.php");
?>
