<?php

function get_db_table_record( $table, $id ) {
  global $wpdb;
  $query = $wpdb->prepare("
    SELECT *
    FROM $table
    WHERE id = %d
    ", $id );
  $record = $wpdb->get_row( $query );
  return $record;
}

function insert_db_table_record( $table, $data, $format = null ) {
  global $wpdb;
  $wpdb->insert( $table, $data, $format );
}

function update_db_table_record( $table, $data, $where, $format = null, $where_format = null ) {
  global $wpdb;
  $wpdb->update( $table, $data, $where, $format, $where_format );
}

function delete_db_table_record( $table, $where, $where_format = null ) {
  global $wpdb;
  $wpdb->delete( $table, $where, $where_format );
}

//-------------------リファレンス----------------------------//
// https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wpdb_Class
//--------------------------------------------------------//
