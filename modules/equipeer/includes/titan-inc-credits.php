<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's options                  -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// ----------------------------------------
// --- Security Options -------------------
// ----------------------------------------
$informatux_url     = '<a href="https://informatux.com/" target="_blank">INFORMATUX</a>';
$informatux_support = '<a href="https://informatux.com/contact" target="_blank">INFORMATUX</a>';
$informatux_contact = '<a href="https://informatux.com/contact" target="_blank">Contact INFORMATUX</a>';
// ----------------------------------------
$credits->createOption( array(
	'name' => __( 'CREDITS', EQUIPEER_ID ) . ' <br /><i> ' . EQUIPEER_ID . '<i>',
	'type' => 'note',
	'desc' => '<img width="96" height="96" class="informatux-credits" src="' . EQUIPEER_URL . 'assets/images/informatux-avatar.png" alt=""><br>' . __( 'Developed and maintained by', EQUIPEER_ID ) . ' ' . $informatux_url . '<br>' . __( 'Written with ', EQUIPEER_ID ) . 'PHP (POO) & <a href="http://www.titanframework.net/" target="_blank">Titan Framework</a>'
) );
// ----------------------------------------
$credits->createOption( array(
	'name' => __( 'SUPPORT', EQUIPEER_ID ) . ' <br /><i> ' . EQUIPEER_ID . '<i>',
	'type' => 'note',
	'desc' => '<img width="96" height="96" class="informatux-support" src="' . EQUIPEER_URL . 'assets/images/informatux-support.png" alt="EQUIPEER support">' . __( 'Support contact', EQUIPEER_ID ) . ' ' . $informatux_support . '<br>' . __( "Need more features on this plugin? Don't hesitate to contact us here", EQUIPEER_ID ) . ' ' . $informatux_support .  '<br>' . __( "Need a plugin for Wordpress? Don't hesitate to contact us here", EQUIPEER_ID ) . ' ' . $informatux_support . '<br>' . __( 'To contact us, You have to indicate us all the informations of your wordpress installation (Version Number WP, Version number Icustomizer, Server)', EQUIPEER_ID ) . '<br><br><a class="informatux-support-other-plugins" target="_blank" href="' . get_admin_url(get_current_blog_id(), 'plugin-install.php?s=informatux&tab=search&type=term') . '">&dzigrarr; ' . __( "If you would like to use our other plugins, click here ", EQUIPEER_ID ) . '</a>'
) );
// ----------------------------------------
$credits->createOption( array(
	'name' => __( 'SERVICES', EQUIPEER_ID ) . ' <br /><i> ' . $informatux_url . '<i>',
	'type' => 'note',
	'desc' => '<div class="informatux_outerdiv">

  <div class="informatux_outer">
      <img src="https://informatux.com/data/uploads/giphy/informatux-securite-wp.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">' . __( 'SECURITY', EQUIPEER_ID ) . '</div>
      <div>
        <p class="informatux_p_services">' . __( "Tired of your WORDPRESS sites being attacked", EQUIPEER_ID ) . '<br>
        ' . __( "Too complicated to put back", EQUIPEER_ID ) . '<br>
        '. $informatux_contact . '
        </p>       
      </div>
  </div>
  
  <div class="informatux_outer">
      <img src="https://informatux.com/data/uploads/giphy/informatux-installation-wordpress.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">INSTALLATION</div>
      <div>
        <p class="informatux_p_services">Wordpress / WooCommerce<br>
        ' . __( 'Wordpress Themes', EQUIPEER_ID ) . '<br>
        ' . __( 'Web Hosting', EQUIPEER_ID ) . '<br>
        ' . __( 'Manage your WP sites by ANDROID / APPLE application', EQUIPEER_ID ) . '<br>
        '. $informatux_contact . '</p>
      </div>
  </div>
  
  <div class="informatux_outer informatux_last">
      <img src="https://informatux.com/data/uploads/giphy/informatux-maintenance.gif" class="informatux_gs_image" alt="">
      <div class="informatux_centered">' . __( 'MAINTENANCE', EQUIPEER_ID ) . '</div>
      <div>
        <p class="informatux_p_services">' . __( 'No time', EQUIPEER_ID ) . '<br>
        ' . __( 'No envy', EQUIPEER_ID ) . '<br>
        ' . __( 'Too complicated', EQUIPEER_ID ) . '<br>
        '. $informatux_contact . '
        </p>       
      </div>
  </div>

</div>'
) );