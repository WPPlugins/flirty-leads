<?php
/*Plugin Name: Flirty Leads Plugin 
URI: http://www.orcawebperformance.com/flirty-leads-a-wordpress-plugin/
Description: Tags: lead capture, call to action, email campaigns, direct dashboard media editing, MailChimp integration

Demo http://peaceoftheocean.com/paris/eiffel/  first lead capture uses MailChimp to capture lead, second lead capture is sent to the site owner.

Version: 4.0
Author: sageshilling
License: GPL2
*/
/*  Copyright 2016  Elizabeth Shilling - Orca Web Performance  
(email : eshilling@orcawebperformance.com)
This program is free software; you can redistribute it and/or modifyit under the terms of the GNU General Public License, 
version 2, aspublished by the Free Software Foundation.This program is distributed in the hope that it will be useful,but 
WITHOUT ANY WARRANTY; without even the implied warranty ofMERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
See theGNU General Public License for more details.
You should have received a copy of the GNU General Public Licensealong with this program; if not, 
write to the Free SoftwareFoundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//hook in all the important things
function ecs_owp_flirtyleads_scripts() {
		//single post and main query or Default homepage or static homepage or blog page
	//if ( (is_single() && is_main_query()) || (is_front_page() && is_home()) || is_front_page() || is_home() ) {
	//Get plugin stylesheet
	wp_enqueue_style( 'flirtyleads-style', plugin_dir_url(__FILE__) . 'css/style.css', '0.1', 'all');
	
	wp_enqueue_script( 'flirty-script', plugin_dir_url(__FILE__) . 'js/flirty.ajax.js', array('jquery'), '0.1', true );	
	
	      // Get the protocol of the current page
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
 
        // Set the ajaxurl Parameter which will be output right before
        // our ajax-like-image.js file so we can use ajaxurl
        $params = array(
            // Get the url to the admin-ajax.php file using admin_url()
            'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
			'phone' => '555 555 5555'
        );
	  // Print the script to our page
	wp_localize_script( 'flirty-script', 'postdata',  $params );
	//} if blog, page...
}
add_action( 'wp_enqueue_scripts', 'ecs_owp_flirtyleads_scripts');


	
											//data for the image likes and counts
											//second try
											function ecs_owp_flirtyleads_content($content) { 
											//single post and main query or Default homepage or static homepage or blog page
											if ( (is_single() && is_main_query()) || (is_front_page() && is_home()) || is_front_page() || is_home() || ! is_admin() || ! has_excerpt()  ) {
													//$pos = strpos($newstring, 'a', 1);  skip first a
												$postimagecount = substr_count( $content, 'wp-image-' );
												if ($postimagecount == 0) return $content; //no images in post
												
														else
												{//find img 
																	//for unique form id
																	$uniq_id = 0;
																	$finalstring = "";
													while($postimagecount != 0)
														{
															$checkstring =strstr( $content, 'img' );  //remaining string inc img
															//Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.
															$imgpos = strpos( $content, 'img' );  //where i is at
															
															//get info
															//get image id
													$pos3 = strpos($content, 'wp-image-');
													//string substr ( string $string , int $start [, int $length ] )
													$contentedit2 = substr($content, $pos3);  //wp-image...
													$pos4 = strpos($contentedit2, '"');
													$imagenumlen = $pos4 - 9;
													$imagechunk = 10 + $imagenumlen;
													$imageinfopart = substr($contentedit2, 0, $imagechunk);
													$imagenumlen1 = $imagenumlen + 1; 
													//imgnumlennlaspiece
													$imageid = (int) substr($imageinfopart, -$imagenumlen1, $imagenumlen);
													
													
										//show lc default no
									$key_value = get_post_meta( $imageid, '_ecs_owp_show_lc', true );
									if ($key_value == "") $key_value = "no";
									if ($key_value == "no"){
															$firstcontent = substr( $content, 0, ($imgpos)); //beg to img(wo img or)
															$finalstring .= $firstcontent;	
													//*****************
															//reset content to remaining string
																				
																				$content = $checkstring;
																			//	if (key_value == "yes"){
																			//find end of image, the next >
																$midstring = strstr( $content, '>' ); //remaining string from >
																//check next position for </a> 1-4
																$isimg = substr($midstring, 1, 4);
																if($isimg == "</a>"){ //it's a linked image
																//find end of image, the next </a>
																$checkstring =strstr( $content, '</a>' );  //remaining string inc </a>
																$endimgpos = strpos( $content, '</a>' );  //where < is at
																$firstcontent = substr( $content, 0, ($endimgpos+4)); //beg to </a>(w</a>
																
																
																
																//if (key_value == "yes"){
																$finalstring .= $firstcontent;
																 
																$checkstring =substr( $content, ($endimgpos + 4)); //beg </a>(wo </a>
																
																$content = $checkstring;
																}
																	else {//no link
																	//find end of image, the next >
																$checkstring =strstr( $content, '>' );  //remaining string inc >
																$endimgpos = strpos( $content, '>' );  //where > is at
																$firstcontent = substr( $content, 0, ($endimgpos + 1) ); //beg to >(w>
																$finalstring .= $firstcontent;
															
																
																$checkstring =substr( $content, ($endimgpos + 1)); //beg >(wo >
																$content = $checkstring;
																}
									}	
									 //$key_value = "yes";
									else {
													$content = str_replace('<img', '<div class="elizabethneedsanap"><img', $content);
													$content = str_replace('img class="', 'img class="item1 ', $content);
													$checkstring =strstr( $content, 'img' );  //remaining string inc img
															//Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.
															$imgpos = strpos( $content, 'img' );  //where i is at
													
													
													//get image width in the post from php string functions
													$widthcontentedit3 = strstr($checkstring, 'width' );  //width...
													$firstquotes = strstr( $widthcontentedit3, '"' );  //first "...
													$firstquotespos = strpos( $firstquotes, '"' );  //pos first " is at 0
													//$placekeeper = $firstquotepos + 1; //1
													$firstquoteslen = strlen($firstquotes); //894
													$widthcontentedit3 = substr($firstquotes, 1, ($firstquoteslen -2)); //snippet caught
													$secondquotespos = strpos( $widthcontentedit3, '"' );  //pos second ...3
													$clipimagewidth = substr($firstquotes, 1, $secondquotespos); //gives image width
													
													
													//get image alignment in the post from php string functions
													$aligncontentedit3 = strstr($checkstring, 'align' );  //align...
													$alignspacepos = strpos( $aligncontentedit3, ' ' );  //pos first " " 
													$clipimagealignment = substr($aligncontentedit3, 0, $alignspacepos); //gives image alignment
													
													//get image width
													//$attachment_meta = wp_get_attachment_metadata( $imageid, $unfiltered );  //this works mainly except thumbnails 150px
													//$meta_width = $attachment_meta['width'];
													//$attachment_meta = wp_get_attachment_image_src( $imageid );
													//$meta_width = $attachment_meta[1];
													
													//get field values
												
													
													$key_1_value = get_post_meta( $imageid, '_ecs_owp_cta_color', true );
													$key_7_value = get_post_meta( $imageid, '_ecs_owp_cta_size', true );
													$key_8_value = get_post_meta( $imageid, '_ecs_owp_cta_weight', true );
													$key_9_value = get_post_meta( $imageid, '_ecs_owp_cta_height', true );
													$key_2_value = get_post_meta( $imageid, '_ecs_owp_lead_capture_header', true );
													if ($key_2_value == "") $key_2_value = "Find out more!";
													$key_3_value = get_post_meta( $imageid, '_ecs_owp_referer', true );
													if ($key_3_value == "") $key_3_value = get_bloginfo();
													$key_4_value = get_post_meta( $imageid, '_ecs_owp_btnsays', true );
													if ($key_4_value == "") $key_4_value = "send";
													$key_5_value = get_post_meta( $imageid, '_ecs_owp_lcemail', true );
													if ($key_5_value == "") $key_5_value = get_option( 'admin_email' );  
													$key_6_value = get_post_meta( $imageid, '_ecs_owp_btn_text_color', true );
													$key_10_value = get_post_meta( $imageid, '_ecs_owp_btn_color', true );
													$key_11_value = get_post_meta( $imageid, '_ecs_owp_use_mailchimp', true );
													$key_12_value = "";
													$key_13_value = "";
													$key_14_value = "";
													$key_15_value = "email";
													$key_16_value = "";
													if($key_11_value == "yes"){
																$key_12_value = get_post_meta( $imageid, '_ecs_owp_mc_actionurl', true );
																$key_13_value = get_post_meta( $imageid, '_ecs_owp_mc_userid', true );
																$key_14_value = get_post_meta( $imageid, '_ecs_owp_mc_listid', true );
																$key_15_value = get_post_meta( $imageid, '_ecs_owp_mc_emailname', true );
																$key_16_value = 'value="Subscribe to list"';
													}
													//if ($key_6_value == "") $key_6_value = "left";
												
													
													$firstcontent = substr( $content, 0, ($imgpos)); //beg to img(wo img or)
													//$firstcontent = str_replace('elizabethneedsanap', 'elizabethneedsanap' . $key_6_value, $firstcontent);
													$firstcontent = str_replace('elizabethneedsanap"', 'elizabethneedsanap' . $clipimagealignment . '" width="' . $clipimagewidth . 'px"> <div class="col"', $firstcontent);
													//$firstcontent = str_replace('elizabethneedsanap', 'elizabethneedsanap' . $clipimagealignment, $firstcontent);
															$finalstring .= $firstcontent;
													
													
													$email_jq = 'onblur="if (this.value == \'\') {this.value = \'carroll@yourteam.com\';}" onfocus="if (this.value == \'carroll@yourteam.com\') {this.value = \'\';}"';
													
													if ($key_value == "no")
													{ $ShowLC = 'style="display:none;"';} else { $ShowLC = '';} //else { $ShowLC = '';}  causes edit
													if($key_11_value == "yes"){
															 $mailchimp_info ='<input type="hidden" name="u" value="' . $key_13_value . '">
																  <input type="hidden" name="id" value="' . $key_14_value . '">'; } else $mailchimp_info = "";
													$str1 = '';
													// background color $bg_color']
													//$str2 = '<div class="item2"><div class"flirty"><div class="flirt1"><div class="lead_capture_header_' . $uniq_id . '" ' . $ShowLC . '>';
													$str2 = '<div class="item2' . $clipimagealignment . '" style="height: ' . $key_9_value . 'px;';
													$str2a = '"><div class"flirty"><div class="flirt1" style="font-size: ' . $key_7_value . 'px; font-weight: ' . $key_8_value . '; color: #' . $key_1_value . '; "><div class="lead_capture_header_' . $uniq_id . '" ' . $ShowLC . '>';
													// $lead_capture_header
													$str3= '</div></div><div id="thanks_' . $imageid .'" style="display:none">Thank you!<br />********</div><div class="flirt2"><form  action="';
													$str3a = $key_12_value;
													if ($key_11_value == "yes"){
													$str3b ='" method="post" id ="lcform_' . $uniq_id . '20" name="ContactForm" class="form form--complex flecs_get-post"' . $ShowLC . '> 
															<input id="invitation_id_' . $imageid . '" name="form_id" type="hidden" value="' . $imageid . '" />
															<input id="uniq_id_' . $uniq_id . '" name="uniq_id" type="hidden" value="' . $uniq_id . '" />' . $mailchimp_info . '
					                                ' . wp_nonce_field('flirty_jen-lead-' . $imageid , 'nonce') . '
															<input id="invitation_referer_' . $imageid . '" name="referer" type="hidden" value="' ;}
															else {
															$str3b ='" method="post" id ="lcform_' . $uniq_id . '" name="ContactForm" class="form form--complex flecs_get-post"' . $ShowLC . '> 
															<input id="invitation_id_' . $imageid . '" name="form_id" type="hidden" value="' . $imageid . '" />
															<input id="uniq_id_' . $uniq_id . '" name="uniq_id" type="hidden" value="' . $uniq_id . '" />' . $mailchimp_info . '
					                                ' . wp_nonce_field('flirty_jen-lead-' . $imageid , 'nonce') . '
															<input id="invitation_referer_' . $imageid . '" name="referer" type="hidden" value="' ;}
													// $referer
													$str4='" /><input id="invitation_name_' . $imageid . '" name="lcemail" type="hidden" value="' . $key_5_value . '"><input id="invitation_phone_' . $imageid . '" name="telephone" type="hidden" value="555 555 5555">
															  <input class="form__text_input form__object--fillspace" id="invitation_email_' . $imageid . '" name="' . $key_15_value . '" placeholder="carroll@example.com"';
															  $str4a='type="email" required>';// if ($key_4_value == "") $key_4_value = "send";
															$str4b='<button name="submit" class="form__object--fillspace-gap btn ecs_form" type="submit" ' . $key_16_value . ' style="background-color:#' . $key_10_value . '; color:#' . $key_6_value . ';">' . $key_4_value . '</button>';
															$str5='</form></div></div></div></div></div>';
															//$btnsays

															
															
													//*****************
															//reset content to remaining string
																				
																				$content = $checkstring;
																			//	if (key_value == "yes"){
																			//find end of image, the next >
																$midstring = strstr( $content, '>' ); //remaining string from >
																//check next position for </a> 1-4
																$isimg = substr($midstring, 1, 4);
																if($isimg == "</a>"){ //it's a linked image
																//find end of image, the next </a>
																$checkstring =strstr( $content, '</a>' );  //remaining string inc </a>
																$endimgpos = strpos( $content, '</a>' );  //where < is at
																$firstcontent = substr( $content, 0, ($endimgpos+4)); //beg to </a>(w</a>
																
																
																
																//if (key_value == "yes"){
																$finalstring .= ($firstcontent.$str2.$key_6_value.$str2a.$key_2_value.$str3.$str3a.$str3b.$key_3_value.$str4.$str4a.$str4b.$str5);
																 
																$checkstring =substr( $content, ($endimgpos + 4)); //beg </a>(wo </a>
																
																//remove elizabethneedsanap
																$checkstring = str_replace('<div class="elizabethneedsanap"><img', '<img', $checkstring);
																$checkstring = str_replace('img class="item1 ', 'img class="',  $checkstring);
																
																$content = $checkstring;
																}
																	else {//no link
																	//find end of image, the next >
																$checkstring =strstr( $content, '>' );  //remaining string inc >
																$endimgpos = strpos( $content, '>' );  //where > is at
																$firstcontent = substr( $content, 0, ($endimgpos + 1) ); //beg to >(w>
																$finalstring .= ($firstcontent.$str2.$key_6_value.$str2a.$key_2_value.$str3.$str3a.$str3b.$key_3_value.$str4.$str4a.$str4b.$str5);
															
																
																$checkstring =substr( $content, ($endimgpos + 1)); //beg >(wo >
																
																//remove elizabethneedsanap
																$checkstring = str_replace('<div class="elizabethneedsanap"><img', '<img', $checkstring);
																$checkstring = str_replace('img class="item1 ', 'img class="',  $checkstring);
																
																$content = $checkstring;
																}
									}							
																$postimagecount = substr_count( $content, 'wp-image-' );
																$uniq_id++;
														}
												}
												if (has_excerpt() ) {$checkstring = str_replace("Thank you!<br />********", "", $checkstring);
																	 $finalstring = str_replace("Thank you!<br />********", "", $finalstring);}
												return $finalstring.$checkstring;
												}//for if front page, blog...
												else return $content;
											}

												
													
													add_filter( 'the_content', 'ecs_owp_flirtyleads_content' );
													
													function ecs_owp_referer_value () { $ecs_owp_referer_value = get_post_meta( $imageid, _ecs_owp_referer, true ); return $ecs_owp_referer_value; }
													/** * Adding a "Copyright" field to the media uploader $form_fields array 
													* 
													* ref http://bavotasan.com/2012/add-a-copyright-field-to-the-media-uploader-in-wordpress/ 
													* @param array $form_fields * @param object $post 
													* 
													* @return array 
													*/
													/** * Adding a "show lc" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_show_lc_field_to_media_uploader($form_fields, $post){
													if((get_post_meta($post->ID, '_ecs_owp_show_lc', true)) == "") $ecs_owp_show_lc_value = 'no';      
													else $ecs_owp_show_lc_value = get_post_meta( $post->ID, '_ecs_owp_show_lc', true );	
													$form_fields['ecs_owp_show_lc_field'] = array(		'label' => __('Show lead capture form (yes or no, default set to not show form)'),		'value' => $ecs_owp_show_lc_value,		'helps' => 'Set a field to add show_lc to show_activate lc'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_show_lc_field_to_media_uploader', null, 2);
													/** * Save our new "show lc" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_show_lc_field_to_media_uploader_save($post, $attachment){	
													if(!empty($attachment['ecs_owp_show_lc_field'])) update_post_meta($post['ID'], '_ecs_owp_show_lc', sanitize_text_field($attachment['ecs_owp_show_lc_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_show_lc');	
													return $post;
													}
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_show_lc_field_to_media_uploader_save', null, 2);
													/** * Display our new "show lc" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_show_lc($attachment_id = null){	
													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_show_lc', true);
													}
													
													/** * Adding a "lead_capture_header" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_lead_capture_header_field_to_media_uploader($form_fields, $post){
													if((get_post_meta($post->ID, '_ecs_owp_lead_capture_header', true)) == "") $ecs_owp_lead_capture_header_value = 'Find out more!';      
													else $ecs_owp_lead_capture_header_value = get_post_meta( $post->ID, '_ecs_owp_lead_capture_header', true );	
													$form_fields['ecs_owp_lead_capture_header_field'] = array(		'label' => __('Call to action'),		'value' => $ecs_owp_lead_capture_header_value,		'helps' => 'Set a field to add call to action to the image attachment'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_lead_capture_header_field_to_media_uploader', null, 2);
													/** * Save our new "lead capture header" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_lead_capture_header_field_to_media_uploader_save($post, $attachment){	
													if(!empty($attachment['ecs_owp_lead_capture_header_field'])) update_post_meta($post['ID'], '_ecs_owp_lead_capture_header', sanitize_text_field($attachment['ecs_owp_lead_capture_header_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_lead_capture_header');	
													return $post;
													}
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_lead_capture_header_field_to_media_uploader_save', null, 2);
													/** * Display our new "lead capture header" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_lead_capture_header($attachment_id = null){	
													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_lead_capture_header', true);
													}
													
													
													function flirtyleads_add_ecs_owp_btnsays_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_btnsays', true)) == "") $ecs_owp_btnsays_value ='send';      
													else $ecs_owp_btnsays_value = get_post_meta( $post->ID, '_ecs_owp_btnsays', true );	
													$form_fields['ecs_owp_btnsays_field'] = array(		'label' => __('Button text'),		'value' => $ecs_owp_btnsays_value,		'helps' => 'Set text to the button'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_btnsays_field_to_media_uploader', null, 2);
													/** * Save our new "Button text" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_btnsays_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_btnsays_field'])) update_post_meta($post['ID'], '_ecs_owp_btnsays', sanitize_text_field($attachment['ecs_owp_btnsays_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_btnsays');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_btnsays_field_to_media_uploader_save', null, 2);
													/** * Display our new "Button text" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_btnsays($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_btnsays', true);
													}
													
													
													
													/** * Adding a "referer" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_referer_field_to_media_uploader($form_fields, $post){
													if((get_post_meta($post->ID, '_ecs_owp_referer', true)) == "") $ecs_owp_referer_value = get_bloginfo();      
													else $ecs_owp_referer_value = get_post_meta( $post->ID, '_ecs_owp_referer', true );	
													$form_fields['ecs_owp_referer_field'] = array(		'label' => __('Referer image (where the lead came from)'),		'value' => $ecs_owp_referer_value,		'helps' => 'Set a field to add referrer image to the image attachment'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_referer_field_to_media_uploader', null, 2);
													/** * Save our new "referer" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_referer_field_to_media_uploader_save($post, $attachment){	
													if(!empty($attachment['ecs_owp_referer_field'])) update_post_meta($post['ID'], '_ecs_owp_referer', sanitize_text_field($attachment['ecs_owp_referer_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_referer');	
													return $post;
													}
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_referer_field_to_media_uploader_save', null, 2);
													/** * Display our new "referer" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_referer($attachment_id = null){	
													$attachment_id = (empty($attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_referer', true);
													}
													
													
													function flirtyleads_add_ecs_owp_lcemail_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_lcemail', true)) == "") $ecs_owp_lcemail_value = get_option( 'admin_email' );      
													else $ecs_owp_lcemail_value = get_post_meta( $post->ID, '_ecs_owp_lcemail', true );	
													$form_fields['ecs_owp_lcemail_field'] = array(		'label' => __('Email the lead is sent to '),		'value' => $ecs_owp_lcemail_value,		'helps' => 'Set where the lead is sent to'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_lcemail_field_to_media_uploader', null, 2);
													/** * Save our new "lead capture email sent to" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_lcemail_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_lcemail_field'])) update_post_meta($post['ID'], '_ecs_owp_lcemail', sanitize_text_field($attachment['ecs_owp_lcemail_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_lcemail');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_lcemail_field_to_media_uploader_save', null, 2);
													/** * Display our new "lead capture email sent to" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_lcemail($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_lcemail ', true);
													}

													
													/** * Adding a "cta text color" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_cta_color_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_cta_color', true)) == "") $ecs_owp_cta_color_value = '';      
													else $ecs_owp_cta_color_value = get_post_meta( $post->ID, '_ecs_owp_cta_color', true );	
													$form_fields['ecs_owp_cta_color_field'] = array(		'label' => __('optional: Call to Action text color, default your theme styling, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_cta_color_value,		'helps' => 'Set call to action font color'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_cta_color_field_to_media_uploader', null, 2);
													/** * Save our new "cta text color* * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_cta_color_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_cta_color_field'])) update_post_meta($post['ID'], '_ecs_owp_cta_color', sanitize_text_field($attachment['ecs_owp_cta_color_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_cta_color');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_cta_color_field_to_media_uploader_save', null, 2);
													/** * Display our new "cta text color" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_cta_color($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_cta_color ', true);
													}
													
													/** * Adding a "cta text size" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_cta_size_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_cta_size', true)) == "") $ecs_owp_cta_size_value = '';      
													else $ecs_owp_cta_size_value = get_post_meta( $post->ID, '_ecs_owp_cta_size', true );	
													$form_fields['ecs_owp_cta_size_field'] = array(		'label' => __('optional: Call to Action font size, default your theme styling, takes number like 12 '),		'value' => $ecs_owp_cta_size_value,		'helps' => 'Set call to action font size'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_cta_size_field_to_media_uploader', null, 2);
													/** * Save our new "cta text size* * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_cta_size_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_cta_size_field'])) update_post_meta($post['ID'], '_ecs_owp_cta_size', sanitize_text_field($attachment['ecs_owp_cta_size_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_cta_size');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_cta_size_field_to_media_uploader_save', null, 2);
													/** * Display our new "cta text size" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_cta_size($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_cta_size ', true);
													}
													
													/** * Adding a "cta text weight" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_cta_weight_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_cta_weight', true)) == "") $ecs_owp_cta_weight_value = '';      
													else $ecs_owp_cta_weight_value = get_post_meta( $post->ID, '_ecs_owp_cta_weight', true );	
													$form_fields['ecs_owp_cta_weight_field'] = array(		'label' => __('optional: Call to Action font weight, default your theme styling; options: light, normal, bold, or bolder '),		'value' => $ecs_owp_cta_weight_value,		'helps' => 'Set call to action to bolden text'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_cta_weight_field_to_media_uploader', null, 2);
													/** * Save our new "cta text weight* * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_cta_weight_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_cta_weight_field'])) update_post_meta($post['ID'], '_ecs_owp_cta_weight', sanitize_text_field($attachment['ecs_owp_cta_weight_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_cta_weight');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_cta_weight_field_to_media_uploader_save', null, 2);
													/** * Display our new "cta text weight" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_cta_weight($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_cta_weight ', true);
													}
													
													/** * Adding a "cta text height" field to the media uploader $form_fields array * @param array $form_fields * @param object $post * * @return array */
													function flirtyleads_add_ecs_owp_cta_height_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_cta_height', true)) == "") $ecs_owp_cta_height_value = '';      
													else $ecs_owp_cta_height_value = get_post_meta( $post->ID, '_ecs_owp_cta_height', true );	
													$form_fields['ecs_owp_cta_height_field'] = array(		'label' => __('optional: Call to Action bottom padding beneath lead capture form, default your theme styling, takes number like 70 '),		'value' => $ecs_owp_cta_height_value,		'helps' => 'Set call to action bottom padding, if needed'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_cta_height_field_to_media_uploader', null, 2);
													/** * Save our new "cta text height* * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_cta_height_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_cta_height_field'])) update_post_meta($post['ID'], '_ecs_owp_cta_height', sanitize_text_field($attachment['ecs_owp_cta_height_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_cta_height');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_cta_height_field_to_media_uploader_save', null, 2);
													/** * Display our new "cta text height" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_cta_height($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_cta_height ', true);
													}
													
													function flirtyleads_add_ecs_owp_btn_color_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_btn_color', true)) == "") $ecs_owp_btn_color_value ='';      
													else $ecs_owp_btn_color_value = get_post_meta( $post->ID, '_ecs_owp_btn_color', true );	
													$form_fields['ecs_owp_btn_color_field'] = array(		'label' => __('optional: Button color, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_btn_color_value,		'helps' => 'Set color of the button'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_btn_color_field_to_media_uploader', null, 2);
													/** * Save our new "Button color" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_btn_color_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_btn_color_field'])) update_post_meta($post['ID'], '_ecs_owp_btn_color', sanitize_text_field($attachment['ecs_owp_btn_color_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_btn_color');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_btn_color_field_to_media_uploader_save', null, 2);
													/** * Display our new "Button color" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_btn_color($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_btn_color', true);
													}
													
													function flirtyleads_add_ecs_owp_btn_text_color_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_btn_text_color', true)) == "") $ecs_owp_btn_text_color_value ='';      
													else $ecs_owp_btn_text_color_value = get_post_meta( $post->ID, '_ecs_owp_btn_text_color', true );	
													$form_fields['ecs_owp_btn_text_color_field'] = array(		'label' => __('optional: Button text color, takes hexidecimal like FFFFFF , no # needed  '),		'value' => $ecs_owp_btn_text_color_value,		'helps' => 'Set color of the button text'	);	
													return $form_fields;
													}
													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_btn_text_color_field_to_media_uploader', null, 2);
													/** * Save our new "Button text color" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_btn_text_color_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_btn_text_color_field'])) update_post_meta($post['ID'], '_ecs_owp_btn_text_color', sanitize_text_field($attachment['ecs_owp_btn_text_color_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_btn_text_color');	
													return $post;
													} 
													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_btn_text_color_field_to_media_uploader_save', null, 2);
													/** * Display our new "Button text color" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_btn_text_color($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_btn_text_color', true);
													}
													
													function flirtyleads_add_ecs_owp_use_mailchimp_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_use_mailchimp', true)) == "") $ecs_owp_use_mailchimp_value ='no';      
													else $ecs_owp_use_mailchimp_value = get_post_meta( $post->ID, '_ecs_owp_use_mailchimp', true );	
													$form_fields['ecs_owp_use_mailchimp_field'] = array(		'label' => __('optional: Send info to my MailChimp list, enter fields below, set to yes and fill the remaining fields below:  '),		'value' => $ecs_owp_use_mailchimp_value,		'helps' => 'Send leads to your MailChimp list'	);	
													return $form_fields;
													}

													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_use_mailchimp_field_to_media_uploader', null, 2);
													/** * Save our new "use mailchimp" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_use_mailchimp_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_use_mailchimp_field'])) update_post_meta($post['ID'], '_ecs_owp_use_mailchimp', sanitize_text_field($attachment['ecs_owp_use_mailchimp_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_use_mailchimp');	
													return $post;
													} 

													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_use_mailchimp_field_to_media_uploader_save', null, 2);
													/** * Display our new "use mailchimp" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_use_mailchimp($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_use_mailchimp', true);
													}
													
													function flirtyleads_add_ecs_owp_mc_actionurl_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_mc_actionurl', true)) == "") $ecs_owp_mc_actionurl_value ='';      
													else $ecs_owp_mc_actionurl_value = get_post_meta( $post->ID, '_ecs_owp_mc_actionurl', true );	
													$form_fields['ecs_owp_mc_actionurl_field'] = array(		'label' => __('instructions found at orcawebperformance.com/flirtyleads_to_mailchimp_list.php, required if sending to MailChimp: the form action url, something like https://orcawebperformance.us14.list-manage.com/subscribe/post  '),		'value' => $ecs_owp_mc_actionurl_value,		'helps' => 'form action url to process the form information by MailChimp'	);	
													return $form_fields;
													}

													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_mc_actionurl_field_to_media_uploader', null, 2);
													/** * Save our new "MailChimp formactionurl" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_mc_actionurl_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_mc_actionurl_field'])) update_post_meta($post['ID'], '_ecs_owp_mc_actionurl', sanitize_text_field($attachment['ecs_owp_mc_actionurl_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_mc_actionurl');	
													return $post;
													} 

													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_mc_actionurl_field_to_media_uploader_save', null, 2);
													/** * Display our new "MailChimp formactionurl" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_mc_actionurl($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_mc_actionurl', true);
													}
													
								                    function flirtyleads_add_ecs_owp_mc_userid_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_mc_userid', true)) == "") $ecs_owp_mc_userid_value ='';      
													else $ecs_owp_mc_userid_value = get_post_meta( $post->ID, '_ecs_owp_mc_userid', true );	
													$form_fields['ecs_owp_mc_userid_field'] = array(		'label' => __('required for MailChimp, if sending lead to MailChimp: Your user Id, like 6fc28ef71798aa68f0d723b90  '),		'value' => $ecs_owp_mc_userid_value,		'helps' => 'Sends your MailChimp userID to identify your MailChimp account'	);	
													return $form_fields;
													}

													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_mc_userid_field_to_media_uploader', null, 2);
													/** * Save our new "MailChimp userid" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_mc_userid_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_mc_userid_field'])) update_post_meta($post['ID'], '_ecs_owp_mc_userid', sanitize_text_field($attachment['ecs_owp_mc_userid_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_mc_userid');	
													return $post;
													} 

													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_mc_userid_field_to_media_uploader_save', null, 2);
													/** * Display our new "MailChimp userid" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_mc_userid($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_mc_userid', true);
													}
													
													function flirtyleads_add_ecs_owp_mc_listid_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_mc_listid', true)) == "") $ecs_owp_mc_listid_value ='';      
													else $ecs_owp_mc_listid_value = get_post_meta( $post->ID, '_ecs_owp_mc_listid', true );	
													$form_fields['ecs_owp_mc_listid_field'] = array(		'label' => __('required for sending to MailChimp: list id, like 918a37970d  '),		'value' => $ecs_owp_mc_listid_value,		'helps' => 'Sends your MailChimp listID to identify which list to add client email address to'	);	
													return $form_fields;
													}

													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_mc_listid_field_to_media_uploader', null, 2);
													/** * Save our new "MailChimp listID" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_mc_listid_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_mc_listid_field'])) update_post_meta($post['ID'], '_ecs_owp_mc_listid', sanitize_text_field($attachment['ecs_owp_mc_listid_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_mc_listid');	
													return $post;
													} 

													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_mc_listid_field_to_media_uploader_save', null, 2);
													/** * Display our new "MailChimp listID" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_mc_listid($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_mc_listid', true);
													}

													function flirtyleads_add_ecs_owp_mc_emailname_field_to_media_uploader($form_fields, $post){	
													if((get_post_meta($post->ID, '_ecs_owp_mc_emailname', true)) == "") $ecs_owp_mc_emailname_value ='';      
													else $ecs_owp_mc_emailname_value = get_post_meta( $post->ID, '_ecs_owp_mc_emailname', true );	
													$form_fields['ecs_owp_mc_emailname_field'] = array(		'label' => __('required for sending to MailChimp: email name, like b_email  '),		'value' => $ecs_owp_mc_emailname_value,		'helps' => 'Set email name value to match your MailChimp form\'s'	);	
													return $form_fields;
													}

													add_filter('attachment_fields_to_edit', 'flirtyleads_add_ecs_owp_mc_emailname_field_to_media_uploader', null, 2);
													/** * Save our new "MailChimp email name" field * * @param object $post * @param object $attachment * * @return array */
													function flirtyleads_add_ecs_owp_mc_emailname_field_to_media_uploader_save($post, $attachment) {	
													if(!empty($attachment['ecs_owp_mc_emailname_field'])) update_post_meta($post['ID'], '_ecs_owp_mc_emailname', sanitize_text_field($attachment['ecs_owp_mc_emailname_field']));	
													else delete_post_meta($post['ID'], '_ecs_owp_mc_emailname');	
													return $post;
													} 

													add_filter( 'attachment_fields_to_save', 'flirtyleads_add_ecs_owp_mc_emailname_field_to_media_uploader_save', null, 2);
													/** * Display our new "MailChimp email name" field * * @param int $attachment_id * * @return array */
													function flirtyleads_get_featured_image_ecs_owp_mc_emailname($attachment_id = null){	
													$attachment_id = (empty( $attachment_id)) ? get_post_thumbnail_id() : (int)$attachment_id;	
													if($attachment_id) return get_post_meta($attachment_id, '_ecs_owp_mc_emailname', true);
													}		
													
													function ecs_generate_show_excerpt( $output ) {
														// if ( has_excerpt() && ! is_attachment() ) {
													$output = str_replace("Find out more!Thank you!", " ", $output); 
													$output = str_replace("********", " ", $output); 
														// }
													return $output;
														}
													add_filter( 'get_the_excerpt', 'ecs_generate_show_excerpt' );
												
													
		  // Ajax Handler
add_action( 'wp_ajax_flirtyleads', 'flirtyleads' );
add_action( 'wp_ajax_nopriv_flirtyleads', 'flirtyleads' );
function flirtyleads() {
 // Get the Image ID, & stuff from the URL
$referer =  sanitize_text_field($_POST['referer']); 
$referer = isset($referer) ? $referer : '';
$email =  sanitize_text_field($_POST['email']); 
$email = isset($email) ? $email : '';
$lcemail =  sanitize_text_field($_POST['lcemail']); 
$lcemail = isset($lcemail) ? $lcemail : '';

$nonce = sanitize_text_field($_REQUEST['nonce']);
$image_id = sanitize_text_field($_REQUEST['image_id']); 
$image_id = intval($image_id);

		 // Instantiate WP_Ajax_Response
    $response = new WP_Ajax_Response;
	$gin = wp_verify_nonce( $nonce, 'flirty_jen-lead-' . $image_id );
    // Proceed, again we are checking for permissions
    if( 
        // Verify Nonces
        wp_verify_nonce( $nonce, 'flirty_jen-lead-' . $image_id ) 
      ){
		  $to = $lcemail; 
			$subject = "Another Lead from Flirty Leads"; 
			$email = $email ; 
			$message = $message = "
			Here's another lead from flirtyleads.com...
			Email: " .$email. "

			Referrer: " .$referer ; 
			//$headers[] = "From: $email";
			$headers = array('From: ' . $email);			
			$attachments = "";
			wp_mail( $to, $subject, $message, $headers );
       
       
		  	// Build the response if successful
        $response->add( array(
            'data'  => 'success',
            'supplemental' => array(
                'image_id' => $image_id,
                'message' => 'Success verifying nonce for this image ('. $image_id . ')',
            ),
        ) );
    } else {
        // Build the response if an error occurred
        $response->add( array(
            'data'  => 'error',
            'supplemental' => array(
                'image_id' => $image_id,
                'message' => 'Error sending email for this image ('. $image_id .')',
            ),
        ) );
    }
    // Whatever the outcome, send the Response back
    $response->send();
 
    // Always exit when doing Ajax
    exit();
}