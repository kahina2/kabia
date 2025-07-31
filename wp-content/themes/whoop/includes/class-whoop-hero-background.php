<?php
/**
 * Whoop Assets
 *
 * Handles assets.
 *
 * @author   AyeCode
 * @category API
 * @package  Whoop/Assets
 * @since    2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A class to call Whoop assets.
 *
 * We call these statically so they can easily be removed by 3rd party devs.
 *
 * Class Whoop_Assets
 */
class Whoop_Hero_Background {


	/**
	 * Init
	 */
	public static function init(){

		// @todo only show this if page template is set to whoop home
		add_action('save_post', array(__CLASS__, 'save'));
		add_action('add_meta_boxes', array(__CLASS__, 'add_meta_boxes'));

		add_filter('whoop_hero_background', array(__CLASS__,'hero_background'));
		add_filter('whoop_hero_credits', array(__CLASS__,'credits'));

		add_action( 'wp_ajax_whoop_hero',  array(__CLASS__,'ajax_get_next_background') );
		add_action( 'wp_ajax_nopriv_whoop_hero',  array(__CLASS__,'ajax_get_next_background') );
	}

	public static function ajax_get_next_background(){
//		print_r( $_POST );echo '####';exit;
//
//		$data['message'] = __( 'You have successfully deleted the Listing.', 'geodirectory' );
//		$data['redirect_to'] = get_post_type_archive_link( $post_type );
		$post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : '';
		$count = isset($_POST['count']) ? absint($_POST['count']) : '';

		if($post_id && $count){
			$defaults = self::default_settings();
			$settings = get_post_meta($post_id, '_whoop_hero', true);
			$settings = wp_parse_args($settings,$defaults);

			// GD
			if(defined('GEODIRECTORY_VERSION') && $settings['type']==''){
				$settings['type']='listing';
			}

			if($settings['type']=='gallery' && !empty($settings['id'])){

				$ids = trim($settings['id']);

				$ids = explode(",",$ids);

				$item = fmod($count, count($ids));

				$image = '';
				$id = '';

				if(!empty($ids[$item])){
					$id = $ids[$item];
					$image = wp_get_attachment_image($id,  'full', false, array( 'class' => 'whoop-hero-image w-100 embed-item-cover-xy whoop-js-fade-in position-absolute','loading'=>'eager' ) );
				}


				if($image){
					$image = str_replace("<img","<img onload='jQuery(this).fadeIn(500)' style='display:none;'",$image  );
					wp_send_json_success( array(
						'html' => $image,
						'caption' => wp_get_attachment_caption( $id ),
						'description' => get_post_field('post_content',$id),
					));
				}else{
					wp_send_json_error();
				}

			}elseif($settings['type']=='listing'){
				$image_data = self::get_listing_image();
				if(!empty($image_data)){
					$image_data['html'] = str_replace("<img","<img onload='jQuery(this).fadeIn(500)' style='display:none;' ",$image_data['html'] );
					$image_data['html'] = str_replace('class="','class="whoop-hero-image w-100 embed-item-cover-xy whoop-js-fade-in position-absolute ',$image_data['html'] );
					wp_send_json_success( $image_data );
				}else{
					wp_send_json_error();
				}
			}else{
				wp_send_json_error();
			}
		}else{
			wp_send_json_error();
		}

		wp_die();
	}

	public static function default_settings(){
		return array(
			'type' => '',
			'id' => '',
			'time' => '',
			'brightness' => '',
		);
	}

	public static function credits($html){
		global $whoop_hero_credits;
		if(!empty($whoop_hero_credits)){
			echo '<div class="container header-credits position-absolute" style="bottom:0;">';
			echo '<p class="whoop-hero-credits-caption text-white font-weight-bold">';
			if(!empty($whoop_hero_credits['caption'])){ echo $whoop_hero_credits['caption'];}
			echo '</p>';
			echo '<p class="whoop-hero-credits-description">';
			if(!empty($whoop_hero_credits['description'])){echo $whoop_hero_credits['description'];}
			echo '</p>';
			echo '</div>';
		}
		return $html;
	}

	public static function output_featured(){
		global $whoop_hero_credits,$post;
		$post_id = isset($post->ID) ? $post->ID : '';
		$image =  get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'whoop-hero-image w-100 embed-item-cover-xy ' ) );

		if($image){
			$id = get_post_thumbnail_id();
			$whoop_hero_credits = array(
				'caption' => get_the_post_thumbnail_caption( $post_id ),
				'description' => get_post_field('post_content',$id),
			);
		}

		return $image;
	}

	public static function output_default(){
		global $whoop_hero_credits;
		$user_name = "Burst";
		$user_link = "<a href='https://burst.shopify.com//' target='_blank' rel=\"nofollow\" class='text-white font-weight-bold'>$user_name</a>";
		$whoop_hero_credits = array(
			'caption' => 'Gourmet Cafe',
			'description' => sprintf(__("Photo by %s","whoop"),$user_link ),
		);
		$image = '<img width="1600" height="1066" src="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg" class="whoop-hero-image w-100 embed-item-cover-xy  wp-post-image " alt="" srcset="'.get_stylesheet_directory_uri().'/assets/images/whoop-splash.jpg 1600w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-300x200.jpg 300w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-768x512.jpg 768w, '.get_stylesheet_directory_uri().'/assets/images/whoop-splash-1024x682.jpg 1024w" sizes="(max-width: 1600px) 100vw, 1600px">';
		return $image;
	}

	public static function output_video($video_id = 'AjZXFw9iWkw'){
		global $whoop_hero_credits;
		$html = '';
		$video_id = $video_id ? $video_id : 'AjZXFw9iWkw';
		$whoop_hero_credits = array(
			'caption' => '',
			'description' => '',
		);

		$html .= '<iframe onload=\'jQuery(this).addClass("whoop-fade-in")\' src="https://www.youtube.com/embed/'.$video_id.'?controls=0&rel=0&autoplay=1&loop=1&playlist='.$video_id.'&modestbranding=1&iv_load_policy=3&disablekb=1&mute=1" frameborder="0" allowfullscreen class="w-100 embed-item-cover-xy position-absolute border-0" style="top:0;left:0;object-fit: cover;pointer-events: none;"></iframe>';
		return $html;
	}


	public static function output_gallery($ids = ''){
		global $whoop_hero_credits;

		$ids = trim($ids);
		if(empty($ids)){return '';}

		$ids = explode(",",$ids);
		$image = '';
		foreach($ids as $id ){
			$id = absint($id);
			$image = wp_get_attachment_image($id,  'full',false, array( 'class' => 'whoop-hero-image w-100 embed-item-cover-xy position-absolute ','loading'=>'eager' ) );
			if($image){
				break;
			}
		}

		if($image){
			$whoop_hero_credits = array(
				'caption' => wp_get_attachment_caption( $id ),
				'description' => get_post_field('post_content',$id),
			);
		}

		return $image;
	}

	public static function get_listing_image() {
		global $wpdb;

		$image = array( 
			'html' => '',
			'caption' => '',
			'description' => ''
		);

		$sql = $wpdb->prepare( "SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " AS a LEFT JOIN {$wpdb->posts} AS p ON p.ID = a.post_id WHERE a.type = %s AND a.featured = 1 AND a.is_approved = 1 AND p.post_status = 'publish' ORDER BY RAND() LIMIT 1", 'post_images' );

		$attachment = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " AS a LEFT JOIN {$wpdb->posts} AS p ON p.ID = a.post_id WHERE a.type = %s AND a.featured = 1 AND a.is_approved = 1 AND p.post_status = 'publish' ORDER BY RAND() LIMIT 1", 'post_images' ) );

		if ( ! empty( $attachment) ) {
			$img_tag = geodir_get_image_tag( $attachment, 'full', '', 'whoop-hero-image w-100 embed-item-cover-xy whoop-js-fade-in position-absolute' );
			$meta = ! empty( $attachment->metadata ) ? maybe_unserialize( $attachment->metadata ) : '';
			$image_tag =  wp_image_add_srcset_and_sizes( $img_tag, $meta , 0 );
			$permalink = "<a href='" . get_permalink( $attachment->post_id ) . "' class='text-white font-weight-bold'>" . esc_attr( get_the_title( $attachment->post_id ) ) . "</a>";

			$image = array(
				'html'  => $image_tag,
				'caption' => $permalink,
				'description' => $attachment->title ? esc_attr( $attachment->title ) : '',
			);
		}

		return $image;
	}

	public static function output_listing(){
		global $whoop_hero_credits;
		$image_data =  self::get_listing_image();
		$image ='';

		if($image_data){
			$image = $image_data['html'];
			$whoop_hero_credits = array(
				'caption' => $image_data['caption'],
				'description' => $image_data['description'],
			);
		}

		return $image;
	}

	public static function hero_background($html){
		global $whoop_hero_credits,$post;

		// init default globals
		$whoop_hero_credits = array(
			'caption' => '',
			'description' => '',
		);
		$script = '';
		$inner_style = '';
		$inner_class = '';
		$brightness = '';

		// get settings
		$defaults = self::default_settings();
		$settings = get_post_meta($post->ID, '_whoop_hero', true);
		$settings = wp_parse_args($settings,$defaults);


		// get html
		if($settings['type']==''){
		//auto

			if(defined('GEODIRECTORY_VERSION')){
				$html .= self::output_listing($settings['id']);
				$script = self::hero_script($settings);
			}else{
				$html .= self::output_featured();
			}

		}elseif($settings['type']=='featured'){
			$html .= self::output_featured();
		}elseif($settings['type']=='video'){
			$html .= self::output_video($settings['id']);
			$inner_style .= 'padding-top: 56.25%;';
			$inner_class .= 'position-relative';
		}elseif($settings['type']=='gallery' && !empty($settings['id'])){
			$html .= self::output_gallery($settings['id']);
			$script = self::hero_script($settings);
		}elseif($settings['type']=='listing' &&  defined('GEODIRECTORY_VERSION') ){
			$html .= self::output_listing($settings['id']);
			$script = self::hero_script($settings);
		}


		// Defaults
		if(!$html){
			$html .= self::output_default();
		}

		if( $html ){
			$html = str_replace("<img","<img onload='jQuery(this).addClass(\"whoop-fade-in\")'",$html  );
		}

		// brightness overide (default 50)
		if(!empty($settings['brightness']) && $settings['brightness'] <= 100){
			$brightness = " filter: brightness(".$settings['brightness']."%); ";
		}else{
			$brightness = " filter: brightness(50%); ";
		}

		$container_open = "<div class='whoop-hero-background-wrap w-100 position-absolute h-100 overflow-hidden w-100' style='top:0;left:0;$brightness'><div class='whoop-hero-background-wrap-inner $inner_class' style='$inner_style'>";
		$container_close = "</div></div>";

		return $container_open.$html.$container_close.$script;
	}

	public static function hero_script($settings){
		global $post;
		ob_start();
		?>
		<script>
			function whoop_hero_get_next(wait,count){
				var params = [];
				params['action'] = 'whoop_hero';
				params['count'] = count;
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url( 'admin-ajax.php' );?>',
					dataType: 'json',
					data: {
						action: 'whoop_hero',
						count: count,
						post_id: <?php echo (int) $post->ID;?>
					},
					success: function(res) {
						if (res.success && res.data) {
							if (res.data.html) {
								jQuery('.whoop-hero-background-wrap-inner').append(res.data.html);
								setTimeout(function(){jQuery('.whoop-hero-background-wrap-inner img:first-child').remove();},1000 );

								caption = res.data.caption ? res.data.caption : '';
								jQuery('.whoop-hero-credits-caption').html(caption);

								description = res.data.description ? res.data.description : '';
								jQuery('.whoop-hero-credits-description').html(description);
							}
						}
						count++;
						setTimeout(function(){whoop_hero_get_next(wait ,count)},wait );
					},
					fail: function(data) {
						console.log(data);
					}
				});
			}
			jQuery(function() {
				var whoopHeroWait = <?php echo $settings['time'] && $settings['time'] > 1000 ? absint($settings['time']) : 8000;?>;
				var whoopHeroCount = 1;
				setTimeout(function(){whoop_hero_get_next(whoopHeroWait ,whoopHeroCount)},whoopHeroWait );
			});
		</script>
		<?php

		return ob_get_clean();
	}

	public static function save($post_id)
	{
//		echo '###1';

//		print_r(array_diff(self::default_settings(),$_POST['_whoop_hero']));exit;
		if (array_key_exists('_whoop_hero', $_POST) && ( !empty(array_diff($_POST['_whoop_hero'],self::default_settings())) || !empty(get_post_meta($post_id,'_whoop_hero',true))) ) {
			$settings = array(
				'type' => !empty($_POST['_whoop_hero']['type']) ? esc_attr($_POST['_whoop_hero']['type']) : '',
				'id' => !empty($_POST['_whoop_hero']['id']) ? esc_attr($_POST['_whoop_hero']['id']) : '',
				'time' => !empty($_POST['_whoop_hero']['time']) ? absint($_POST['_whoop_hero']['time']) : '',
				'brightness' => !empty($_POST['_whoop_hero']['brightness']) ? absint($_POST['_whoop_hero']['brightness']) : '',
			);
			update_post_meta(
				$post_id,
				'_whoop_hero',
				$settings
			);
//			echo '###2';exit;
		}
	}

	public static function add_meta_boxes()
	{
		$screens = array('page');
		foreach ($screens as $screen) {
			add_meta_box(
				'whoop_hero_settings',          // Unique ID
				__('Hero Area Settings','whoop'), // Box title
				array(__CLASS__, 'meta_box_html'),   // Content callback, must be of type callable
				$screen,                 // Post type
				'side'
			);
		}
	}

	public static function meta_box_html( $post ) {
		$defaults = self::default_settings();
		$settings = get_post_meta( $post->ID, '_whoop_hero', true );
		$settings = wp_parse_args( $settings, $defaults );
		$options = array(
			'' => __('Auto','whoop'),
			'featured' => __('Featured image','whoop'),
			'video' => __('Video','whoop'),
			'gallery' => __('Gallery','whoop'),
			'listing' => __('Listing images (GeoDirectory)','whoop'),
		);
		?>
		<p class="post-attributes-label-wrapper whoop-hero-type-label-wrapper"><label class="post-attributes-label" for="whoop_hero_type"><?php _e( 'Show:', 'whoop' ); ?></label></p>
		<select name="_whoop_hero[type]" id="whoop_hero_type">
			<?php
			foreach( $options as $option => $desc ) {
				echo '<option value="' . $option . '" ' . selected( $settings['type'], $option, false ) . '>' . $desc . '</option>';
			}
			?>
		</select>
		<p class="post-attributes-label-wrapper whoop-hero-id-label-wrapper"><label class="post-attributes-label" for="whoop_hero_id"><?php _e( 'ID: (video id / attachments ids: 123,456,789)', 'whoop' ); ?></label></p>
		<input type="text" name="_whoop_hero[id]" id="whoop_hero_id" value="<?php echo esc_attr( $settings['id'] ); ?>" placeholder="AjZXFw9iWkw / 123,456,789" />
		<p class="post-attributes-label-wrapper whoop-hero-time-label-wrapper"><label class="post-attributes-label" for="whoop_hero_time"><?php _e( 'Time: (time between images, 8000 =  8 seconds)', 'whoop' );?></label></p>
		<input type="number" min="1000" name="_whoop_hero[time]" id="whoop_hero_time" value="<?php echo esc_attr( $settings['time'] ); ?>" placeholder="8000" />
		<p class="post-attributes-label-wrapper whoop-hero-brightness-label-wrapper"><label class="post-attributes-label" for="whoop_hero_brightness"><?php _e( 'Brightness: (how bright the background is, default 50%)', 'whoop' ); ?></label></p>
		<input type="number" name="_whoop_hero[brightness]" id="whoop_hero_brightness" value="<?php echo esc_attr( $settings['brightness'] ); ?>" placeholder="50" />
		<?php
	}
}
Whoop_Hero_Background::init();