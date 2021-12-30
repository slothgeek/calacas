<?php
/**
 * Plugin Name: Baum Festival
 * Plugin URI:
 * Description: ''
 * Version: 1.1
 * Author: Jorge Castrillo
 * Author URI: https://www.slothgeek.com
 * Text Domain: bf
 */
define( 'BF_PATH', plugin_dir_path( __FILE__ ) );
define( 'BF_URL', plugin_dir_url( __FILE__ ) );

require_once BF_PATH . 'classes/BF_Festival.php';
require_once BF_PATH . 'classes/BF_Evento.php';
require_once BF_PATH . 'classes/BF_Artista.php';
