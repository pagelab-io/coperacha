<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'coperacha');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 't2Njm,|>J&~-(C<SaoE zFMV0`#1A1CXM7=D.tR6m|LaJvP(b@ZK;WKnOwf1G7(I');
define('SECURE_AUTH_KEY', 'xN1EGxw>NW41i^5a|MC9K/,S~P#^ #LjrPTv&ES6/S|$P-[g~oB9b>>X,DGDMGfP');
define('LOGGED_IN_KEY', ',./|ghy2ISW|mjd=EOB%L@Ma5KA1!W8Ur^f%j92t9 rK!ecL::<K:#/.CSmK^Da%');
define('NONCE_KEY', 'z5QE g:6f2H.3&>9OnQaLDRamw,HRd?(Ox4WPs75>6y%8I0..Tnj>9VerLRvIBC_');
define('AUTH_SALT', 'rMNKSBa/l#(B^//qVv eY5?y#8XA`_ABwND:b!{/3{dscT(vqELHNrU.gqa(fflT');
define('SECURE_AUTH_SALT', 'X3baeZJ0{:-XKqB/,A+i@aVU{G2Uc8,oD1.LjiMd[|?y;~<;P+UR*Nh&}7mINZGg');
define('LOGGED_IN_SALT', 'q7/Y{{c6>; -;FadaWSxxPl0oGByK:as5%>_@5No&6nT9Vw1]SVl`0/^g R.gS|>');
define('NONCE_SALT', 'Go:*8o@h|m.%Q+ttI$fcXTdMmR%*MbZDjb>`=QS%O7NIe~jq0tR%sfG?[vbaoEFQ');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

