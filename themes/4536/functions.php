<?php
/**
 * Main Functions
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

// Require Files.
require_once 'functions/_define.php';
require_once 'functions/_icons.php';
require_once 'functions/-init.php';
require_once '4536-setting/_init.php';
require_once 'css/_init.php';
require_once 'js/_init.php';

// Theme Update Checker.
require_once 'plugin-update-checker/plugin-update-checker.php';
$_my_update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/shinobiworks/4536/master/theme-update.json',
	__FILE__,
	'4536'
);

/**
 * Get Theme Version
 *
 * @return float
 */
function theme_version_4536() {
	return wp_get_theme( get_template() )->Version;
}
