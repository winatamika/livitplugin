<?php
/**
 * Template Name: Template Special Request
 *
 * A template used to demonstrate how to include the template
 * using this plugin.
 *
 * @package PTE
 * @since 	1.0.0
 * @version	1.0.0
 */
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kelgae/style-admin.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/bootstrap-responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/examples.css">
  <link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/image-picker.css">
  <script src="img_picker/analytics.js" async=""></script><script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/jquery.js" type="text/javascript"></script>
 <!-- <script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/prettify.js" type="text/javascript"></script>
  <script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/jquery_002.js" type="text/javascript"></script>
  <script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/show_html.js" type="text/javascript"></script>-->
  <script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/img_picker/image-picker.js" type="text/javascript"></script>

<!--	<script src="<?php echo WP_PLUGIN_URL; ?>/kelgae-special/templates/js/jquery-1.4.js" type="text/javascript"></script> -->
<?php $id_tipe = $_POST['tipe'];

?>
<center><h1>SELECT YOUR FABRIC</h1></center>
  <form name="tipe" method="post" action="<?php echo  site_url();?>/three"
              enctype="multipart/form-data">
 
	  <?php
global $wpdb;
$rows = $wpdb->get_results("SELECT * from wp_fabric where id_type=".$id_tipe."");
?>
<div class="picker">
<input type="hidden" name="tipe" value="<?php echo $id_tipe; ?>">
 <select class="image-picker" id='fabric' name='fabric'>
<?php foreach ($rows as $row ){ ?>
       
        <option data-img-src="<?php echo $row->directoryy; ?>" value="<?php echo $row->id_fabric; ?>"><?php echo $row->name_fabric; ?></option>
<?php } ?>	 

      </select></div> 
	  
	  
	  
	    <script type="text/javascript">
j = jQuery.noConflict();
(function($){

    j("select.image-picker").imagepicker({
      hide_select:  false,
    });

})(j); 
  </script>
  <input name="submit" type="submit" id="submit" value="Submit" />
  </form>