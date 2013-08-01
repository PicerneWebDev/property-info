<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   PropertyInfo
 * @author    Jonathan Rivera <jrivera@picernefl.com>
 * @license   GPL-2.0+
 * @link      http://www.picernerealestategroup.com
 * @copyright 2013 Picerne Real Estate Group.
 */
 

?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	
	<!-- TODO: Provide markup for your options page here. -->
    <p>Welcome to the Property Information administration area. In order for the <strong><?php echo get_bloginfo('name');?></strong> Website to function as needed it is necessary to fill out the fields below prior to launching the site.</p>
    
    
    <?php $this->prop_info_form(); //Display the form?>

</div>
