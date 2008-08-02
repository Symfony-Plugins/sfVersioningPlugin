<?php
  /**
   * Syfmony VERSIONING Task (see README for details)
   *
   * Author <piccioli@netseven.it>
   */

include_once(realpath(dirname(__FILE__).'/../../lib').'/sfVersioningUtils.php');

pake_desc('List all version of the project');
pake_task('version-list','project_exists');

pake_desc('Create new version of the project (do not forget to perform svn staff first)');
pake_task('version-create-new','project_exists');

function run_version_list($task,$args)
{
  _version_header() ;
  $versions=_retrieve_existing_versions();
  
  if (count($versions)<=0) {
    pake_echo_comment('Warning: no versions present. Create one with command symfony version-create-new');
  }
  else {
    foreach($versions as $version => $info ){
      pake_echo ("VERSION $version :");
      pake_echo ('       Release date:'.date('Y-m-d H:i',$info['time']));
      pake_echo ('       Comment:     '.$info['comment']);
      pake_echo ('');
    }
    
    $current_version=_retrieve_current_version();
    foreach($current_version as $version => $info ){
      pake_echo ("CURRENT VERSION $version :");
      pake_echo ('       Release date:'.date('Y-m-d H:i',$info['time']));
      pake_echo ('       Comment:     '.$info['comment']);
      pake_echo ('');
    }
    
  }

}

function run_version_create_new($task,$args)
{

  _version_header() ;

  // Check parameters
  if (!isset($args[0])) {
    throw new Exception('You must provide a version number');
  }
  $new_version=$args[0];

  if ( !isset($args[1]) ) {
    pake_echo_comment('WARNING: no comment given, set to default') ;
    $comment = 'Created version '.$new_version ;
  }
  else {
    $comment = $args[1] ;
  }

  // Retrieve existing versions
  $versions=_retrieve_existing_versions();

  // Check if version already exists
  if (array_key_exists($new_version,$versions)) {
    throw new Exception('Version '.$new_version.' already exists. Provide a new version.');
  }

  pake_echo_action('new-version','Adding new version '.$new_version.' to the project');
  
  $time=time();

  $info = array('version'=>$new_version,
		'time'=>$time,
		'comment'=>$comment
		);

  $current_version=array($new_version=>$info);

  $versions[$new_version]=$info;
  
  //WRITE NEW VERSIONS FILE
  $file=_get_versions_file();
  pake_echo_action('file+',$file);
  $fp=fopen($file,'w');
  fwrite($fp,serialize($versions));
  fclose($fp);

  //WRITE CURRENT VERSION FILE
  $file=_get_current_version_file();
  pake_echo_action('file+',$file);
  $fp=fopen($file,'w');
  fwrite($fp,serialize($current_version));
  fclose($fp);

}

function _version_header() {
  pake_echo('');
  pake_echo('********************************');
  pake_echo('*                              *');
  pake_echo('* sfVersionPlugin              *');
  pake_echo('* author: Alessio Piccioli     *');
  pake_echo('* mailto: piccioli@netseven.it *');
  pake_echo('*                              *');
  pake_echo('* See README for details       *');
  pake_echo('*                              *');
  pake_echo('********************************');
  pake_echo('');
  pake_echo('');
}

