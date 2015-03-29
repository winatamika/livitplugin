<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/style.css" rel="stylesheet" />

<?php
function settinginsta () {
global $wpdb;

$settings= $wpdb->get_results("SELECT * from wp_instagram_setting");
	foreach ($settings as $setting ){
		$client_id			= $setting->client_id;
		$client_secret 		= $setting->client_secret;
		$access_token 		= $setting->access_token;
	}

if(isset($_POST['update'])){	
		$client_id			= $_POST['client_id'];
		$client_secret 		= $_POST['client_secret'];
		$access_token 		= $_POST['access_token'];

		$wpdb->update(
		'wp_instagram_setting', //table
		array( 'client_id' => $client_id, 'client_secret' => $client_secret, 'access_token'=> $access_token 	), //data
		array( 'id_setting' => 1 ), //where
		array('%s','%s','%s' ) //data format
	
	);	
}
?>
<div class="container">
<h2>Instalivit Setting </h2>
<br>

<div style="margin-bottom:30px;"> 	
<b>Make sure the input you entered is correct !!</b>
</div>

<form role="form" method="post" enctype="multipart/form-data" action="">
  <div class="form-group">
    <label for="email">client_id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <input type="text" class="form-control" name="client_id" value="<?php echo $client_id; ?>"  style="width: 500px;">
  </div>
  <div class="form-group">
    <label for="pwd">client_secret:&nbsp;</label>
    <input type="text" class="form-control" name="client_secret" value="<?php echo $client_secret; ?>" style="width: 500px;">
  </div>
  <div class="form-group">
    <label for="pwd">access_token:</label>
    <input type="text" class="form-control" name="access_token" value="<?php echo $access_token; ?>" style="width: 500px;">
  </div>

  <button type="submit" name="update" class="btn btn-default">Submit</button>
</form>

</div>
<?php
}
?>