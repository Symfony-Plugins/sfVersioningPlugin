<?php
  /**
   * Symfony VERSIONING Helper (see README for details)
   *
   * Author <piccioli@netseven.it>
   */

include_once(realpath(dirname(__FILE__)).'/../sfVersioningUtils.php');

// Return standard version string
function versioning_get() {
  return 'VERSION '._get_current_version().' RELEASE DATE '.date('Y-m-d H:i',_get_current_date());
}

// Return a link for MANTIS bugtracker bug report
function versioning_mantis_link_to($mantis_url,$label='BUG'){

  $url = $mantis_url;
  
  $application = SF_APP;
  $module = sfContext::getInstance()->getModuleName();
  $action = sfContext::getInstance()->getActionName();
  $version = _get_current_version() ;
    
  $sf_uri = $application . '/' . $module . '/' . $action ;

  $summary = $sf_uri ;
  $description = $sf_uri ;
  $absolute_uri = 'http://'. 
    $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  
  $additional_info = 
    'URL         -> ' . $absolute_uri . '%0A' . 
    'VERSION     -> ' . $version . '%0A' . 
    'APPLICATION -> ' . $application . '%0A' . 
    'MODULE      -> ' . $module . '%0A' . 
    'ACTION      -> ' . $action ; 

  $url.='?summary='.$summary ;
  $url.='&description='.$description ;
  $url.='&additional_info='.$additional_info ;
  
  return link_to($label,$url,'target=blank') ;

}

// Return all versions (hash)
function versioning_get_versions() {
  
}

?>

