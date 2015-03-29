<?php
/**
 * Template Name: Template Read More
 *
 * A template used to demonstrate how to include the template
 * using this plugin.
 *
 * @package PTE
 * @since 	1.0.0
 * @version	1.0.0
 */

?>

<?php get_header(); ?>

<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/bootstrap-theme.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/style.css" rel="stylesheet" />
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/bootstrap.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/bootstrap.min.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/less-1.7.3.min.js"></script>


<div class="container">
  <h1>INSTALIVIT PLUGIN</h1>
<?php 
global $wpdb;
$insta_id = $_GET['id'];
$token    = $_GET['token'];

  $getId_Url = 'https://api.instagram.com/v1/media/'.$insta_id.'?access_token='.$token;
        $inst_stream    = callInstagram($getId_Url);
        $results        = json_decode($inst_stream, true);
        $commentcount   =  $results['data']['comments']['count'];
        $i              = 0;

        echo '<br>';
        echo "<img src='".$results['data']['user']['profile_picture']."' class='img-circle'>";
        echo "<h1><b>".$results['data']['user']['username']."</b></h1>";
        echo '<br>';
        echo"<img src='".$results['data']['images']['standard_resolution']['url']."' class='img-rounded img-responsive'>";
        echo '<br>';
        echo $results['data']['likes']['count'].'others like this';
        echo '<br>';
     
    
        if (is_array($results['data'])){
             while($i < $commentcount ){
              echo "<img src='".$results['data']['comments']['data'][$i]['from']['profile_picture']."'' class='img-rounded' width='50px' height='50px' style='margin:5px'' />";

              echo "<b>".$results['data']['comments']['data'][$i]['from']['username']."</b> said ";
          
              echo " ' ".$results['data']['comments']['data'][$i]['text']." ' ";
         
              echo '<br>';

              $i++;
            }
        }
        
        echo '<br>';

        $rows = $wpdb->get_results("SELECT * from wp_instagram_comment where id_media = '".$insta_id."'");
         foreach ($rows as $row ){
                              echo " <b>".$row->name."</b> ";
                              echo " (".$row->email.") ";
                              echo " said : ' ".$row->comment." ' ";
                              echo " have rate &#9733 : ".$row->rate;
                              echo '<br>';
                            }

     echo '<br>';



if($_POST['thename'] !="" && $_POST['theemail'] !="" && $_POST['comment'] !="" && $_POST['rate'] !=""){
  $media_id = $insta_id;
  $name =  $_POST['thename'];
  $email = $_POST['theemail'];
  $comment =$_POST['comment'];
  $rate = $_POST['rate'];
   $wpdb->query( $wpdb->prepare( 
        "
        INSERT INTO wp_instagram_comment
        (  id_media, name, email, comment, rate )
        VALUES ( %s, %s, %s, %s, %s )
        ", 
         $media_id , $name, $email,$comment,$rate  
        ) ); 
          echo '<div class="alert alert-success" role="alert">
                <a href="#" class="alert-link">Your comment successfully added! Please refresh this page</a>
                </div>
                <meta http-equiv="refresh" content="3">
                ';

}
?>
</div>

<div class="container">
  <div class="col-md-6">
  <div class="panel panel-info">
    <div class="panel-heading">Form Comment</div>
    <div class="panel-body">
      <form role="form" method="POST" enctype="multipart/form-data" action="">
  <div class="form-group">
    <label class="control-label" for="exampleInputEmail1">Name</label>
    <input type="text" name="thename" class="form-control" id="exampleInputName" placeholder="Enter your name" required>
  </div>

  <div class="form-group">
    <label class="control-label" for="exampleInputEmail1">Email</label>
    <input type="text" name="theemail" class="form-control" id="exampleInputEmail1" placeholder="Enter your email">
  </div>

  <div class="form-group">
    <label class="control-label" for="exampleInputEmail1">Comment</label>
    <textarea name="comment" rows="4" cols="100"></textarea>
  </div>

  <div class="form-group">
    <label class="control-label" for="exampleInputRate">Rate</label>

        <select name="rate" class="form-control" id="exampleInputRate">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
  </div>

  <button type="submit" class="btn btn-default">Post Comment! </button>
</form>

    </div>
  </div>
</div>
</div>

<?php get_footer(); ?>