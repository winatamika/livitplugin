<?php
//getdata.php
//http://www.w3schools.com/php/php_ajax_database.asp
//require_once( 'http://localhost/kelgaespecial/wp-load.php' );
$q = intval($_GET['q']);
global $wpdb;
 mysql_connect("localhost","root","");
mysql_select_db("kelgaeplugin");
echo "<table border='1'>";
$rows = mysql_query("SELECT * from wp_measurement where id_measurement = ".$q."");
echo "<table border='1'>";
 while($row= mysql_fetch_array($rows)){
echo "<td>" . $row['name_measurement'] . "</td>"; 
echo "<td><img src=".$row['directoryy']."></td>";
	$detail = $row['detail'];
	$detail = substr($detail, 0, -1);
	$explodedetail = explode("|", $detail);


	$size = $row['size'];
	$size = substr($size, 0, -1);
	$explodesize = explode("|", $size);

		foreach(array_combine($explodedetail, $explodesize) as $thedetail => $thesize){
			echo "<input type='text' name='detail[]' value='".$thedetail."' style='width:50px;' readonly>";
			echo "<input type='text' name='size[]' value='".$thesize."' style='width:50px;' >";
	

}
}
echo "<table>";

?>