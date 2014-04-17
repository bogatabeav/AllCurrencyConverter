<?php 
include("header.php");
include("Connections/connect.php");
include("lib/functions.php");
?>

<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]--> 
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />

<h1>Timeline Chart</h1>
<form method="post" action="mobileTimeline.php" >
  <label for="currChart">Select Currency</label></br>
  <select name="currChart" id="currChart">
  
<?php
$currencies = getAllCurrencies($con);

foreach($currencies as $value) {
	if($_POST['currChart']==$value[1]) {
		echo "<option value=\"" .$value[1]. "\" selected>" .$value[2]. " (" .$value[1]. ")</option>";
	} else {
		echo "<option value=\"" .$value[1]. "\">" . $value[2] . " (" .$value[1]. ")</option>";
	}	
}
?>

  </select>
  </br></br>
<label for="timePeriod">Select Time Period</label></br>
<select name="timePeriod" id="timePeriod">
	<option value="24" <? echo ($_POST['timePeriod'] == 24 ? ' selected' : ''); ?>>1 Day</option>
    <option value="48" <? echo ($_POST['timePeriod'] == 48 ? ' selected' : ''); ?>>2 Days</option>
    <option value="168" <? echo ($_POST['timePeriod'] == 168 ? ' selected' : ''); ?>>1 Week</option>
    <option value="336" <? echo ($_POST['timePeriod'] == 336 ? ' selected' : ''); ?>>2 Weeks</option>
    <option value="720" <? echo ($_POST['timePeriod'] == 720 ? ' selected' : ''); ?>>1 Month</option>
</select></br></br>
  <input type="submit" value="Submit" />
</form></br>
<div id="chartdiv" ></div>

<?php
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
var history = <? 
echo "[";
$count = count($history)-1;
foreach($history as $value) {
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
	echo "title: {text: '".$currency[1]." against US Dollar', show: true},";}
else {
	echo "title: {text: '', show: true,},";
}?>
	axesDefaults: {
        tickOptions: {
          fontSize: '5pt',
		  textColor: '#000000'
        }
    },
  	axes:{
	  	xaxis:{

			labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
			min:'<? echo date("Y-m-d g:iA", $startDate); ?>', 
			max:'<? echo date("Y-m-d g:iA", $endDate); ?>',
			renderer:$.jqplot.DateAxisRenderer, 
        	tickOptions:{
				formatString:'%#d-%b-%y %n %#I:%M %p',
			}        
		},
		yaxis:{
			labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
			min:<? echo $min < $max ? $min : ($min - $min/1000); ?>, 
			max:<? echo $min < $max ? $max : ($max + $max/1000); ?>,
			tickOptions:{
            	formatString:'%.3f'
			}
		}
  	},
	grid: {
		shadow: false, 
		background: '#ffffff', 
		borderWidth: 0.5
	},
  	highlighter: {
    	show: true,
   		sizeAdjust: 7.5,
		tooltipLocation: 'n',
		useAxesFormatters: true,
  	},
  	cursor: {
   		show: false
  	},
  	series:[{
		color:'#3286F0', 
		fillAlpha: 0.5, 
		lineWidth: 1, 
		fillAndStroke: true, 
		fill: true, 
		shadow: false, 
		markerOptions: {size: 1}
	}]
});
</script>
</br>

<?php
}
include("Connections/close.php");
include("footer.php");
?>
