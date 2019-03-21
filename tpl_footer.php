<?php
/**
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 3183 2006-03-14 07:58:59Z birdbrain $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
$slideshow_query = "SELECT * FROM " . DB_PREFIX.mozen;
$slideshow_result = $db->Execute($slideshow_query);
$address = $slideshow_result->fields['address'];
$email_id = $slideshow_result->fields['email_id'];
$phone_support = $slideshow_result->fields['phone_support'];
$skype_id = $slideshow_result->fields['skype_id'];
$copyright_text = $slideshow_result->fields['copyright_text'];
?>

<?php
if (!$flag_disable_footer) {


		$last_dt = $db->Execute("select max(p.products_date_added) as last_u_date
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = pd.products_id  and p.products_status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
						   
		 $last_products = $db->Execute("select pd.products_description,p.products_date_added,p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_date_added ='".$last_dt->fields['last_u_date']."'
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
						   
		$second_last_dt = $db->Execute("select p.products_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id ) 
                           where p.products_id = pd.products_id  and p.products_status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY p.products_id DESC LIMIT 1,1");
						   
		$third_last_dt = $db->Execute("select p.products_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id ) 
                           where p.products_id = pd.products_id  and p.products_status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY p.products_id DESC LIMIT 2,1");	//  print_r($second_last_dt->fields['products_id']);
	   $second_last_product = $db->Execute("select pd.products_description,p.products_date_added,p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id ='".$second_last_dt->fields['products_id']."'
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
						   
		$third_last_product = $db->Execute("select pd.products_description,p.products_date_added,p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id ='".$third_last_dt->fields['products_id']."'
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");		
						 			   
						
?>
<?php 
                    	$cat_slide = "select * from ".DB_PREFIX."manufacturers ORDER BY RAND() LIMIT 5";
						$manufactureimage = $db->Execute($cat_slide); 						
?>
<?php 
	
	if ($this_is_home_page)
	{
?>				
<div id="mj-footertop">
	<div class="mj-subcontainer">
   
    	<div class="mj-brands mj-grid56 mj-lspace mj-rspace">
         <p style="float:left;margin: 17pt 0cm;" class="MsoNormal"><a href="https://www.ebay.com/str/patialaethnics"><img src="https://shopping.muteyaar.org/images/top_rated_seller.jpg" /><br /></a><font size="3" face="Arial,sans-serif"><b><a href="https://www.ebay.com/str/patialaethnics"> Visit our eBay Store !!</a></b></font>
        	<?php /*?><h3> Our Brands </h3>
						<ul>
                        	<?php 
							  while (!$manufactureimage->EOF) {
							  
								$manufacturers_image = $manufactureimage->fields['manufacturers_image'];
							?>
                        	<li><img src="images/<?php echo $manufacturers_image;?>" alt="" /></li>
                        	<?php $manufactureimage->MoveNext();
							}
							 ?>				
						</ul><?php */?>
		</div>
	       	
        <div class="mj-stayintouch mj-grid40 mj-lspace mj-rspace">
        		<h3>Stay In Touch</h3>
                <div class="mj-newsletter">
                        <a class="mj-newstext" href="index.php?main_page=page&id=35&pg=features">Join Our Newsletter</a>
                        <p>Stay Updated with Offers & New Arrivals</p>
                </div>
                <div class="mj-storelocator mj-lspace mj-rspace">
                    <a class="mj-storetext" href="index.php?main_page=page&id=21">Store Finder</a>
                    <p>Find store near to you</p>
                </div>
         	</div>
    </div>
</div> <?php } ?>

<div id="mj-footer">
	<div class="mj-subcontainer">
    	<div class="moduletable mj-grid24 mj-dotted">
        	<h3>Latest Products</h3>
            	<div class="custom mj-grid24 mj-dotted mj-latest">
                        <div class="mj-latestimage">
                         
                         <?php
						     $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);
						?>
                         <a href="<?php echo zen_href_link(zen_get_info_page($last_products->fields['products_id']), 'cPath=' . $productsInCategory[$last_products->fields['products_id']] . '&products_id=' . $last_products->fields['products_id']); ?>"><?php echo zen_image(DIR_WS_IMAGES . $last_products->fields['products_image'], rtrim(substr($last_products->fields['products_name'],0,40))."...", IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT); ?></a>
            			</div>
                            <div class="mj-productname"> <a href="<?php echo zen_href_link(zen_get_info_page($last_products->fields['products_id']), 'cPath=' . $productsInCategory[$last_products->fields['products_id']] . '&products_id=' . $last_products->fields['products_id']); ?>"><?php echo $last_products->fields['products_name']; ?></a></div>
                    		<div class="mj-productdescription"><p class="p.product_s_desc">
                            </p></div>
                        <ul class="mj-product"><li>
                   			<div class="mj-latestimage">
                        		 <?php
						     $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);
						?>
                         <a href="<?php echo zen_href_link(zen_get_info_page($second_last_product->fields['products_id']), 'cPath=' . $productsInCategory[$second_last_product->fields['products_id']] . '&products_id=' . $second_last_product->fields['products_id']); ?>"><?php echo zen_image(DIR_WS_IMAGES . $second_last_product->fields['products_image'], rtrim(substr($second_last_product->fields['products_name'],0,40))."...", IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT); ?></a>
            			</div>
                            <div class="mj-productname"> <a href="<?php echo zen_href_link(zen_get_info_page($second_last_product->fields['products_id']), 'cPath=' . $productsInCategory[$second_last_product->fields['products_id']] . '&products_id=' . $second_last_product->fields['products_id']); ?>"><?php echo $second_last_product->fields['products_name']; ?></a></div>
                    		<div class="mj-productdescription"><p class="p.product_s_desc"><?php /*?><?php echo rtrim(substr($second_last_product->fields['products_description'],0,40))."...";?>	<?php */?>	
                            </p>
                            </div>
                    	</li></ul> 	
                        <ul class="mj-product"><li>
                   			<div class="mj-latestimage">
                        		 <?php
						     $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);
						?>
                         <a href="<?php echo zen_href_link(zen_get_info_page($third_last_product->fields['products_id']), 'cPath=' . $productsInCategory[$third_last_product->fields['products_id']] . '&products_id=' . $third_last_product->fields['products_id']); ?>"><?php echo zen_image(DIR_WS_IMAGES . $third_last_product->fields['products_image'], rtrim(substr($third_last_product->fields['products_name'],0,40))."...", IMAGE_FEATURED_PRODUCTS_LISTING_WIDTH, IMAGE_FEATURED_PRODUCTS_LISTING_HEIGHT); ?></a>
            			</div>
                            <div class="mj-productname"> <a href="<?php echo zen_href_link(zen_get_info_page($third_last_product->fields['products_id']), 'cPath=' . $productsInCategory[$third_last_product->fields['products_id']] . '&products_id=' . $third_last_product->fields['products_id']); ?>"><?php echo $third_last_product->fields['products_name']; ?></a></div>
                    		<div class="mj-productdescription"><p class="p.product_s_desc"><?php /*?><?php echo rtrim(substr($third_last_product->fields['products_description'],0,40))."...";?><?php */?>		
                            </p>
                            </div>
                    	</li></ul>
               </div>
        </div>
    	<div class="moduletable mj-grid24 mj-dotted">
        	<h3> IMPORTANT LINKS</h3>
            	<div class="custom mj-grid24 mj-dotted">
                    <ul class="footer-bullet">
                    	<li><a href="index.php?main_page=page&id=17">About Us</a></li>
                        
                        <li><a href="index.php?main_page=page&id=5">Payment Options</a></li>
                        <li><a href="https://www.ebay.com/str/patialaethnics" target="_blank">Visit our eBay Store !!</a></li>
                       <li><a href="index.php?main_page=page&id=20" target="_blank">Cancelations, Returns & Refunds</a></li>
	
                                         <li><a href="index.php?main_page=page&id=18" target="_blank">Coupon partners</a></li>

                        <li><a href="<?php echo zen_href_link(FILENAME_CONDITIONS); ?>">Terms &amp; conditions</a></li>
                        <li><a href="<?php echo zen_href_link(FILENAME_PRIVACY); ?>">Privacy Policy</a></li>
       
                        <li><a href="<?php echo zen_href_link(FILENAME_SITE_MAP); ?>">Sitemap</a></li>
                 
                        <li><a href="<?php echo zen_href_link(FILENAME_SHIPPING); ?>">Delivery Information</a></li>
                        
                    </ul>
				</div>
        </div>
        <div class="moduletable mj-grid24 mj-dotted">
        	<h3>Get In Touch</h3>
            <div class="custom mj-grid24 mj-dotted">
                <div class="address">
                    <span class="small"><?php echo $address; ?></span>
                    <br/>
                    <a href="https://www.google.co.in/maps/place/Muteyaar/@30.3588634,76.3931684,13z/data=!4m5!1m2!2m1!1s5,+Ayurvedic+College+Road,+Patiala+-+147001+Punjab+INDIA+!3m1!1s0x391028f07518fbcd:0xf7690ee7479ab0cd?hl=en" target="_blank">Find Us On Map</a>
                </div>
                <div class="mail">
                    <span class="small">Email Us At:</span>
                    <br/>
                    <a href="mailto:support@domain.com"><?php echo $email_id; ?></a>
                </div>
                <div class="phone">
                    <span class="small"> Whatsapp:</span>
                    <br/>
                    <?php echo $phone_support; ?>
                </div>
                <div class="skype">
                    <span class="small">Talk to Us:</span>
                    <br/>
                    <?php echo $skype_id; ?>
                </div>
                <div class="social_icons">
<!--                     <a class="mj-linkedin" href="#">linkedin</a> -->
<!--                     <a class="mj-feed" href="#">RSS Feed</a> -->
                    <a class="mj-twitter" href="https://twitter.com/muteyaardotcom">Twitter</a>
                    <a class="mj-facebook" href="https://www.facebook.com/muteyaar">Facebook</a>
                    <a class="mj-instagram" href="https://www.instagram.com/muteyaar">Instagram</a>
                </div>
            </div>
        </div>
        <div class="moduletable mj-grid24 mj-dotted mj-rspace">
        	<h3> CUSTOMER REVIEW </h3>
            <div id="mj-payment">
  <?php   $review_status = " and r.status = 1 ";

  $random_review_sidebox_select = "select r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name,
                    substring(reviews_text, 1, 70) as reviews_text
                    from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, "
                           . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                    where p.products_status = '1'
                    and p.products_id = r.products_id
                    and r.reviews_id = rd.reviews_id
                    and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'
                    and p.products_id = pd.products_id
                    and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
                    $review_status;

 

  $random_review_sidebox_product = $db->ExecuteRandomMulti($random_review_sidebox_select,3); ?>
 
                  
   
                  <?php
				   $content .= '<a class="reviewimg" href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id']) . '">' . zen_image(DIR_WS_IMAGES . $random_review_sidebox_product->fields['products_image'], $random_review_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br />' . zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($random_review_sidebox_product->fields['reviews_text']))), 60) . '</a><br /><br />' . zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $random_review_sidebox_product->fields['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_review_sidebox_product->fields['reviews_rating'])); 
	  echo $content;?>
             
            </div>
        </div>
	</div>
</div>
    <div id="mj-copyright">
        <div class="mj-subcontainer">
                <div class="custom mj-grid88">
                    <p>&copy; <?php echo $copyright_text; ?></p>
                </div>
            
                <div class="custom mj-grid8">
                    <p>
                        <a id="w2b-StoTop" class="top" style="display: block;">Back to Top</a>
                    </p>
                </div>
        </div>
    </div>
</div>
<?php
} // flag_disable_footer
?>
<script>
window.addEventListener('load',function(){
if(window.location.href.indexOf('/index.php?main_page=checkout_confirmation') != -1){
(new Image()).src = '<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1041682243/?label=wC1ZCO399G0Qw57b8AM&guid=ON&script=0"/>';
}
});
</script>
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1041682243/?guid=ON&amp;script=0"/>


