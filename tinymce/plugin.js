(function($) {
"use strict";
			
	//Shortcodes
   tinymce.PluginManager.add( 'zillaShortcodes', function( editor, url ) {
	
	editor.addCommand("zillaPopup", function ( a, params )
	{
		var popup = params.identifier;
		tb_show("Insert DF Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
	});

		editor.addButton( 'zilla_button', {
			type: 'splitbutton',
			icon: false,
			title:  'DF Shortcodes',
			onclick : function(e) {},
			menu: [
				{text: 'Animation',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Animation',identifier: 'animate'})
				}},
				{text: 'Alerts',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Alerts',identifier: 'alert'})
				}},
				{text: 'Columns',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Columns',identifier: 'columns'})
				}},
				{text: 'Columns Inner',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Columns Inner',identifier: 'columns_inner'})
				}},
				{
					text: 'Elements',
					menu: [
						{text: 'Accordion',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Accordion',identifier: 'accordion'})
						}},
						{text: 'Buttons',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Buttons',identifier: 'button'})
						}},
						{text: 'Call to Action',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Call to Action',identifier: 'cta'})
						}},
						{text: 'Counter',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Counter',identifier: 'counter'})
						}},
						{text: 'Circled Counter',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Circled Counter',identifier: 'circle_counter'})
						}},
						{text: 'Tabs',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Tabs',identifier: 'tabs'})
						}},
						{text: 'Partners',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Partners',identifier: 'partners'})
						}},
						{text: 'Pricing Table',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Pricing Table',identifier: 'pricing_table'})
						}},
						{text: 'Progress Bar',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Progress Bar',identifier: 'progress'})
						}},
						{text: 'Table',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Table',identifier: 'table'})
						}},
						{text: 'Team Member',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Team Member',identifier: 'member'})
						}},
					]
				},
				{
					text: 'Testimonials',
					menu: [
						{text: 'Testimonial Style 1',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Testimonial Style 1',identifier: 'testi1'})
						}},
						{text: 'Testimonial Style 2',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Testimonial Style 2',identifier: 'testi2'})
						}},
						{text: 'Testimonial Style 3',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Testimonial Style 3',identifier: 'testi3'})
						}},
					]
				},
				{text: 'Icobox',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Icobox',identifier: 'icobox'})
				}},
				{text: 'List Group',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'List Group',identifier: 'lgroup'})
				}},
				{
					text: 'Posts',
					menu: [
						{text: 'Carousel',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Carousel',identifier: 'carousel'})
						}},
						{text: 'Portfolio',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Portfolio',identifier: 'portfolio'})
						}},
						{text: 'Recent Posts',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Recent Posts',identifier: 'recent_posts'})
						}},
					]
				},
				{
					text: 'Typography',
					menu: [
						{text: 'Box',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Box',identifier: 'box'})
						}},
						{text: 'Dropcaps',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Dropcaps',identifier: 'dropcap'})
						}},
						{text: 'Horizontal Rules',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Horizontal Rules',identifier: 'hr'})
						}},
						{text: 'Icon',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Icon',identifier: 'icon'})
						}},
						{text: 'Image Raw',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Image Raw',identifier: 'img_raw'})
						}},
						{text: 'Lists',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Lists',identifier: 'list'})
						}},
						{text: 'Pullquote',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Pullquote',identifier: 'pullquote'})
						}},
						{text: 'Section',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Section',identifier: 'section'})
						}},
						{text: 'Spacers',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Spacers',identifier: 'spacer'})
						}},
						{text: 'Title',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Title',identifier: 'title'})
						}},
					]
				},
				{
					text: 'Video',
					menu: [
						{text: 'Video in Monitor',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Video in Monitor',identifier: 'video_in_monitor'})
						}},
						{text: 'Video in iPad',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Video in iPad',identifier: 'video_in_ipad'})
						}}
					]
				},
			]
	});

 });
         

 
})(jQuery);
