<?php /*@Hilary Albutt code to set up plugin - needs more work.
This is the LibraryDataStore plugin to be built and to be added to the special &copy 'knowtree' wordpress theme
I want to make the installation more interactive so that librarians can add thier own custon fields
and add to the extensive listing to be autmatically installed and used with an optional bar code scanner*/



global $Lib_db_version;
$Lib_db_version = "0.1";

function Lib_install() {
   global $wpdb;
   global $Lib_db_version;

   $table_name = $wpdb->prefix . "LibraryDataStore";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name tinytext NOT NULL,
  text text NOT NULL,
  url VARCHAR(55) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
    );";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
 
   add_option("Lib_db_version", $Lib_db_version);


/*3*-+0// get_currentuserinfo, get_userdata, get_userdatabylogin, wp_mail,wp_login, auth_redirect, wp_redirect, wp_setcookie, wp_clearcookie,
// wp_notify_postauthor, wp_notify_moderator*/

function Lib_install_data() {
   global $wpdb;
   get_currentuserinfo()  = $user;
   $welcome_name = $user;
   $welcome_text = "Congratulations, you just completed the installation!";

   $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
}

register_activation_hook(__FILE__,'Lib_install');
register_activation_hook(__FILE__,'Lib_install_data');

global $wpdb;
   $installed_ver = get_option( "Lib_db_version" );
  if( $installed_ver != $Lib_db_version ) {

      $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name tinytext NOT NULL,
  text text NOT NULL,
  url VARCHAR(100) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      update_option( "Lib_db_version", $Lib_db_version );
  }


function myplugin_update_db_check() {
    global $Lib_db_version;
    if (get_site_option('Lib_db_version') != $Lib_db_version) {
        Lib_install();
    }
}
add_action('plugins_loaded', 'myplugin_update_db_check');








;?>
