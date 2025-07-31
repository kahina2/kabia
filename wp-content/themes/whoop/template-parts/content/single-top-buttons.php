<span class="whoop-top-review-button">
<?php
$review_text = __("Write a review","whoop");
echo do_shortcode( '[gd_post_badge key="post_title" condition="is_not_empty" icon_class="fas fa-star" badge="'.$review_text.'" link="#respond" bg_color="#d32323" txt_color="#ffffff" size="medium"]' );
//echo do_shortcode( '[gd_post_rating]' );
?>
</span>
<span class="whoop-top-action-buttons">
	<span class="whoop-top-action-buttons-wrap">
		
		<?php
		global $post;
		if(function_exists('geodir_get_post_badge')){

			// @todo added via review upload just now
			if(defined('GEODIR_REVIEWRATING_VERSION') && geodir_get_option('rr_enable_images')){
				// add photo
				$params = array();
				$params['badge'] = __("Add photo","whoop");
				$params['icon_class'] = "fas fa-camera";
//				$params['link'] = 'javascript:void(0);';
//				$params['onclick'] = "alert('feature coming soon');return false;";
				$params['link'] = '#respond';
				echo  geodir_get_post_badge( $post->ID, $params );
			}


			// share
			$params = array();
			$params['badge'] = __("Share","whoop");
			$params['icon_class'] = "fas fa-share-square";
			$params['link'] = 'javascript:void(0);';
			$params['onclick'] = "lity('.whoop-top-share-wrap');return false;";
			echo  geodir_get_post_badge( $post->ID, $params );
			get_template_part( 'template-parts/content/share' );

		}

		// add to list
		if(defined('GD_LISTS_VERSION')){echo do_shortcode( '[gd_list_save]' );}
		?>
	</span>
</span>