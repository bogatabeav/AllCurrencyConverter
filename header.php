<?
include('lib/userAgent.php');
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html>
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>All Currency Converter</title>

<link href="css/normalize.css" rel="stylesheet" type="text/css">
<link href="css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/stylesheet.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" media="all" href="css/style.css">
<link rel="stylesheet" type="text/css" media="all" href="css/responsive.css">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<section id="container">

<div class="gridContainer clearfix">
<div id="header">
	<h1>Header Div</h1>
</div>
<div id="nav">
	<ul id="nav">
    	<li><a href="index.php">Exchange</a></li>
<?
if($mobile) {
	echo "<li><a href=\"mobileTimeline.php\">Timeline</a></li>";
} else {
	echo "<li><a href=\"timeline.php\">Timeline</a></li>";
}
?>
	</ul>
</div>

<div id="content">
