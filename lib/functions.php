<?php

/* Returns array of most recent currency rate from input currency code
 * Input: connection variable $con and currency code variable $code
 * Output: Array of specific rate in format below 
 * $var[1] = rate_code (shared currency code for all databases)
 * $var[2] = rate_num (Current Rate of the currency)
 * $var[3] = rate_time (timestamp of most recent update)
 * $var[4] = rate_ask (asking price of the currency)
 * $var[5] = rate_bid (selling proce of the currency)
*/
function getRate($con, $code)
{

	$sql = "SELECT * FROM rates WHERE rate_code='".$code."' ORDER BY rate_id ASC LIMIT 1";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);

	mysqli_free_result($result);
	
	return $row;
}



/* Returns array of currency reference information from input currency code
 * Input: connection variable $con and currency code variable $code
 * Output: Array of specific currency in format below 
 * $var[1] = curr_code (shared currency code for all databases)
 * $var[2] = curr_name (String name of the currency)
 * $var[3] = curr_countries (String of countries that use the currency)
*/
function getCurrency($con, $code)
{

	$sql = "SELECT * FROM currency WHERE curr_code='".$code."'";
	$result =  mysqli_query($con, $sql);
	$row = mysqli_fetch_row($result);
	
	mysqli_free_result($result);
	
	return $row;
}

/* returns 2D array of all currency reference information
 * Input: connection variable $con
 * Output: 2d Array of all currencies in format below 
 * $var[n][1] = curr_code (shared currency code for all databases)
 * $var[n][2] = curr_name (String name of the currency)
 * $var[n][3] = curr_countries (String of countries that use the currency)
*/
function getCurrencies($con)
{
	$array[] = array();
	$sql = "SELECT * FROM currency ORDER BY curr_id ASC";
	$result = mysqli_query($con, $sql);
	$count = 0;
	
	while($row = mysqli_fetch_row($result)) {
		$array[$count]=array($row[0], $row[1], $row[2], $row[3]);
		$count++;
	}
	
	mysqli_free_result($result);
	
	return $array;
}

?>