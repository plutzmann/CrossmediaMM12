<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		$of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
		//Testing 
		$of_layout_select 	= array("fullwidth" => "Fullwidth","boxed" => "Boxed Layout");
                $of_options_bg_repeat   = array("stretch" => "Strech Image","fixed" => "Fixed Image","repeat" => "repeat","no-repeat" => "no-repeat","repeat-y" => "repeat-y","repeat-x" => "repeat-x");
		//Sample Homepage blocks for the layout manager (sorter)

		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options,$tw_googlefonts;
$of_options = array();

/*      ThemeWaves custom admin section started     */
//      General TAB
$of_options[] = array( 	"name" 		=> "General",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "general.png"
				);
$of_options[] = array( 	"name" 		=> "General",
						"desc" 		=> "",
						"id" 		=> "general_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">General Options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Page builder ?",
						"desc" 		=> "This will enable, disable PageBuilder.",
						"id" 		=> "pagebuilder",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Smooth Scroll ?",
						"desc" 		=> "This will enable, disable SmoothScroll.",
						"id" 		=> "smooth_scroll",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Page loader ?",
						"desc" 		=> "This will enable, disable Page loader.",
						"id" 		=> "pageloader",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Enable animations on mobile?",
						"desc" 		=> "If it's On then it will be enabled on mobile, Off will be disabled on mobile.",
						"id" 		=> "moblile_animation",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Breadcrumps?",
						"desc" 		=> "This will enable or disable Breadcrumps.",
						"id" 		=> "breadcrumps",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Page Title Background Image",
						"desc" 		=> "Inserted picture must be above 1600px width and height is atleast 120px. You can redefine or choose other option to your specific page on meta options.",
						"id" 		=> "title_bg_image",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Page Title & Sub Title color Dark?",
						"desc" 		=> "Inserted picture must be above 1600px width and height is atleast 120px. You can redefine or choose other option to your specific page on meta options.",
						"id" 		=> "title_bg_dark",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Portfolio additional heading",
						"desc" 		=> "",
						"id" 		=> "port_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Portfolios</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Portfolio Single type slug",
						"desc" 		=> "Portfolio Single type slug.",
						"id" 		=> "translate_portfolio",
						"std" 		=> "portfolio-single",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Portfolio single layout?",
						"desc" 		=> "",
						"id" 		=> "port_single_layout",
						"options" 	=> array('Style Full','Style Half'),
						"std" 		=> 'Style Half',
						"type" 		=> "select"
				);
$of_options[] = array( 	"name" 		=> "Hide related portfolios on single?",
						"desc" 		=> "",
						"id" 		=> "port_related",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Portfolio image height",
						"desc" 		=> "Related portfolios height and Default portfolio image height.",
						"id" 		=> "port_height",
						"std" 		=> "250",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Event additional heading",
						"desc" 		=> "",
						"id" 		=> "event_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Events</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Hide related events on single?",
						"desc" 		=> "",
						"id" 		=> "event_related",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Event height",
						"desc" 		=> "Related events height and Default events height.",
						"id" 		=> "event_height",
						"std" 		=> "300",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Sermon additional heading",
						"desc" 		=> "",
						"id" 		=> "sermon_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Sermons</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Hide related sermons on single?",
						"desc" 		=> "",
						"id" 		=> "sermon_related",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Sermon height",
						"desc" 		=> "Related sermons height and Default sermons height.",
						"id" 		=> "sermon_height",
						"std" 		=> "300",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Blog Additional heading",
						"desc" 		=> "",
						"id" 		=> "blog_add_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Blog</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Featured Media section on post single?",
						"desc" 		=> "If it's On then it will be showed, Off will be hidden.",
						"id" 		=> "feature_show",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Post Author section on post single?",
						"desc" 		=> "If it's On then it will be showed, Off will be hidden.",
						"id" 		=> "post_author",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Blog Page Title",
						"desc" 		=> "Insert Title of your Blog page.",
						"id" 		=> "blog_title",
						"std" 		=> "Blog",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Blog Page Subtitle",
						"desc" 		=> "Insert Sub Title of your Blog page.",
						"id" 		=> "blog_subtitle",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Portfolio Page Title",
						"desc" 		=> "Insert Title of your Portfolio single.",
						"id" 		=> "port_title",
						"std" 		=> "Portfolio",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Portfolio Page Subtitle",
						"desc" 		=> "Insert Sub Title of your Portfolio single.",
						"id" 		=> "port_subtitle",
						"std" 		=> "",
						"type" 		=> "text"
				);



//     Layout Options
$of_options[] = array( 	"name" 		=> "Layout Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
$of_options[] = array( 	"name" 		=> "Theme Layout",
						"desc" 		=> "Choose the Theme layout style.",
						"id" 		=> "theme_layout",
						"std" 		=> "fullwidth",
						"type" 		=> "select",
						"options" 	=> $of_layout_select
				);
$of_options[] = array( 	"name" 		=> "Layout Options if boxed",
						"desc" 		=> "",
						"id" 		=> "layout_opt_boxed_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">If boxed Theme Layout Style chosen.</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Background Color",
						"desc" 		=> "Choose the background color.",
						"id" 		=> "background_color",
						"std" 		=> "#f5f5f5",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Background Image",
						"desc" 		=> "This option will only works under boxed layout chosen.",
						"id" 		=> "background_image",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Background Image Repeat",
						"desc" 		=> "Choose the repeat or stretch image option.",
						"id" 		=> "background_repeat",
						"std" 		=> "repeat",
						"type" 		=> "select",
						"options" 	=> $of_options_bg_repeat
				);
$of_options[] = array( 	"name" 		=> "Margin from Top",
						"desc" 		=> "Boxed Layout margin top.",
						"id" 		=> "margin_top",
						"std" 		=> "60",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Margin from Bottom",
						"desc" 		=> "Boxed Layout margin bottom.",
						"id" 		=> "margin_bottom",
						"std" 		=> "60",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Category and Single Layout option",
						"desc" 		=> "",
						"id" 		=> "layout2_opt_boxed_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Category and Single Layout option</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Category page layout",
						"desc" 		=> "Choose the Category page layout style.",
						"id" 		=> "category_layout",
						"std" 		=> "right",
						"type" 		=> "select",
						"options" 	=> array('left'=>'Left sidebar', 'right'=>'Right sidebar', 'full'=>'Without sidebar')
				);
$of_options[] = array( 	"name" 		=> "Single post layout",
						"desc" 		=> "Choose the Single post layout style.",
						"id" 		=> "post_layout",
						"std" 		=> "right",
						"type" 		=> "select",
						"options" 	=> array('left'=>'Left sidebar', 'right'=>'Right sidebar', 'full'=>'Without sidebar')
				);
$of_options[] = array( 	"name" 		=> "Menu position option",
						"desc" 		=> "",
						"id" 		=> "layout3_opt_boxed_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Menu position option</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Menu Position",
						"desc" 		=> "Menu position",
						"id" 		=> "menu_position",
						"std" 		=> "fixed",
						"type" 		=> "select",
						"options" 	=> array('top'=>'Static Top', 'fixed'=>'Fixed Top'/*, 'left'=>"Left Sidebar", 'right'=>"Right Sidebar"*/)
				);

//      Header and Footer TAB
$of_options[] = array( 	"name" 		=> "Header and Footer",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "header-and-footer.png"
				);
$of_options[] = array( 	"name" 		=> "General Options",
						"desc" 		=> "",
						"id" 		=> "header_general",
						"std" 		=> "<h3 style=\"margin: 3px;\">General Options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Hide Menu?",
                        "desc" 		=> "IF it's ON menu hide.",
                        "id" 		=> "hide_menu",
                        "std" 		=> 0,
                        "type" 		=> "switch"
                );
$of_options[] = array( 	"name" 		=> "Header height",
						"desc" 		=> "Note: You need to insert only int value.",
						"id" 		=> "header_height",
						"std" 		=> "140",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Page Title Padding Top",
						"desc" 		=> "Note: You need to insert only int value.",
						"id" 		=> "pt_paddingtop",
						"std" 		=> "50",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Page Title Padding Bottom",
						"desc" 		=> "Note: You need to insert only int value.",
						"id" 		=> "pt_paddingbottom",
						"std" 		=> "50",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Logo option heading",
						"desc" 		=> "",
						"id" 		=> "logo_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Logo options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Upload Standard Logo",
						"desc" 		=> "Please insert your logo.",
						"id" 		=> "theme_logo",
						"std" 		=> "http://themes.themewaves.com/church/wp-content/uploads/sites/16/2014/09/logo.png",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Upload Light Logo",
						"desc" 		=> "If you chosen the Header Transparent (Header Color -> Light) on single page then it will be displayed",
						"id" 		=> "theme_logo_light",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Logo",
						"desc" 		=> "",
						"id" 		=> "logo_retina",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Upload Retina Logo (2x)",
						"desc" 		=> "Note: You retina logo must be larger than 2x. Example: Main logo 120x200 then Retina must be 240x400.",
						"id" 		=> "theme_logo_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "logo_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Standard Logo Width",
						"desc" 		=> "You need to insert Non retina logo width. Height auto",
						"id" 		=> "logo_width",
						"std" 		=> "",
						"fold" 		=> "logo_retina", /* the checkbox hook */
						"type" 		=> "text"
				);				
$of_options[] = array( 	"name" 		=> "Favicon option heading",
						"desc" 		=> "",
						"id" 		=> "favicon_opt_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Favicon options</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Upload Standard Favicon",
						"desc" 		=> "Please insert your favicon 16x16 icon. You may use <a href='http://www.favicon.cc/' target='_blank'>favicon.cc</a>",
						"id" 		=> "theme_favicon",
						"std" 		=> "",
						"mod" 		=> "min",
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon",
						"desc" 		=> "",
						"id" 		=> "favicon_retina",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Favicon for iPhone (57x57)",
						"desc" 		=> "Please upload your favicon 57x57.",
						"id" 		=> "favicon_iphone",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon for iPhone (114x114)",
						"desc" 		=> "Please upload your favicon 114x114.",
						"id" 		=> "favicon_iphone_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Favicon for iPad (72x72)",
						"desc" 		=> "Please upload your favicon 72x72.",
						"id" 		=> "favicon_ipad",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);
$of_options[] = array( 	"name" 		=> "Retina Favicon for iPad (144x144)",
						"desc" 		=> "Please upload your favicon 144x144.",
						"id" 		=> "favicon_ipad_retina",
						"std" 		=> "",
						"mod" 		=> "min",
                                                "fold" 		=> "favicon_retina", /* the checkbox hook */
						"type" 		=> "upload"
				);

$of_options[] = array( 	"name" 		=> "Footer section",
						"desc" 		=> "",
						"id" 		=> "footer_section_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Footer section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Footer Fixed",
						"desc" 		=> "",
						"id" 		=> "footer_fixed",
						"std" 		=> 0,
						"type" 		=> "switch"
                                );
$of_options[] = array( 	"name" 		=> "Footer Widget",
						"desc" 		=> "",
						"id" 		=> "footer_widget",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
                                );
$url =  ADMIN_DIR . 'assets/images/footer/';
$of_options[] = array( 	"name" 		=> "Footer Layout",
						"desc" 		=> "Choose footer layout.",
						"id" 		=> "footer_layout",
						"std" 		=> "3-3-3-3",
						"type" 		=> "images",
                                                "fold" 		=> "footer_widget", /* the checkbox hook */
						"options" 	=> array(
											'12' 	  => $url . '1.png',
											'6-6' 	  => $url . '2.png',
											'4-4-4'   => $url . '3.png',
											'3-3-3-3' => $url . '4.png'
										)
				);
$of_options[] = array( 	"name" 		=> "Footer text",
						"desc" 		=> "",
						"id" 		=> "footer_text",
						"std" 		=> 1,
						"folds" 	=> 1,
						"type" 		=> "switch"
                                );
$of_options[] = array( 	"name" 		=> "Copyright Text",
						"desc" 		=> "Insert Copyright Text.",
						"id" 		=> "copyright_text",
                                                "fold" 		=> "footer_text",
						"std" 		=> "© Copyright 2014 - <a href='http://themeforest.net/user/themewaves/portfolio' title='Wordpress is the Best!'>Responsive Multipurpose Retina </a><a href='http://wordpress.org/' title='Wordpress is the Best!'>WordPress</a> Theme by ThemeWaves.",
						"type" 		=> "textarea"
				);
//      Colors and Styling TAB
$of_options[] = array( 	"name" 		=> "Colors and Styling",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "color.png"
				);
$of_options[] = array( 	"name" 		=> "General",
						"desc" 		=> "",
						"id" 		=> "colors_and_styling_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">General</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Primary Color",
						"desc" 		=> "Theme Primary color has all of accent colors of this theme. Default: #6DAEB7",
						"id" 		=> "primary_color",
						"std" 		=> "#6DAEB7",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Header Colors",
						"desc" 		=> "",
						"id" 		=> "header_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Header</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Header Background Color",
						"desc" 		=> "Pick a background color for the header (default: #fff).",
                                                "id" 		=> "header_background",
						"std" 		=> "#fff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Page Title",
						"desc" 		=> "",
						"id" 		=> "page_title_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Page Title</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Page Title Background Color",
						"desc" 		=> "Pick a background color for the Page Title (default: #f5f5f5).",
						"id" 		=> "page_title_background",
						"std" 		=> "#f5f5f5",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Menu Colors Options",
						"desc" 		=> "",
						"id" 		=> "menu_colors_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Menu - Main Menu color is located in Typography Section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Menu Link Hover&Active Color",
						"desc" 		=> "Default: #6DAEB7",
						"id" 		=> "menu_hover",
						"std" 		=> "#6DAEB7",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Background Color",
						"desc" 		=> "Default: #6DAEB7",
						"id" 		=> "submenu_bg",
						"std" 		=> "#6DAEB7",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Sub Menu Background hover Color",
						"desc" 		=> "Default: #444",
						"id" 		=> "submenu_link",
						"std" 		=> "#444",
						"type" 		=> "color"
				);


//      Typography TAB
$of_options[] = array( 	"name" 		=> "Typography",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "typography.png"
				);
$of_options[] = array( 	"name" 		=> "Body",
						"desc" 		=> "",
						"id" 		=> "body_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Body</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Body text font",
						"desc" 		=> "Specify the body font properties",
						"id" 		=> "body_text_font",
						"std" 		=> array('size' => '15px','face' => 'Raleway','style' => '400','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Widget",
						"desc" 		=> "",
						"id" 		=> "menu_link_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Menu</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Menu Link customize",
						"desc" 		=> "Specify the body font properties",
						"id" 		=> "menu_font",
						"std" 		=> array('size' => '12px','face' => 'Raleway','style' => '400','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Element",
						"desc" 		=> "",
						"id" 		=> "element_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Element</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Page Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "page_title",
						"std" 		=> array('size' => '60px','face' => 'Abril Fatface','style' => '400','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Pagebuilder Elements Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "element_title",
						"std" 		=> array('size' => '22px','face' => 'Raleway','style' => '500','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Widget",
						"desc" 		=> "",
						"id" 		=> "widget_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Widget</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Sidebar Widgets Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "sidebar_widgets_title",
						"std" 		=> array('size' => '20px','face' => 'Raleway','style' => '700','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Footer Widgets Title",
						"desc" 		=> "Specify the sidebar headline font properties",
						"id" 		=> "footer_widgets_title",
						"std" 		=> array('size' => '14px','face' => 'Raleway','style' => '700','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Headers font styling",
						"desc" 		=> "",
						"id" 		=> "header_font_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Headlines</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Heading Font Family",
						"desc" 		=> "",
						"id" 		=> "heading_font",
						"std" 		=> "Raleway",
						"type" 		=> "select_google_font",
						"options" 	=> $tw_googlefonts
				);
$of_options[] = array( 	"name" 		=> "H1 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h1_spec_font",
						"std" 		=> array('size' => '36px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H2 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h2_spec_font",
						"std" 		=> array('size' => '24px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H3 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h3_spec_font",
						"std" 		=> array('size' => '18px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H4 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h4_spec_font",
						"std" 		=> array('size' => '16px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H5 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h5_spec_font",
						"std" 		=> array('size' => '14px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "H6 - Specify Font Properties",
						"desc" 		=> "",
						"id" 		=> "h6_spec_font",
						"std" 		=> array('size' => '12px','color' => '#1c1c1c'),
						"type" 		=> "typography"
				);
$of_options[] = array( 	"name" 		=> "Google Font Subset",
						"desc" 		=> "",
						"id" 		=> "google_font_subset",
						"std" 		=> "<h3 style=\"margin: 3px;\">Google Font Subset</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Google Font Subset",
						"desc" 		=> "Some of Google fonts have additional subsets. Please insert those subsets seperated with comma (,). More information <a href='https://developers.google.com/fonts/docs/getting_started' target='_blank'>Google Font Subset</a>",
						"id" 		=> "google_font_subset",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Google Font Weight",
						"desc" 		=> "",
						"id" 		=> "google_font_weight",
						"std" 		=> "<h3 style=\"margin: 3px;\">Google Font Weight</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Google Font Weight",
						"desc" 		=> "Some of Google font has narrow style or unqiue weights and you can define here your custom.",
						"id" 		=> "google_font_weight",
						"std" 		=> "400,400italic,500,600,700",
						"type" 		=> "text"
				);


//      FB Twitter TAB

$of_options[] = array( 	"name" 		=> "FB Twitter API",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "comments-facebook-icon.png"
				);
$of_options[] = array( 	"name" 		=> "Facebook Like",
						"desc" 		=> "",
						"id" 		=> "facebook_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Twitter",
						"desc" 		=> "",
						"id" 		=> "twitter_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "GooglePlus",
						"desc" 		=> "",
						"id" 		=> "googleplus_share",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Pinterest",
						"desc" 		=> "",
						"id" 		=> "pinterest_share",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "LinkedIn",
						"desc" 		=> "",
						"id" 		=> "linkedin_share",
						"std" 		=> 0,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Facebook & Twitter",
						"desc" 		=> "",
						"id" 		=> "facebook_twitter_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Facebook Comment API section</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Facebook comment?",
						"desc" 		=> "On will be enabling facebook comment, Off will be Wordpress default comment.",
						"id" 		=> "facebook_comment",
						"std" 		=> 0,
						"folds" 	=> 1,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Facebook api key",
						"desc" 		=> "Create your own Facebook Application and <a href='https://developers.facebook.com/apps' target='_blank'>get ID</a>.",
						"id" 		=> "facebook_app_id",
						"std" 		=> "",
                                                "fold" 		=> "facebook_comment", /* the checkbox hook */
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "GooglePlus & Twitter",
						"desc" 		=> "",
						"id" 		=> "googleplus_twitter_info2",
						"std" 		=> "<h3 style=\"margin: 3px;\">GooglePlus and Twitter API section (Note this will Required!)</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "GooglePlus api key",
						"desc" 		=> "Create your own Google Plus Application key.",
						"id" 		=> "googleplus_api",
						"std" 		=> "",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "API key",
                                                "desc" 		=> "You need to Create your Twitter APP and <a href='https://dev.twitter.com/apps' target='_blank'>insert the ID</a>.",
                                                "id" 		=> "consumerkey",
                                                "std" 		=> "pF8tqk07zrsq0PsfyZhomQ",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "API secret",
                                                "desc" 		=> "",
                                                "id" 		=> "consumersecret",
                                                "std" 		=> "qViMOIRji6JY1QUZtnE9JETU9t3hKEQuHGIrl3FZRNI",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "Access token",
                                                "desc" 		=> "",
                                                "id" 		=> "accesstoken",
                                                "std" 		=> "93561870-XYcWyXV26ynsF9iXoUFjHdnwWMKphEqnp3Q4xk5rd",
                                                "type" 		=> "text");
$of_options[] = array( 	"name" 		=> "Access token secret",
                                                "desc" 		=> "",
                                                "id" 		=> "accesstokensecret",
                                                "std" 		=> "cSYVP8SSqwGU4qKXWYbokejLeUITJP1eB0EWzNcnlJg8j",
                                                "type" 		=> "text");

//      Woocommerce
$of_options[] = array( 	"name" 		=> "Woocommerce",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "shopping-cart-icon.png"
				);
$of_options[] = array( 	"name" 		=> "Products per page",
						"desc" 		=> "How much products on Shop page show at most.",
						"id" 		=> "woo_per_page",
						"std" 		=> get_option('posts_per_page'),
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Sorting options ?",
						"desc" 		=> "On will be enable, Off will be disable sorting option on Shop page.",
						"id" 		=> "woo_sorting",
						"std" 		=> 1,
						"folds" 	=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Shop page with Sidebar ?",
						"desc" 		=> "On will be with sidebar, Off will be without sidebar on Shop page.",
						"id" 		=> "woo_shopsidebar",
						"std" 		=> 1,
						"folds" 	=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> "Product single with Sidebar ?",
						"desc" 		=> "On will be with sidebar, Off will be without sidebar on Product single.",
						"id" 		=> "woo_singlesidebar",
						"std" 		=> 1,
						"folds" 	=> 0,
						"type" 		=> "switch"
				);

//      Custom CSS TAB
$of_options[] = array( 	"name" 		=> "Custom CSS & JS",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "custom-css.png"
				);
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "",
						"id" 		=> "custom_css_info",
						"std" 		=> "<h3 style=\"margin: 3px;\">Custom CSS and JS</h3>",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Paste your own customized CSS code.",
						"id" 		=> "custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
$of_options[] = array( 	"name" 		=> "Custom JS",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here an another Javascript. This will be added into the footer template of your theme.",
						"id" 		=> "tracking_code",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

//     Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "backup.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
	}//End function: of_options()
}//End chack if function exists: of_options()
?>