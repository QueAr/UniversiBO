<?php

list($usec, $sec) = explode(" ", microtime());
$page_time_start = ((float)$usec + (float)$sec);


/**
 * The receiver. 
 * Code to activate the framework system.
 * One application can be built by multiple receivers.
 * 
 * @package framework
 * @version 1.0.0
 * @author Deepak Dutta, http://www.eocene.net, 
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Receiver{

	var $frameworkPath = '../framework';
	var $applicationPath = '../universibo';

	var $configFile = '../config.xml';
	var $receiverIdentifier = 'main';
	
	
	/**
	 * Costruttore del Receiver
	 *
	 * @param string $identifier indentifier of receiver
	 * @param string $config_file configuration file for this receiver (applicatio)
	 * @param string $framework_path percorso in cui si trovano i file del framework
	 * @param string $application_path percorso in cui si trovano i file dell'applicazione
	 */
	function Receiver($identifier, $config_file, $framework_path, $application_path)
	{
		$this->frameworkPath = $framework_path;
		$this->applicationPath = $application_path;

		$this->configFile = $config_file;
		$this->receiverIdentifier = $identifier;
	}
	
	
	
	/**
 	* Return the receiver name identifier
 	*
 	* @return string
	*/
	function getIdentifier()
	{
		return $this->receiverIdentifier;
	}
	
	
	
	
	/**
 	* Set PHP language settings (path, gpc, error_reporting)
	*/
	function _setPhpEnvirorment()
	{
		
		//error reporting activation (enabled on testing system)
		error_reporting(E_ALL); 

		//output buffering
		//ob_start('ob_gzhandler');

		//session initialization
		session_start();
		if (!array_key_exists('SID',$_SESSION) )
		{
			$_SESSION['SID'] = SID;
		}
				
		$pathDelimiter=( strstr($_SERVER['SERVER_SOFTWARE'], 'Unix') ) ? ':' : ';' ;
		//$pathDelimiter=( strstr(strtoupper($_ENV['OS']),'WINDOWS') ) ? ';' : ':' ;
		ini_set('include_path', $this->frameworkPath.$pathDelimiter.$this->applicationPath.'/classes'.$pathDelimiter.ini_get('include_path'));
		
		if ( get_magic_quotes_runtime() == 1 )
		{
			 set_magic_quotes_runtime(0);
		} 
		
		//php files extension, can ben modified to externally hide php files
		define ('PHP_EXTENSION', '.php');
		
		
	}
	
	
	/**
 	* Main code for framework activation, includes Error definitions
 	* and instantiates FrontController
	*/
	function main()
	{
		$this->_setPhpEnvirorment();
				
		include_once('FrontController'.PHP_EXTENSION);
		$fc= new FrontController($this);
		
		$fc->setConfig( $this->configFile );
		
		$fc->executeCommand();
		
	}

}


$receiver = new Receiver('main', '../config.xml', '../framework', '../universibo');
$receiver->main();


list($usec, $sec) = explode(" ", microtime());
$page_time_end = ((float)$usec + (float)$sec);

printf("%01.5f", $page_time_end - $page_time_start);

?>


