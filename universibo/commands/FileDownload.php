<?php    

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * FileDownload: si occupa del download di un file
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class FileDownload extends UniversiboCommand {

	function execute() 
	{
		
		if (!array_key_exists('id_file', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_file'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id del file richiesto non � valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();
		$user =& $this->getSessionUser();
		
		$file =& FileItem::selectFileItem($_GET['id_file']);

		if ($file === false) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il file richiesto � stato eliminato o non � disponibile','file'=>__FILE__,'line'=>__LINE__ ));
		
		$template->assign('fileDownload_InfoURI', 'index.php?do=FileShowInfo&id_file='.$file->getIdFile());

		if ($user->isGroupAllowed( $file->getPermessiDownload() ))
		{
	        $directoryFile = $frontcontroller->getAppSetting('filesPath');
	        //$directoryFileUri = $frontcontroller->getAppSetting('directoryFileUri');
			
			$nomeFile = $directoryFile.$file->getIdFile().'_'.$file->getNomeFile();
			//echo $nomeFile;die();
			
			if (!file_exists($nomeFile)) 
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Impossibile trovare il file richiesto, contattare l\'amministratore del sito','file'=>__FILE__,'line'=>__LINE__ ));
			if ( md5_file($nomeFile) != $file->getHashFile() ) 
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il file richiesto risulta corrotto, contattare l\'amministratore del sito','file'=>__FILE__,'line'=>__LINE__ ));
			
			if ( $file->getPassword() != null)
			{
				if (!array_key_exists('f11_submit', $_POST))
				{
					$this->executePlugin('ShowTopic', array('reference' => 'filesutenti'));
					return 'file_download_password';
				}

				if  (!array_key_exists('f11_file_password', $_POST))
					Error::throw(_ERROR_DEFAULT,array('msg'=>'Il form inviato non � valido','file'=>__FILE__,'line'=>__LINE__ ));
					
				if  ($file->getPassword() != FileItem::passwordHashFunction($_POST['f11_file_password']))
				{
					Error::throw(_ERROR_NOTICE,array('msg'=>'La password inviata � errata','file'=>__FILE__,'line'=>__LINE__,'log' => false, 'template_engine' => & $template  ));
					$this->executePlugin('ShowTopic', array('reference' => 'filesutenti'));
					return 'file_download_password';
				}
			}
				
			
			$file->addDownload();
			
			if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) 
			{
				// had to make it MSIE 5.5 because if 6 has no "attachment;"
				// in it defaults to "inline"
				$attachment = "";
			}
			else
			{
				$attachment = "attachment;";
			}
			header('Content-Type: application/octet-stream');
			header('Cache-Control: private');
			header('Pragma: dummy-pragma');
			header("Expires: ". gmdate("D, d M Y H:i:s")." GMT"); // Date in the past
			header("Last-Modified: ". gmdate("D, d M Y H:i:s")." GMT"); // always modified
			header("Content-Length: ". @filesize($nomeFile));
			////header("Content-type: application/force-download");
			header("Content-type: application/octet-stream");
			header("Content-Transfer-Encoding: binary");
			header("Content-disposition: $attachment filename=".basename($nomeFile));
			
			//echo $nomeFile; 
			readfile($nomeFile);
			
			/**
			 * @todo ...da togliere die() dopo che si � messo on-line e tolto il tempo di esecuzione a fondo pagina
			 */
						
			exit();
			
			return;
			
		}
		
		
		if ($user->isOspite() )
		{
			Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non � permesso eseguire il download del file', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			$this->executePlugin('ShowTopic', array('reference' => 'filesutenti'));
			return 'file_download_iscriviti';
		}

		Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Non � permesso eseguire il download del file.
		Non possiedi i diritti necessari.', 'file' => __FILE__, 'line' => __LINE__, 'log' => true));
		
	}

}

?>