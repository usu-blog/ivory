<?php
/**
 * Require Class Files
 *
 * @package    WordPress
 * @category   Theme
 * @subpackage 4536
 * @author     Chef
 * @license    https://www.gnu.org/licenses/gpl-3.0.html/ GPL v2 or later
 * @link       https://4536.jp/
 * @since      1.0.0
 */

// Extend Walker Class.
require_once 'class-walker-category-checklist-widget.php';

// Review Settings.
require_once 'class-review.php';
$review_class = new SHINOBI_WORKS\Review();
add_action( 'init', [ $review_class, '__construct' ] );

// HTML Sitemap Settings.
require_once 'class-html-sitemap-custom-fields.php';
$html_sitemap = new Html_Sitemap_Custom_Fields();
add_action( 'init', [ $html_sitemap, '__construct' ] );
