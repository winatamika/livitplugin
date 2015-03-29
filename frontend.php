<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/bootstrap-theme.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo PLUGIN_URL; ?>/asset/css/style.css" rel="stylesheet" />
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/bootstrap.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/bootstrap.min.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/less-1.7.3.min.js"></script>
<script type="text/javascript" href="<?php echo PLUGIN_URL; ?>/asset/js/jquery-1.10.22.min.js"></script>
<script href="<?php echo PLUGIN_URL; ?>/asset/js/3.10.bootstrap.min.js"></script>

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        window.alert = function(){};
        var defaultCSS = document.getElementById('bootstrap-css');
        function changeCSS(css){
            if(css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="'+ css +'" type="text/css" />'); 
            else $('head > link').filter(':first').replaceWith(defaultCSS); 
        }
        $( document ).ready(function() {
          var iframe_height = parseInt($('html').height()); 
          window.parent.postMessage( iframe_height, 'http://bootsnipp.com');
        });
    </script>

<div class="container">
  <h1>INSTALIVIT PLUGIN</h1>
<div class="row">

<?php 
			global $wpdb;
			$rows = $wpdb->get_results("SELECT * from wp_instagram_setting");
			foreach ($rows as $row ){
				$dbclient_id = $row->client_id;
				$dbtoken	  = $row->access_token;
			}


			function callLoopInstagram($url,$token)
			{
				global $wpdb;
				$inst_stream = callInstagram($url);
				$results = json_decode($inst_stream, true);

						//Now parse through the $results array to display your results... 
						$i=0;
					if (is_array($results['data'])){
						foreach($results['data'] as $item){
						$i++;
						    $image_link 		= $item['images']['low_resolution']['url'];
						    $image_standard_res = $item['images']['standard_resolution']['url'];
						    $username 			= $item['user']['username'];
						    $fullname 			= $item['user']['full_name'];
						    $profilepic 		= $item['user']['profile_picture'];
						    $caption			= $item['caption']['text'];
						    $like 				= $item['likes']['count'];
						    $tags = $item['tags'];
						    $tag = implode("#", $tags);	?>
						     <div class='item'><div class='well'><?php echo $username; ?> <img src="<?php echo $profilepic ; ?>" class="img-circle" width="50px" height="50px" />
						       
							  <!--<img src="<?php echo $image_link; ?>" /><br>#<?php echo $tag; ?><br>-->
							  
								<a href="#" data-toggle="modal" data-target=".pop-up-<?php echo $i; ?>">
								<img src="<?php echo $image_link; ?>"  class="img-responsive img-rounded center-block" alt="">
								</a>
								<br><?php echo $caption; ?><br>
								<br>#<?php echo $tag; ?><br>
								<?php echo $like; ?> others like this.
							 </div></div>

      
							<!--  Modal content for the mixer image example -->
							  <div class="modal fade pop-up-<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true">
							    <div class="modal-dialog modal-lg">
							      <div class="modal-content">

							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							          <h4 class="modal-title" id="myLargeModalLabel-1"><center><img src="<?php echo $profilepic ; ?>" class="img-circle" width="80px" height="50px" /><?php echo $username; ?></center> </h4>
							        </div>
							        <div class="modal-body">
							        <img src="<?php echo $image_standard_res; ?>" class="img-responsive img-rounded center-block" alt="">
							        	<?php echo $like; ?> others like this.<br>
							        	<?php echo ' " '.$caption.' " '; ?> <br>
							        <?php 
							        		//var_dump($item['comments']['data']);
									       $comment_count 	= count($item['comments']['data']);
									       $comment = 0;
									       while($comment < 3 ){
									       $commentpic  	= $item['comments']['data'][$comment]['from']['profile_picture'];
									       $commentname 	= $item['comments']['data'][$comment]['from']['username'];
									       $thecomment		= $item['comments']['data'][$comment]['text'];
									       echo '<img src="'.$commentpic.'" width="50px" height="50px" class="img-thumbnail" /><b>'. $commentname .' </b> '.$thecomment.'<br>'; 
									       $comment++;
									   		}
							        ?>  <br>
							        <?php 
							        	$rows = $wpdb->get_results("SELECT * from wp_instagram_comment where id_media = '".$item['id']."' limit 3");
										        foreach ($rows as $row ){
										          echo " <b>".$row->name."</b> ";
										          echo " (".$row->email.") ";
										          echo " said : ' ".$row->comment." ' ";
										          echo " have rate &#9733 : ".$row->rate;
										          echo '<br>';
										        }

							        ?>
							   
									 <a href="<?php bloginfo('url'); ?>/read/?id=<?php echo $item['id']; ?>&token=<?php echo $token;?>">Read More</a>
							        </div>
							      </div><!-- /.modal-content -->
							    </div><!-- /.modal-dialog -->
							  </div><!-- /.modal mixer image -->
						   
					<?php	    
						}
					}
			} //endfunction callLoopInstagram()


				function callSearchInstagram($url,$arraytag,$token)
			{
				global $wpdb;
				$inst_stream = callInstagram($url);
				$results = json_decode($inst_stream, true);

				$i=0;
					if (is_array($results['data'])){
						//Now parse through the $results array to display your results... 
						foreach($results['data'] as $item){
							$i++;
						   	$image_link 		= $item['images']['low_resolution']['url'];
						    $image_standard_res = $item['images']['standard_resolution']['url'];
						    $username 			= $item['user']['username'];
						    $fullname 			= $item['user']['full_name'];
						    $profilepic 		= $item['user']['profile_picture'];
						    $caption			= $item['caption']['text'];
						    $like 				= $item['likes']['count'];
						    $tags = $item['tags'];
						    $tag = implode("#", $tags);

						    		$status = 0;
								    foreach($arraytag as $searchtag){
								    $tags = $item['tags'];
											    if (in_array($searchtag, $tags)) {
			   									 $status = 1;
												}
									}
									 $tag = implode("#", $tags);	
									if($status > 0){

										?>
							<div class='item'><div class='well'><center><b><?php echo $username; ?> <img src="<?php echo $profilepic ; ?>" width="50px" height="50px" class="img-circle"/></b></center>
						       
							  
								<a href="#" data-toggle="modal" data-target=".pop-up-<?php echo $i; ?>">
								<img src="<?php echo $image_link; ?>"  class="img-responsive img-rounded center-block" alt="">
								</a>
								<br>#<?php echo $tag; ?><br>
								<?php echo $like; ?> others like this.
							 </div></div>

      
							<!--  Modal content for the mixer image example -->
							  <div class="modal fade pop-up-<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true">
							    <div class="modal-dialog modal-lg">
							      <div class="modal-content">

							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							          <h4 class="modal-title" id="myLargeModalLabel-1"><center><img src="<?php echo $profilepic ; ?>" class="img-circle" width="80px" height="50px" /><?php echo $username; ?></center></h4>
							        </div>
							        <div class="modal-body">
							        <img src="<?php echo $image_standard_res; ?>" class="img-responsive img-rounded center-block" alt="">
							           	<?php echo $like; ?> others like this.<br>
							        	<?php echo $caption; ?> <br>
							        <?php 
							        		//var_dump($item['comments']['data']);
									       $comment_count 	= count($item['comments']['data']);
									       $comment = 0;
									       while($comment < 3 ){
									       $commentpic  	= $item['comments']['data'][$comment]['from']['profile_picture'];
									       $commentname 	= $item['comments']['data'][$comment]['from']['username'];
									       $thecomment		= $item['comments']['data'][$comment]['text'];
									     	echo '<img src="'.$commentpic.'" width="50px" height="50px" class="img-thumbnail" /><b>'. $commentname .' </b> '.$thecomment.'<br>'; 
									       $comment++;
									   		}
							        ?>  <br>
							           <?php 
							        	$rows = $wpdb->get_results("SELECT * from wp_instagram_comment where id_media = '".$item['id']."' limit 3");
										           foreach ($rows as $row ){
										          echo " <b>".$row->name."</b> ";
										          echo " (".$row->email.") ";
										          echo " ' ".$row->comment." ' ";
										          echo " have rate &#9733 : ".$row->rate;
										          echo '<br>';
										        }

							        ?>
							      
									 <a href="<?php bloginfo('url'); ?>/read/?id=<?php echo $item['id']; ?>&token=<?php echo $token; ?>">Read More</a>
							        </div>
							      </div><!-- /.modal-content -->
							    </div><!-- /.modal-dialog -->
							  </div><!-- /.modal mixer image -->

								<?	}
									
						    
						}
					}
			} //endfunction callSearchInstagram()


$atts = shortcode_atts(
		array(
			'user' => 'null',
			'hashtag' => 'null',
		), $atts,'liv_shortcode');



	$tag = $atts['hashtag'];
	$user = $atts['user'];
	$client_id = $dbclient_id;
	//$client_id = "83ef90c1159b499aa2c34ac9d710ab88";

		if(strpos($user, '.') !== false){
			$arrayuser = explode(".", $user);
		}else{
			$arrayuser[] = $user;
		}
		if(strpos($tag, '.') !== false){
			$arraytag = explode(".", $tag);
		}else{
			$arraytag[] = $tag;
		}
    		
	

	if($user != 'null' && $tag == 'null'){

		foreach ($arrayuser as $user){
			$getId_Url = 'https://api.instagram.com/v1/users/search?q='.$user.'&client_id='.$client_id;
			$json = file_get_contents($getId_Url);
			$links = json_decode($json);
			$count = count($links->data);
						for($i=0;$i<$count;$i++){
						$user_id =  $links->data[$i]->id;
						$url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent?client_id='.$client_id;
						callLoopInstagram($url,$dbtoken);
									}
		}

	}

	elseif($tag !='null' && $user == 'null'){
		foreach ($arraytag as $tag){
			$url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?client_id='.$client_id;
			callLoopInstagram($url,$dbtoken);
		}
	}

	elseif($tag !='null' && $user !='null'){
			foreach ($arrayuser as $user){
			$getId_Url = 'https://api.instagram.com/v1/users/search?q='.$user.'&client_id='.$client_id;
			$json = file_get_contents($getId_Url);
			$links = json_decode($json);
			$count = count($links->data);
						for($i=0;$i<$count;$i++){
						$user_id =  $links->data[$i]->id;
						$url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent?client_id='.$client_id;
						callSearchInstagram($url,$arraytag,$dbtoken);
									}
		}
	}

	else{
	
	$url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?client_id='.$client_id;
	callLoopInstagram($url,$dbtoken);

	}


?>

</div>
</div>