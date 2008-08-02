<?php
  /**
   * Syfmony VERSIONING Utils (see README for details)
   *
   * Author <piccioli@netseven.it>
   */

function _retrieve_current_version() {
  $versions_file=_get_current_version_file();
  if (!file_exists($versions_file)){
    return array();
  }
  else {
    $fp=fopen($versions_file,'r');
    $contents = fread($fp, filesize($versions_file));
    fclose($fp);
    return unserialize($contents);
  }
}

function _retrieve_existing_versions() {
  $versions_file=_get_versions_file();
  if (!file_exists($versions_file)){
    return array();
  }
  else {
    $fp=fopen($versions_file,'r');
    $contents = fread($fp, filesize($versions_file));
    fclose($fp);
    return unserialize($contents);
  }
}

function _get_versions_file() {
  return realpath(dirname(__FILE__).'/../web').'/VERSIONS';
}

function _get_current_version_file() {
  return realpath(dirname(__FILE__).'/../web').'/CURRENT_VERSION';
}

// Return current version
function _get_current_version() {
  $current_version_arr = _retrieve_current_version() ;
  if (count($current_version_arr)==0) {
    return 'NONE';
  }
  $keys = array_keys($current_version_arr) ;
  return $keys[0] ;
}

// Return current relase date
function _get_current_date() {
  $current_version_arr = _retrieve_current_version() ;
  if (count($current_version_arr)==0) {
    return '0';
  }
  $keys = array_keys($current_version_arr) ;
  return $current_version_arr[$keys[0]]['time'] ;
}


