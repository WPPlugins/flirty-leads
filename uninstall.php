 <?php 
 if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 			exit();
 //register_deactivation_hook($file, $function); 
 //register_deactivation_hook(plugin_dir_url(__FILE__), $function);  
 
 // Uninstall code goes here
 delete_post_meta_by_key( '_ecs_owp_referer' ); 
 delete_post_meta_by_key( '_ecs_owp_btnsays' ); 
 delete_post_meta_by_key( '_ecs_owp_btn_color' ); 
 delete_post_meta_by_key( '_ecs_owp_btn_text_color' ); 
 delete_post_meta_by_key( '_ecs_owp_lead_capture_header' ); 
 delete_post_meta_by_key( '_ecs_owp_lcemail' ); 
 delete_post_meta_by_key( '_ecs_owp_show_lc' ); 
 delete_post_meta_by_key( '_ecs_owp_cta_color' ); 
 delete_post_meta_by_key( '_ecs_owp_cta_size' ); 
 delete_post_meta_by_key( '_ecs_owp_cta_weight' ); 
 delete_post_meta_by_key( '_ecs_owp_cta_height' ); 

 ?> 