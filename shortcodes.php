<?php
/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/

if (!function_exists('accordion_shortcode')) {
	function accordion_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => ''
		), $atts));

		if( isset($GLOBALS['collapsibles_count']) ) {
			$GLOBALS['collapsibles_count']++;
		} else {
			$GLOBALS['collapsibles_count'] = 0;
		}

		if($type == 'type2') {
			$type = 'accordion__alt';
		}

		$output = '<div class="panel-group accordion '.$type.'" id="custom-collapse-'.$GLOBALS['collapsibles_count'].'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('accordion', 'accordion_shortcode');
}

if (!function_exists('panel_shortcode')) {
	function panel_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'title' => 'Title goes here',
				'state' => ''
		), $atts));

		$panel_title = '';

		if($state == 'open') {
			$state = 'in';
		}

		if($state == 'closed') {
			$panel_title = 'collapsed';
		}

		$id = rand();

		$output = '<div class="panel">';
			$output .= '<div class="panel-heading">';
				$output .= '<a data-toggle="collapse" data-parent="#custom-collapse-'.$GLOBALS['collapsibles_count'].'" href="#'.$id.'-panel" class="panel-title '.$panel_title.'">';
					$output .= '<span class="panel-title-inner">';
						$output .= $title;
					$output .= '</span>';
				$output .= '</a>';
			$output .= '</div>';

			$output .= '<div id="'.$id.'-panel" class="panel-collapse collapse '.$state.'">';
				$output .= '<div class="panel-body">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode('panel', 'panel_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('alert')) {
	function alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => 'danger'
	    ), $atts));
		
	   return '<div class="alert alert-'.$type.' fade in"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('alert', 'alert');
}





/*-----------------------------------------------------------------------------------*/
/*	Animation
/*-----------------------------------------------------------------------------------*/

if (!function_exists('animate_shortcode')) {
	function animate_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'animation' => '',
				'delay' => ''
		), $atts));

		$output = '<div data-animation="'.$animation.'" data-animation-delay="'.$delay.'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}
	add_shortcode('animate', 'animate_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Blog Posts (Recent Posts)
/*-----------------------------------------------------------------------------------*/

if (!function_exists('shortcode_recent_posts')) {
	
	function shortcode_recent_posts($atts, $content = null) {
		
		extract(shortcode_atts(array(										 
				'num' => '5',
				'words_num' => '15',
				'img_size' => 'small'
		), $atts));

		$output = '<div class="widget widget__sidebar widget_posts no-bottom-margin"><ul class="widget-posts-list">';

		global $post;
		global $tjoy_string_limit_words;
		
		$args = array(
			'post_type' => 'post',
			'numberposts' => $num,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'suppress_filters' => 0
		);

		$latest = get_posts($args);
		
		foreach($latest as $k => $post) {
			// Unset not translated posts
			if ( function_exists( 'wpml_get_language_information' ) ) {
				global $sitepress;
				$check = wpml_get_language_information( $post->ID );
				$language_code = substr( $check['locale'], 0, 2 );
				if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$k] );

				// Post ID is different in a second language Solution
				if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, $type, true ) );
				}

				setup_postdata($post);
				$excerpt = get_the_excerpt();

				$output .= '<li>';


				if ( has_post_thumbnail($post->ID) ){
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $img_size);
					$output .= '<figure class="thumb"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
					$output .= '<img src="'.$image[0].'" alt="" class="alignnone">';
					$output .= '</a></figure>';
				}
				$output .= '<h5 class="post-title post-title__bold"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
						$output .= get_the_title($post->ID);
				$output .= '</a></h3>';
				$output .= '<span class="date">';
					$output .= get_the_time(get_option('date_format'));
				$output .= '</span>';

				$output .= '<div class="post-excerpt">';
					$output .= '<p>';
						$output .= tjoy_string_limit_words($excerpt,$words_num);
					$output .= '</p>';
				$output .= '</div>';
				
			$output .= '</li>';
				
		}
				
		$output .= '</ul></div>';
		return $output;
	}

	add_shortcode('recent_posts', 'shortcode_recent_posts');
}





/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('button_shortcode')) {
	function button_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color' => 'default',
				'link' => '#',
				'text' => 'Button',
				'size' => 'normal',
				'target' => '_self',
				'icon' => 'none'
	   ), $atts));
	    
		$output =  '<a href="'.$link.'" title="'.$text.'" class="btn btn-'.$size.' btn-'.$color.'" target="'.$target.'">';
			if($icon !== 'none') {
				$output .= '<i class="fa '.$icon.'"></i>';
			}
			$output .= $text;
		$output .= '</a>';

	   return $output;

	}
	add_shortcode('button', 'button_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Call to Action
/*-----------------------------------------------------------------------------------*/

if (!function_exists('cta_shortcode')) {
	function cta_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color' => '',
				'orient' => '',
				'fullwidth' => 'no',
				'title' => 'Title',
				'subtitle' => '',
				'btn_txt' => 'Click Here',
				'btn_url' => '',
			  'btn_class' => '',
			  'custom_bg_url' => '',
			   
		), $atts));

		$cta_txt = '';
		$cta_btn = '';
		$cta_bg  = '';

		if($orient != 'ver' && $fullwidth != 'yes') {
			$cta_txt = 'col-sm-8 col-md-9';
			$cta_btn = 'col-sm-4 col-md-3';
		}

		if($fullwidth == 'yes') {
			$fullwidth = 'cta__fullwidth';
		}

		if($custom_bg_url != '') {
			$cta_bg = 'style="background-image:url('.$custom_bg_url.');"';
		}

	    
		$output =  '<div class="parallax-bg cta cta__'.$color.' cta__'.$orient.' '.$fullwidth.'" '.$cta_bg.'>';
			$output .= '<div class="cta-outer">';
				$output .= '<div class="cta-inner">';
					$output .= '<div class="cta-txt-wrap '.$cta_txt.'">';
						$output .= '<div class="cta-txt">';
							$output .= $title;
						$output .= '</div>';
						$output .= '<div class="cta-subtitle">';
							$output .= $subtitle;
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="cta-btn '.$cta_btn.'">';
						$output .= '<a href="'.$btn_url.'" class="btn btn-'.$btn_class.'">';
							$output .= $btn_txt;
						$output .= '</a>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('cta', 'cta_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('grid_column')) {
	function grid_column($atts, $content=null, $shortcodename ="")
	{	
		extract(shortcode_atts(array(
			'class' => ''
		), $atts));

		// add divs to the content
		$return = '<div class="'.$shortcodename.' '.$class.'">';
		$return .= do_shortcode($content);
		$return .= '</div>';

		return $return;
	}
	add_shortcode('col-md-1', 'grid_column');
	add_shortcode('col-md-2', 'grid_column');
	add_shortcode('col-md-3', 'grid_column');
	add_shortcode('col-md-4', 'grid_column');
	add_shortcode('col-md-5', 'grid_column');
	add_shortcode('col-md-6', 'grid_column');
	add_shortcode('col-md-7', 'grid_column');
	add_shortcode('col-md-8', 'grid_column');
	add_shortcode('col-md-9', 'grid_column');
	add_shortcode('col-md-10', 'grid_column');
	add_shortcode('col-md-11', 'grid_column');
	add_shortcode('col-md-12', 'grid_column');
}

// Row
if (!function_exists('shortcode_row')) {
	function shortcode_row($atts, $content = null ) {
		return '<div class="row">'.do_shortcode($content).'</div>';
	}

	add_shortcode('row', 'shortcode_row');
}

if (!function_exists('shortcode_row_inner')) {
	function shortcode_row_inner($atts, $content = null ) {
		return '<div class="row">'.do_shortcode($content).'</div>';
	}

	add_shortcode('row_inner', 'shortcode_row_inner');
}

// Clear
if (!function_exists('shortcode_clear')) {
	function shortcode_clear() {
		return '<div class="clear"></div>';
	}

	add_shortcode('clear', 'shortcode_clear');
}





/*-----------------------------------------------------------------------------------*/
/*	Font Awesome Shortcodes
/*-----------------------------------------------------------------------------------*/
function dfFontAwesome($atts) {
	extract(shortcode_atts(array(
		'type'  => '',
		'size' => '',
		'class' => '',

	), $atts));

	$classes  = ($type) ? $type. ' ' : 'fa-star';
	$classes .= ($size) ? $size.' ' : '';
	$classes .= ($class) ? ' '.$class : '';

	$theAwesomeFont = '<i class="fa '.esc_html($classes).'"></i>';

	return $theAwesomeFont;
}
  
add_shortcode('icon', 'dfFontAwesome');





/*-----------------------------------------------------------------------------------*/
/*	Icobox
/*-----------------------------------------------------------------------------------*/
if (!function_exists('icobox_shortcode')) {
	function icobox_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color' => '',
				'icon' => '',
				'title' => '',
				'url' => '',
				'desc' => '',
				'btn_txt' => ''
	   ), $atts));
	    
		$output =  '<div class="icobox icobox__'.$color.'">';
			$output .= '<div class="icobox-holder">';
				$output .= '<i class="fa '.$icon.'"></i>';
			$output .= '</div>';
			$output .= '<div class="icobox-desc">';
				$output .= '<div class="icobox-desc-inner1">';
					$output .= '<div class="icobox-desc-inner2">';
						if($title != '') {
							$output .= '<h3>';
								$output .= $title;
							$output .= '</h3>';
						}
						$output .= '<p>';
							$output .= $desc;
						$output .= '</p>';
						if($btn_txt != '') {
							$output .= '<div class="text-right">';
								$output .= '<a href="'.$url.'" class="link-arrow">'.$btn_txt.' <i class="fa fa-arrow-circle-o-right"></i></a>';
							$output .= '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

	   return $output;

	}
	add_shortcode('icobox', 'icobox_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	List Group
/*-----------------------------------------------------------------------------------*/

if (!function_exists('listgroup_shortcode')) {
	function listgroup_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'color' => '',
				'size' => '',
				'align' => ''
		), $atts));

		$output = '<ul class="list-group list-group__color-'.$color.' list-group__'.$size.' list-group__'.$align.'">';
		$output .= do_shortcode($content);
		$output .= '</ul>';

		return $output;
	}
	add_shortcode('lgroup', 'listgroup_shortcode');
}

if (!function_exists('listitem_shortcode')) {
	function listitem_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'icon' => '',
				'title' => ''
		), $atts));

		$output = '<li class="list-group-item">';
			$output .= '<span class="icon">';
				$output .= '<i class="fa '.$icon.'"></i>';
			$output .= '</span>';
			if($title != '') {
				$output .= '<h4 class="bold">'.$title.'</h4>';
			}
			$output .= '<div class="list-desc">';
				$output .= do_shortcode($content);
			$output .= '</div>';
		$output .= '</li>';

		return $output;

	}
	add_shortcode('litem', 'listitem_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Partners
/*-----------------------------------------------------------------------------------*/

if (!function_exists('partners_shortcode')) {
	function partners_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'cols' => ''
		), $atts));

		//Create unique ID for this carousel
		$unique_id = rand();

		$output = '<ul class="partners-list partners-list__cols'.$cols.'">';
			$output .= do_shortcode($content);
		$output .= '</ul>';

		return $output;
	}
	add_shortcode('partners', 'partners_shortcode');
}


if (!function_exists('img_item_shortcode')) {
	function img_item_shortcode($atts, $content = null) {

		$output = '<li>';
			$output .= do_shortcode($content);
		$output .= '</li>';

		return $output;
	}
	add_shortcode('img_item', 'img_item_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Carousel
/*-----------------------------------------------------------------------------------*/

if (!function_exists('carousel_shortcode')) {
	function carousel_shortcode($atts, $content = null) {
			
			extract(shortcode_atts(array(
				'post_type' => 'post',
				'visible_items' => '4',							 
				'num' => '4',
				'arrow_pos' => 'Right Top'
			), $atts));


			$unique_id = rand();
			$thumb_size = 'portfolio-lg';

			if($arrow_pos == 'outside_left') {
				$arrow_pos = 'outside_left';
			}

			$output = '<div class="prev-next-holder pull-right hidden-xs '.$arrow_pos.'">';
				$output .= '<a class="prev-btn" id="carousel-random-'.$unique_id.'-prev"><i class="fa fa-angle-left"></i></a>';
				$output .= '<a class="next-btn" id="carousel-random-'.$unique_id.'-next"><i class="fa fa-angle-right"></i></a>';
			$output .= '</div>';

			$output .= '<div class="owl-holder"><div id="carousel-random-'.$unique_id.'" class="owl-carousel gallery-list">';

			global $post;
			
			$args = array(
				'post_type' => $post_type,
				'numberposts' => $num,
				'orderby' => 'date',
				'order' => 'DESC',
				'suppress_filters' => 0
			);

			$latest = get_posts($args);
			
			foreach($latest as $k => $post) {
				// Unset not translated posts
				if ( function_exists( 'wpml_get_language_information' ) ) {
					global $sitepress;
					$check = wpml_get_language_information( $post->ID );
					$language_code = substr( $check['locale'], 0, 2 );
					if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$k] );

					// Post ID is different in a second language Solution
					if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, $type, true ) );
					}

					setup_postdata($post);

					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio-lg');

					$output .= '<div class="item gallery-item">';

						if ( has_post_thumbnail($post->ID) ){
							$output .= '<figure class="gallery-thumb">';
								$output .= '<div class="gallery-thumb-inner">';
									$output .= get_the_post_thumbnail($post->ID, $thumb_size);
									$output .= '<span class="thumbnail-caption-inner">';
										$output .= '<a href="'.$img_url.'" class="fa fa-search fa-2x magnific-img"></a>';
										$output .= '<a href="'.get_permalink($post->ID).'" class="fa fa-external-link fa-2x"></a>';
									$output .= '</span>';
									$output .= '<div class="gallery-caption">';
										$output .= '<h3>';
											$output .= '<span class="gallery-caption-inner">';
												$output .= get_the_title($post->ID);
											$output .= '</span>';
										$output .= '</h3>';
										$output .= '<span class="date">';
											$output .= get_the_time(get_option('date_format'));
										$output .= '</span>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</figure>';

						} else {
							$output .= '<figure class="gallery-thumb">';
								$output .= '<div class="gallery-thumb-inner">';
									$output .= '<img src="'.get_template_directory_uri().'/images/empty-square.jpg" alt="" class="empty-thumb">';
									$output .= '<span class="thumbnail-caption-inner">';
										$output .= '<a href="'.get_permalink($post->ID).'" class="fa fa-external-link fa-2x"></a>';
									$output .= '</span>';
									$output .= '<div class="gallery-caption">';
										$output .= '<h3>';
											$output .= '<span class="gallery-caption-inner">';
												$output .= get_the_title($post->ID);
											$output .= '</span>';
										$output .= '</h3>';
										$output .= '<span class="date">';
											$output .= get_the_time(get_option('date_format'));
										$output .= '</span>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</figure>';
						}
					
					$output .= '</div>';
					
			}
					
			$output .= '</div></div>';

			$output .= '<script>
			jQuery(document).ready(function() {
				jQuery("#carousel-random-'.$unique_id.'").owlCarousel({
					items : '.$visible_items.',
					itemsDesktop : [1000,'.$visible_items.'],
					itemsDesktopSmall : [900,2],
					itemsTablet: [600,2],
					itemsMobile : [480,1],
					pagination : false
				});

				jQuery("#carousel-random-'.$unique_id.'-next").click(function(){
					jQuery("#carousel-random-'.$unique_id.'").trigger("owl.next");
				});
				jQuery("#carousel-random-'.$unique_id.'-prev").click(function(){
					jQuery("#carousel-random-'.$unique_id.'").trigger("owl.prev");
				});
			});';
			$output .= '</script>';

			return $output;
			
	}

	add_shortcode('carousel', 'carousel_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Portfolio
/*-----------------------------------------------------------------------------------*/

if (!function_exists('shortcode_portfolio')) {
	function shortcode_portfolio($atts, $content = null) {
			
			extract(shortcode_atts(array(
					'cat_slug' => '',
					'cols' => '4',							 
					'num' => '4'
			), $atts));


			$thumb_size = '';

			if($cols == 2) {
				$cols = "gallery-list__2cols";
				$thumb_size = "portfolio-lg";
			} elseif($cols == 4) {
				$cols = "gallery-list__4cols";
				$thumb_size = "portfolio-n";
			} else{
				$cols = "gallery-list__3cols";
				$thumb_size = "portfolio-n";
			}

			$output = '<ul class="gallery-list js__gallery-list '.$cols.'">';

			global $post;
			
			$args = array(
				'post_type' => 'portfolio',
				'numberposts' => $num,
				'orderby' => 'date',
				'portfolio_category' => $cat_slug,
				'order' => 'DESC',
				'suppress_filters' => 0
			);

			$latest = get_posts($args);
			
			foreach($latest as $k => $post) {
				// Unset not translated posts
				if ( function_exists( 'wpml_get_language_information' ) ) {
					global $sitepress;
					$check = wpml_get_language_information( $post->ID );
					$language_code = substr( $check['locale'], 0, 2 );
					if ( $language_code != $sitepress->get_current_language() ) unset( $latest[$k] );

					// Post ID is different in a second language Solution
					if ( function_exists( 'icl_object_id' ) ) $post = get_post( icl_object_id( $post->ID, $type, true ) );
					}

					setup_postdata($post);

					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
					$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $thumb_size);

					$output .= '<li class="gallery-item">';

						if ( has_post_thumbnail($post->ID) ){
							$output .= '<figure class="gallery-thumb">';
								$output .= '<div class="gallery-thumb-inner">';
									$output .= get_the_post_thumbnail($post->ID, $thumb_size);
									$output .= '<span class="thumbnail-caption-inner">';
										$output .= '<a href="'.$img_url.'" class="fa fa-search fa-2x magnific-img"></a>';
										$output .= '<a href="'.get_permalink($post->ID).'" class="fa fa-external-link fa-2x"></a>';
									$output .= '</span>';
									$output .= '<div class="gallery-caption">';
										$output .= '<h3>';
											$output .= '<span class="gallery-caption-inner">';
												$output .= get_the_title($post->ID);
											$output .= '</span>';
										$output .= '</h3>';
										$output .= '<span class="date">';
											$output .= get_the_time(get_option('date_format'));
										$output .= '</span>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</figure>';
						}
					
				$output .= '</li>';
					
			}
					
			$output .= '</ul>';
			return $output;
			
	}

	add_shortcode('portfolio', 'shortcode_portfolio');
}





/*-----------------------------------------------------------------------------------*/
/*	Pricing Tables
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pricing_shortcode')) {
	function pricing_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'name' => '',
				'price' => '$ 0',
				'link_txt' => 'Sign Up',
				'link_url' => '#',
				'active' => '',
				'type' => ''
		), $atts));

		$btn_class = '';

		if($active == "yes") {
			$active = "featured";
		}

		if($type == 'style1') {
			$type = 'default';
			if($active == 'featured') {
				$btn_class = 'btn-primary';
			} else {
				$btn_class = 'btn-default';
			}
		} elseif ($type == 'style2') {
			$type = 'alt';
			if($active == 'featured') {
				$btn_class = 'btn-primary';
			} else {
				$btn_class = 'btn-default';
			}
		}

		$output = '<div class="pricing-table pricing-table__'.$type.' pricing-table__'.$active.'">';
			$output .= '<header class="pricing-table-header">';
				$output .= '<div class="price">'.$price.'</div>';
				$output .= '<div class="plan">'.$name.'</div>';
			$output .= '</header>';

			$output .= '<div class="pricing-table-content">';
				$output .= do_shortcode($content);
			$output .= '</div>';

			$output .= '<footer class="pricing-table-footer">';

				$output .= '<a class="btn '.$btn_class.'" href="'.$link_url.'">';
					$output .= $link_txt;
				$output .= '</a>';
				
			$output .= '</footer>';
		$output .= '</div>';

		return $output;

	}
	add_shortcode('pricing_table', 'pricing_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Data Table
/*-----------------------------------------------------------------------------------*/
function simple_table( $atts ) {
	extract( shortcode_atts( array(
		'class' => '',
		'cols' => '',
		'data' => '',
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<div class="table-responsive"><table class="table '.$class.'"><thead><tr>';
    foreach($cols as $col):
        $output .= '<td>'.$col.'</td>';
    endforeach;
    $output .= '</tr></thead><tbody><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= '<td>'.$datum.'</td>';
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
        $output .= '</tbody></table></div>';
    return $output;
}
add_shortcode( 'table', 'simple_table' );






/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/

if (!function_exists('bar_shortcode')) {
	function bar_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'progress' => '30',
				'type' => '',
				'label' => '',
				'color' => ''
		), $atts));

		if($type == 'striped') {
			$type = 'progress-striped';
		} elseif($type == 'animated') {
			$type = 'progress-striped active';
		}

		$output = '<div class="progress '.$type.'">';
			$output .= '<div class="progress-bar progress-bar-'.$color.'" role="progressbar" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$progress.'%;">';
				$output .= '<span class="progress-title">'.$label.'</span>';
				$output .= '<span class="progress-counter">'.$progress.'%</span>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('progress', 'bar_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Team member
/*-----------------------------------------------------------------------------------*/
if (!function_exists('member_shortcode')) {
	function member_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'name' => '',
				'img_url' => '',
				'position' => '',
				'facebook' => '',
				'twitter' => '',
				'linkedin' => '',
				'google' => ''
		), $atts));

		$output = '<div class="team-member">';
			$output .= '<div class="clearfix">';
				$output .= '<figure class="team-member-thumbnail">';

					if($img_url != '' ) {
						$output .= '<img src="'.$img_url.'" alt="" class="img-responsive">';
					} else {
						$output .= '<img src="'.get_template_directory_uri().'/images/empty.jpg" alt="" class="empty-thumb">';
					}
				$output .= '</figure>';

				$output .= '<div class="team-member-wrapper">';
					$output .= '<header class="team-member-header">';
						$output .= '<h3 class="team-member-name">'.$name.'</h3>';
						$output .= '<span class="team-member-info">'.$position.'</span>';
					$output .= '</header>';
					$output .= '<div class="team-member-desc">';
						$output .= do_shortcode($content);
					$output .= '</div>';
					$output .= '<footer class="team-member-footer">';
						$output .= '<ul class="social-list social-list__footer list-unstyled">';
							if($facebook != '') {
								$output .= '<li>';
									$output .= '<a href="'.$facebook.'" class="fa fa-facebook"></a>';
								$output .= '</li>';
							}
							if($twitter != '') {
								$output .= '<li>';
									$output .= '<a href="'.$twitter.'" class="fa fa-twitter"></a>';
								$output .= '</li>';
							}
							if($linkedin != '') {
								$output .= '<li>';
									$output .= '<a href="'.$linkedin.'" class="fa fa-linkedin"></a>';
								$output .= '</li>';
							}
							if($google != '') {
								$output .= '<li>';
									$output .= '<a href="'.$google.'" class="fa fa-google-plus"></a>';
								$output .= '</li>';
							}
						$output .= '</ul>';
					$output .= '</footer>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('member', 'member_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Testimonial Style 1
/*-----------------------------------------------------------------------------------*/
if (!function_exists('testi_shortcode1')) {
	function testi_shortcode1($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'img_url' => '',
				'name' => '',
				'info' => '',
				'text' => ''
	   ), $atts));
	    
		$output =  '<div class="testimonial testimonial__style1">';
			$output .= '<figure class="testimonial-thumb">';
				$output .= '<img src="'.$img_url.'" alt="">';
			$output .= '</figure>';
			$output .= '<h3 class="name">';
				$output .= $name;
			$output .= '</h3>';
			$output .= '<span class="info">';
				$output .= $info;
			$output .= '</span>';
			$output .= '<div class="clearfix"></div>';
			$output .= '<div class="testimonial-txt">';
				$output .= '<div class="testimonial-txt-inner1">';
					$output .= '<div class="testimonial-txt-inner2">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('testi1', 'testi_shortcode1');
}



/*-----------------------------------------------------------------------------------*/
/*	Testimonial Style 2
/*-----------------------------------------------------------------------------------*/
if (!function_exists('testi_shortcode2')) {
	function testi_shortcode2($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'name' => '',
				'info' => '',
				'text' => ''
	   ), $atts));
	    
		$output =  '<div class="testimonial testimonial__style2">';
			$output .= '<div class="testimonial-txt">';
				$output .= do_shortcode($content);
			$output .= '</div>';
			$output .= '<div class="testimonial-info">';
				$output .= '<h4 class="name">';
					$output .= $name;
				$output .= '</h4>';
				$output .= '<span class="info">';
					$output .= $info;
				$output .= '</span>';
			$output .= '</div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('testi2', 'testi_shortcode2');
}



/*-----------------------------------------------------------------------------------*/
/*	Testimonial Style 3
/*-----------------------------------------------------------------------------------*/
if (!function_exists('testi_shortcode3')) {
	function testi_shortcode3($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'name' => '',
				'info' => '',
				'text' => ''
	   ), $atts));
	    
		$output =  '<div class="testimonial testimonial__style3">';
			$output .= '<div class="testimonial-txt">';
				$output .= do_shortcode($content);
			$output .= '</div>';
			$output .= '<div class="testimonial-info">';
				$output .= '<h4 class="name">';
					$output .= $name;
				$output .= '</h4>';
				$output .= '<span class="info">';
					$output .= $info;
				$output .= '</span>';
			$output .= '</div>';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('testi3', 'testi_shortcode3');
}




/*-----------------------------------------------------------------------------------*/
/*	Counter
/*-----------------------------------------------------------------------------------*/
if (!function_exists('counter')) {
	function counter($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'type' => 'default',
				'num' => '100'
	   ), $atts));

		if($type == 'boxed') {
			$output =  '<div class="counter-holder counter-type__boxed clearfix">';
				$output .= '<div class="counter-info"><div class="counter-info-inner">';
					$output .= do_shortcode($content);
				$output .= '</div></div>';
				$output .= '<span class="counter-wrap">';
					$output .= '<span class="counter" data-to="'.$num.'">0</span>';
				$output .= '</span>';
			$output .= '</div>';
		} else {
			$output =  '<div class="counter-holder counter-type__default clearfix">';
				$output .= '<span class="counter-wrap">';
					$output .= '<span class="counter" data-to="'.$num.'">0</span>';
				$output .= '</span>';
				$output .= '<div class="counter-info"><div class="counter-info-inner">';
					$output .= do_shortcode($content);
				$output .= '</div></div>';
			$output .= '</div>';
		}

	  return $output;

	}
	add_shortcode('counter', 'counter');
}


/*-----------------------------------------------------------------------------------*/
/*	Circled Counter
/*-----------------------------------------------------------------------------------*/
if (!function_exists('circle_counter')) {
	function circle_counter($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'dimension' => '190',
				'text'      => '32%',
				'info'      => 'Your info',
				'width'     => '30',
				'fontsize'  => '28',
				'percent'   => '32',
				'fgcolor'   => '#13aad3',
				'bgcolor'   => '#eee',
				'icon'      => 'fa-task'
	   ), $atts));

		$unique_id = rand();

		$output =  '<div id="circled-counter__'.$unique_id.'" class="circled-counter" ';
			$output .= 'data-dimension="'.$dimension.'" ';
			$output .= 'data-text="'.$text.'" ';
			$output .= 'data-info="'.$info.'" ';
			$output .= 'data-width="'.$width.'" ';
			$output .= 'data-fontsize="'.$fontsize.'" ';
			$output .= 'data-percent="'.$percent.'" ';
			$output .= 'data-fgcolor="'.$fgcolor.'" ';
			$output .= 'data-bgcolor="'.$bgcolor.'" ';
			$output .= 'data-icon="'.$icon.'">';
		$output .= '</div>';

	  return $output;

	}
	add_shortcode('circle_counter', 'circle_counter');
}





/*-----------------------------------------------------------------------------------*/
/*	Testimonial
/*-----------------------------------------------------------------------------------*/
if (!function_exists('testi_shortcode')) {
	function testi_shortcode($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'color' => '',
				'name' => '',
			   'info' => '',
			   'text' => ''
	   ), $atts));
	    
		$output =  '<div class="testimonial testimonial-color__'.$color.'">';
			$output .= '<div class="testi-body">';
				$output .= '<blockquote>';
					$output .= do_shortcode($content);
				$output .= '</blockquote>';
			$output .= '</div>';
			$output .= '<div class="testi-author">';
				$output .= '<div class="testi-author-inner">';
					$output .= '<h5 class="name">';
						$output .= $name;
					$output .= '</h5>';
					$output .= '<span class="info">';
						$output .= $info;
					$output .= '</span>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

	   return $output;

	}
	add_shortcode('testimonial', 'testi_shortcode');
}






/*-----------------------------------------------------------------------------------*/
/*	Horizontal Rules
/*-----------------------------------------------------------------------------------*/

if (!function_exists('hr_shortcode')) {
	function hr_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => 'solid'
	    ), $atts));

		return '<hr class="hr-'.$type.'">';
		
	}
	add_shortcode('hr', 'hr_shortcode');
}




/*-----------------------------------------------------------------------------------*/
/*	Spacer
/*-----------------------------------------------------------------------------------*/

if (!function_exists('spacer_shortcode')) {
	function spacer_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
			'size'   => 'default',
			'class'   => ''
	    ), $atts));

		$output = '<div class="spacer spacer-'.$size.' '.$class.'"></div>';
		return $output;
	}
	add_shortcode('spacer', 'spacer_shortcode');
}





/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

$tabs_divs = '';

function tabs_group($atts, $content = null ) {
    global $tabs_divs;

    extract(shortcode_atts(array(  
        'type' => '',
        'orientation' => ''
    ), $atts));

    $tabs_divs = '';

    $output = '<div class="tabs-wrapper tabs__'.$orientation.' tabs-'.$type.'"><ul class="nav nav-tabs">';
    $output.= do_shortcode($content);
    $output.= '</ul><div class="tab-content">'.$tabs_divs.'</div></div>';

    return $output;  
} 
add_shortcode('tab', 'tab');

function tab($atts, $content = null) {  
    global $tabs_divs;

    extract(shortcode_atts(array(  
        'id' => '',
        'title' => '',
        'state' => '' 
    ), $atts));  

    if(empty($id)) {
        $id = 'side-tab'.rand(100,999);
    }

    $state_link = '';
    if($state == 'open') {
    	$state = 'in active';
    	$state_link = 'active';
    }

    $output = '
        <li class="'.$state_link.'">
            <a href="#'.$id.'" data-toggle="tab">'.$title.'</a>
        </li>
    ';

    $tabs_divs.= '<div id="'.$id.'" class="tab-pane fade '.$state.'">'.$content.'</div>';

    return $output;
}
add_shortcode('tabs', 'tabs_group');







/*-----------------------------------------------------------------------------------*/
/*	Typograpy
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	List Styles
/*-----------------------------------------------------------------------------------*/

if (!function_exists('list_shortcode')) {
	function list_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type'   => '',
			'color'   => ''
	    ), $atts));

		return '<div class="list list-'.$type.' list-color-'.$color.'">' . do_shortcode($content) . '</div>';
	  
	}
	add_shortcode('list', 'list_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Dropcaps
/*-----------------------------------------------------------------------------------*/

if (!function_exists('dropcap_shortcode')) {
	function dropcap_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => ''
		), $atts));

		$output = '<span class="dropcap dropcap__'.$type.'">';
		$output .= do_shortcode($content);
		$output .= '</span>';

		return $output;
	}
	add_shortcode('dropcap', 'dropcap_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Blockquote
/*-----------------------------------------------------------------------------------*/

if (!function_exists('blockquote_shortcode')) {
	function blockquote_shortcode($atts, $content = null) {

		$output = '<blockquote>';
		$output .= do_shortcode($content);
		$output .= '</blockquote><!-- blockquote (end) -->';

		return $output;
	}
	add_shortcode('blockquote', 'blockquote_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Pullquote
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pullquote_shortcode')) {
	function pullquote_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'align' => 'left'
		), $atts));

		$output = '<div class="pullquote '.$align.'">';
			$output .= '<blockquote>';
			$output .= do_shortcode($content);
			$output .= '</blockquote>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('pullquote', 'pullquote_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Title
/*-----------------------------------------------------------------------------------*/
if (!function_exists('title_shortcode')) {
	function title_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'style' => ''
		), $atts));

		if($style == 'decorated') {
			$style = 'title-decorated';
		} elseif ($style == 'bordered') {
			$style = 'title-bordered';
		} else {
			$style = 'title';
		}

		$output = '<div class="'.$style.'">';
			$output .= '<div class="title-inner">';
				$output .= '<h2>';
					$output .= do_shortcode($content);
				$output .= '</h2>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('title', 'title_shortcode');
}



/*-----------------------------------------------------------------------------------*/
/*	Box
/*-----------------------------------------------------------------------------------*/
if (!function_exists('box_shortcode')) {
	function box_shortcode($atts, $content = null) {

		$output = '<div class="well">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}

	add_shortcode('box', 'box_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Section
/*-----------------------------------------------------------------------------------*/
if (!function_exists('section_shortcode')) {
	function section_shortcode($atts, $content = null) {

		$output = '<div class="fullwidth-wrapper">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}

	add_shortcode('section', 'section_shortcode');
}

/*-----------------------------------------------------------------------------------*/
/*	CTA Full Width Section
/*-----------------------------------------------------------------------------------*/
if (!function_exists('cta_section_shortcode')) {
	function cta_section_shortcode($atts, $content = null) {

		$output = '<div class="cta cta__fullw">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
	}

	add_shortcode('cta_block', 'cta_section_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Video in Monitor
/*-----------------------------------------------------------------------------------*/
if (!function_exists('video_holder_shortcode')) {
	function video_holder_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'url' => ''
		), $atts));

		$vimeo = strpos($url, "vimeo");
		$youtube = strpos($url, "youtube");


		$output = '<div class="video-holder">';
			$output .= '<div class="screen">';
				$output .= '<div class="screen-inner">';

				if($vimeo !== false){

					//Get ID from video url
					$video_id = str_replace( 'http://vimeo.com/', '', $url );
					$video_id = str_replace( 'http://www.vimeo.com/', '', $video_id );

					//Display Vimeo video
					$output .= '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="640" height="360" frameborder="0"></iframe>';

				} elseif($youtube !== false){

					//Get ID from video url
					$video_id = str_replace( 'https://youtube.com/watch?v=', '', $url );
					$video_id = str_replace( 'https://www.youtube.com/watch?v=', '', $video_id );
					$video_id = str_replace( '&feature=channel', '', $video_id );

					$output .= '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0"></iframe>';
				}

				$output .= '</div>';
			$output .= '</div>';
			$output .= '<div class="stand">';
				$output .= '<div class="stand-center">';
					$output .= '<div class="stand-shadow-left-helper"></div>';
						$output .= '<div class="stand-shadow"></div>';
					$output .= '<div class="stand-shadow-right-helper"></div>';
				$output .= '</div>';
				$output .= '<div class="stand-bottom"></div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('video_in_monitor', 'video_holder_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Video in iPad
/*-----------------------------------------------------------------------------------*/
if (!function_exists('ipad_video_holder_shortcode')) {
	function ipad_video_holder_shortcode($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'url' => ''
		), $atts));

		$vimeo = strpos($url, "vimeo");
		$youtube = strpos($url, "youtube");


		$output = '<div class="ipad-video-holder">';
			$output .= '<div class="screen">';
				$output .= '<div class="screen-inner">';

				if($vimeo !== false){

					//Get ID from video url
					$video_id = str_replace( 'http://vimeo.com/', '', $url );
					$video_id = str_replace( 'http://www.vimeo.com/', '', $video_id );

					//Display Vimeo video
					$output .= '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="640" height="360" frameborder="0"></iframe>';

				} elseif($youtube !== false){

					//Get ID from video url
					$video_id = str_replace( 'https://youtube.com/watch?v=', '', $url );
					$video_id = str_replace( 'https://www.youtube.com/watch?v=', '', $video_id );
					$video_id = str_replace( '&feature=channel', '', $video_id );

					$output .= '<iframe title="YouTube video player" class="youtube-player" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'.$video_id.'" frameborder="0"></iframe>';
				}

				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('video_in_ipad', 'ipad_video_holder_shortcode');
}


/*-----------------------------------------------------------------------------------*/
/*	Image Raw
/*-----------------------------------------------------------------------------------*/

if (!function_exists('image_raw')) {
	function image_raw( $atts, $content = null ) {

	   return '<div class="img-raw">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('img_raw', 'image_raw');
}
?>