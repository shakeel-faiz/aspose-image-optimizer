<?php

if (!defined("WP_UNINSTALL_PLUGIN")) {
    die();
}

global $wpdb;

// Delete AsposeImagingConverter Dir Images table.
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}asposeimagingconverter_dir_images" );

// Delete AsposeImagingWebP_dir_images Dir Images table.
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}AsposeImagingWebP_dir_images" );
