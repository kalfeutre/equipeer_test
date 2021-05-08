<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

if (!session_id()) session_start();

/**
 * increase PHP Time Limit for WordPress
 * code samples mean 300 seconds
 *
 * Increasing PHP Time Limit via PHP.ini file
 * max_execution_time = 300;
 *
 * Increasing PHP Time Limit through wp-config.php
 * set_time_limit(300);
 *
 * Modifying the .htaccess file
 * max_execution 300
 */
set_time_limit(300);
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'equipeer_com' );
/** MySQL database username */
define( 'DB_USER', 'equipeercomuserdb' );
/** MySQL database password */
define( 'DB_PASSWORD', 'njJj572*!L@t67' );
/** MySQL hostname */
define( 'DB_HOST', 'localhost' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'q?Tyr*8|O&McPf OC?wNGd6iRn9LBlHp1w~_SySQ1WKA(jlFM;3>)-U$sXz0J}tQ' );
define( 'SECURE_AUTH_KEY',  '(0cjAV`N#rv,(>4H+(ADQt8l@k%BOm(uR=. ni%j@c8^;y`LJ=%_q*[1_WlPF3)O' );
define( 'LOGGED_IN_KEY',    'RW`tXv-n`x!rS-0s7zYgG][TiT],p4/[!AFWM6|{z}1:PGdY=7yud)Hix: JzG4:' );
define( 'NONCE_KEY',        '|PFBd4o>68RZ2 q;/J2,}kYp!2i53bGXK+!m?a~$lqRr~QWj@ JrGj6s?`Jc,}IV' );
define( 'AUTH_SALT',        '#gB1U4r)G|_lRSk&l8J30LGPJP@`!tq{5GP$x*K!;{WK,=W?ZL|?uXc#ROAia(Bu' );
define( 'SECURE_AUTH_SALT', '|+;{+fud4TTKVUHqeo_PX3#drvQmTtT=)$}L7)dd0C3SiN-Dn{mJ3{!Y%sW==U}A' );
define( 'LOGGED_IN_SALT',   'Tf@B/4I+cd E [wMr>iTiu#dC^Vd(fYO$0J67fS<)t0;d/%8_J,`JrIy#4N.%LTu' );
define( 'NONCE_SALT',       '9?&(6ja({d3_Q}2i-=a+v+WZM/%M[NdC` %*XIc!rNS.3U/SGX}T;+dm`:]mA8sj' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '74KowpPOi_';

/**
 * Require SSL for Admin and Logins
 */
define( 'FORCE_SSL_ADMIN', true ); // true | false

/**
 * Default EQUIPEER Url / Dir
 */
define( 'WP_DEFAULT_EQUIPEER_URL', 'https://equipeer.com' );
define( 'WP_DEFAULT_EQUIPEER_DIR', '/var/www/vhosts/equipeer.com/httpdocs' );

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false ); // true | false
if ( WP_DEBUG ) {
	// ------------------------------------------------------------------------------------
	// ------------------------------------------------------------------------------------
	// Activer l'enregistrement de débogage dans le fichier /wp-content/debug.log
	define('WP_DEBUG_LOG', true); // true | false
	// Activer l'affichage des erreurs et des alertes 
	define('WP_DEBUG_DISPLAY', true); // true | false
	@ini_set('display_errors', 1);
	// Utiliser les versions de dev des fichiers JS et CSS du noyau (nécessaire seulement si vous modifiez ces fichiers)
	define('SCRIPT_DEBUG', true); // true | false
	// Activer la Concaténation Javascript
	define('CONCATENATE_SCRIPTS', false); // true | false
	// ------------------------------------------------------------------------------------
	// ------------------------------------------------------------------------------------
} else {
	// ------------------------------------------------------------------------------------
	// ------------------------------------------------------------------------------------
	// Désactiver l'enregistrement de débogage dans le fichier /wp-content/debug.log
	define('WP_DEBUG_LOG', false); // true | false
	// Désactiver l'affichage des erreurs et des alertes 
	define('WP_DEBUG_DISPLAY', false); // true | false
	@ini_set('display_errors', 0);	
	// Utiliser les versions de dev des fichiers JS et CSS du noyau (nécessaire seulement si vous modifiez ces fichiers)
	define('SCRIPT_DEBUG', false); // true | false
	// Désactiver la Concaténation Javascript
	define('CONCATENATE_SCRIPTS', true); // true | false
	// ------------------------------------------------------------------------------------
	// ------------------------------------------------------------------------------------
}

/*
 * SAUVEGARDER LES REQUÊTES POUR ANALYSE
 * ----------------------
 * Sauvegarde les requêtes de la base de données dans un tableau
 * Cela permet de sauvegarder chaque requête, la fonction appelante et le temps d'exécution
 * ----------------------
 * Mettre dans le pied de page
 * <?php
 * if (current_user_can('administrator') && SAVEQUERIES) {
 *   global $wpdb;
 *   echo "<pre>";
 *   print_r($wpdb->queries);
 *   echo "</pre>";
 * }
 * ?>
 */
define( 'SAVEQUERIES', false ); // true | false

/*
 * CACHE
 * ----------------------
 * Lorsque le paramètre WP_CACHE, a la valeur true,
 * il charge le script wp-content/advanced-cache.php, lors de l'exécution de wp-settings.php
 */
define( 'WP_CACHE', false ); // true | false

/*
 * DÉSACTIVER L’ÉDITEUR D'EXTENSIONS ET DE THÈMES
 * ----------------------
 *  La désactivation de celles-ci fournit également une couche de sécurité supplémentaire
 *  si un pirate parvenait à accéder à un compte utilisateur privilégié
 */
define( 'DISALLOW_FILE_EDIT', true ); // true | false

/*
 * DÉSACTIVER L’INSTALLATION D'EXTENSIONS ET DE THÈMES
 * ----------------------
 * Cela permet de bloquer la capacité des utilisateurs à utiliser les fonctionnalité d'installation / mise à jour des
 * extensions et thèmes du tableau de bord WordPress. La définition de cette constante désactive également l'éditeur
 * d'extensions et de thèmes (vous n'avez donc pas besoin de définir DISALLOW_FILE_MODS et DISALLOW_FILE_EDIT,
 * DISALLOW_FILE_MODS aura le même effet)
 */
define( 'DISALLOW_FILE_MODS', false ); // true | false

/*
 * AUGMENTER LA MÉMOIRE ALLOUÉE À PHP
 * ----------------------
 *  WP_MEMORY_LIMIT vous autorise à définir une quantité maximum de mémoire pouvant être utilisée par PHP.
 *  Ce paramétrage peut être nécessaire lorsque vous recevez un message du type "Allowed memory size of xxxxxx bytes exhausted"
 */
define( 'WP_MEMORY_LIMIT', '256M' ); // Size

/**
 * Memory Limit (Administration)
 * Administration tasks require much memory than usual operation.
 * When in the administration area, the memory can be increased
 * or decreased from the WP_MEMORY_LIMIT by defining WP_MAX_MEMORY_LIMIT
 */
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/*
 * MODIFIER L'INTERVALLE DE SAUVEGARDE AUTOMATIQUE
 * ----------------------
 * WordPress utilise Ajax pour faire des sauvegardes automatique de l'article que vous modifiez.
 * Si vous pourriez avoir envie d'augmenter le délai entre 2 sauvegardes, ou au contraire le diminuer pour être sûr
 * de na pas perdre de changements. Le durée est par défaut de 60 secondes
 * https://www.inmotionhosting.com/support/website/wordpress/disable-wordpress-autosave/
 */
define( 'AUTOSAVE_INTERVAL', 86400 );  // secondes

/**
 * Cleanup Image Edits
 * By default, WordPress creates a new set of images every time you edit an image
 * and when you restore the original, it leaves all the edits on the server.
 * Defining IMAGE_EDIT_OVERWRITE as true changes this behaviour.
 * Only one set of image edits are ever created and when you restore the original,
 * the edits are removed from the server
 */
define( 'IMAGE_EDIT_OVERWRITE', true );

/*
 * DÉSACTIVER LE CRON WP
 * ----------------------
 * https://www.inmotionhosting.com/support/website/wordpress/disabling-the-wp-cronphp-in-wordpress/
 */
//define('DISABLE_WP_CRON', false); // true | false

/**
 * Disable Cron Timeout
 * Make sure a cron process cannot run more than once every WP_CRON_LOCK_TIMEOUT seconds.
 */
define( 'WP_CRON_LOCK_TIMEOUT', 60 ); // Seconds

/**
 * Redirect Nonexistent Blogs
 * NOBLOGREDIRECT can be used to redirect the browser if the visitor tries to access a nonexistent subdomain or a subfolder
 */
define( 'NOBLOGREDIRECT', WP_DEFAULT_EQUIPEER_URL );

/*
 * VIDER LA CORBEILLE
 * ----------------------
 * Cette constante contrôle le nombre de jour avant que WordPress ne détruise de façon permanente articles, pages, pièces-jointes, et commentaires, de la poubelle
 * Par défaut, cette valeur est de 30 jours
 * Pour désactiver la corbeille, mettez le nombre de jours à zéro.
 * Notez que WordPress ne demandera pas de confirmation lorsque quelqu'un cliquera sur "Supprimer définitivement". 
 */
define( 'EMPTY_TRASH_DAYS', 10 );  // Default 30 days

/*
 * LIMITER LES RÉVISIONS
 * ----------------------
 * define('WP_POST_REVISIONS', false); // Aucune révision
 * define('WP_POST_REVISIONS', 5);     // Nombre maximum de révision
 */
define( 'WP_POST_REVISIONS', 3 ); // false | nombres

/*
 * OPTIMISATION AUTOMATIQUE DE LA BASE DE DONNÉES
 * ----------------------
 * Support de l'optimisation automatique de la base de données,
 * pouvant être activée en ajoutant la ligne ci-dessous dans votre fichier wp-config.php file uniquement lorsque la fonctionnalité est nécessaire
 */
define( 'WP_ALLOW_REPAIR', false ); // true | false

/*
 * NE PAS METTRE À JOUR LES TABLES GLOBALES
 * ----------------------
 * Les sites ayant de volumineuses tables globales (particulièrement users et usermeta), ainsi que les sites partageant
 * leur table user avec bbPress et d'autres installations WordPress peuvent empêcher la modification de ces tables lors
 * de la mise à jour en définissant DO_NOT_UPGRADE_GLOBAL_TABLES. Étant donné qu'une instruction ALTER,
 * DELETE ou UPDATE, peut prendre beaucoup de temps avant de se terminer, les sites importants veulent
 * habituellement éviter qu'elles ne s'exécutent pendant la mise à jour pour le faire eux-mêmes. En outre, si les
 * installations se partagent les tables utilisateurs entre plusieurs installations bbPress et WordPress, il peut être
 * nécessaire de vouloir définir un site comme étant le maître des mises à jour. 
 */
define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true ); // true | false

/**
 * Disable WordPress Auto Updates
 * There might be reason for a site to not auto-update, such as customizations or host supplied updates.
 * It can also be done before a major release to allow time for testing on a development
 * or staging environment before allowing the update on a production site
 */
define( 'AUTOMATIC_UPDATER_DISABLED', true ); // true | false

/**
 * Disable WordPress Core Updates
 * # Disable all core updates:
 * define( 'WP_AUTO_UPDATE_CORE', false );
 * # Enable all core updates, including minor and major:
 * define( 'WP_AUTO_UPDATE_CORE', true );
 * # Enable core updates for minor releases (default):
 * define( 'WP_AUTO_UPDATE_CORE', 'minor' );
 */
define( 'WP_AUTO_UPDATE_CORE', false );

/*
 * DÉPLACER LE RÉPERTOIRE "UPLOADS"
 * pas de slash à la fin
 */
define( 'UPLOADS', 'medias' );

/*
 * DÉPLACER LE RÉPERTOIRE "PLUGINS"
 * pas de slash à la fin
 */
define( 'WP_PLUGIN_DIR', WP_DEFAULT_EQUIPEER_DIR . '/modules' );
define( 'WP_PLUGIN_URL', WP_DEFAULT_EQUIPEER_URL . '/modules');

/*
 * DÉPLACER LE RÉPERTOIRE "LANGUAGES"
 * pas de slash à la fin
 */
define( 'WP_LANG_DIR', WP_DEFAULT_EQUIPEER_DIR . '/langs' );

/*
 * DÉPLACER LE RÉPERTOIRE WP-CONTENT
 * pas de slash à la fin
 */
define( 'WP_CONTENT_DIR', WP_DEFAULT_EQUIPEER_DIR . '/datas' );
define( 'WP_CONTENT_URL', WP_DEFAULT_EQUIPEER_URL . '/datas');

define( 'ALLOW_UNFILTERED_UPLOADS', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
