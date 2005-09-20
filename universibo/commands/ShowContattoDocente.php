<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Docente'.PHP_EXTENSION);
require_once ('Canale'.PHP_EXTENSION);
require_once ('User'.PHP_EXTENSION);
require_once ('Collaboratore'.PHP_EXTENSION);
require_once ('ContattoDocente'.PHP_EXTENSION);


/**
 * ShowContacts is an extension of UniversiboCommand class.
 *
 * It shows Contacts page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.2.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowContattoDocente extends UniversiboCommand {
	
	function execute()
	{
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$user =& $this->getSessionUser();
		
		if (!array_key_exists('id_utente',$_GET) && !ereg( '^([0-9]{1,10})$' , $_GET['id_utente'] ) ) 
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'L\'utente cercato non � valido','file'=>__FILE__,'line'=>__LINE__)); 
		
		if (!$user->isCollaboratore() && !$user->isAdmin())
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'Non hai i diritti necessari per visualizzare la pagina','file'=>__FILE__,'line'=>__LINE__)); 
		
		$docente =& Docente::selectDocente($_GET['id_utente']);
		
		if (!$docente)
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'L\'utente cercato non � un docente','file'=>__FILE__,'line'=>__LINE__));
		
		//echo 'qui';
			
		$cod_doc	= $docente->getCodDoc();	
		$contatto 	=& ContattoDocente::getContattoDocente($cod_doc); 
		
		if (!$contatto)
			Error::throwError(_ERROR_NOTICE,array('id_utente' => $user->getIdUser(), 'msg'=>'Non esiste contatto di tale docente','file'=>__FILE__,'line'=>__LINE__));
		
		$utente_docente =& $docente->getUser();
		
		if (!$utente_docente)
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'Non esiste tale utente','file'=>__FILE__,'line'=>__LINE__));
//		var_dump($docente);
		
		$rub_docente =& $docente->getInfoRubrica();
		
		if (!$rub_docente)
			Error::throwError(_ERROR_NOTICE,array('id_utente' => $user->getIdUser(), 'msg'=>'Impossibile recuperare le informazioni del docente dalla rubrica','file'=>__FILE__,'line'=>__LINE__));
//		var_dump($contatto);
		$info_docente = array();
		
		$info_docente['nome']					= $rub_docente['prefissonome'].' '.$rub_docente['nome'].' '.$rub_docente['cognome'];
		$info_docente['sesso']					= $rub_docente['sesso'];
		$info_docente['ultimo login al sito']	= $utente_docente->getUltimoLogin();
		$info_docente['email universibo']		= $utente_docente->getEmail();
		$info_docente['mail']					= $rub_docente['email'];
		$info_docente['tel']					= $utente_docente->getPhone();
		$info_docente['afferente a']			= $rub_docente['descrizionestruttura'];
		
		$elenco_ruoli	=& $utente_docente->getRuoli(); 
		
		$info_ruoli	= array();
//		var_dump($elenco_ruoli);
		foreach ($elenco_ruoli as $ruolo)
		{
			$id_canale 	= $ruolo->getIdCanale();
			$canale		= Canale::retrieveCanale($id_canale);
			$name		= $canale->getNome();
			$info_ruoli[$name] = $ruolo->getUltimoAccesso();
		}
//		var_dump($info_ruoli);
		
		// TODO mi sa che questa lista � incompleta: cercare user con groups = 4 o = 64
//		$lista_collabs =& Collaboratore::selectCollaboratoriAll();
		$lista_collabs =& $this->_getCollaboratoriUniversibo();
		$table_collab = array();
//		var_dump($lista_collabs); die;

		foreach($lista_collabs as $collab)
		{
			$id = $collab->getIdUser();
//			$username 			= User::getUsernameFromId($id);
			$username 			= $collab->getUsername();
			$table_collab[$id] 	= $username;
		}
//		var_dump($table_collab); die;
		
		// valori default form
		$f35_collab_list	=	$table_collab;
		//$f35_collab_list['null'] = 'Nessuno';
		$f35_stati			=	$contatto->getLegend();
		$f35_report 		=	'';
		$f35_stato			=	$contatto->getStato();
		$f35_id_username	=	$contatto->getIdUtenteAssegnato();		
		
		if ( array_key_exists('f35_submit_stato', $_POST)  )
		{	
			if (array_key_exists('f35_stato', $_POST) && array_key_exists( $_POST['f35_stato'], $f35_stati))
			{
				$f35_stato	= $_POST['f35_stato'];
				$contatto->setStato($f35_stato, $user->getIdUser());
				$contatto->updateContattoDocente();	
			}
			else 	
				Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'Il form inviato non � valido','file'=>__FILE__,'line'=>__LINE__));
		}
		
		if ( array_key_exists('f35_submit_utente', $_POST)  )
		{
			if (array_key_exists('f35_id_username', $_POST) && array_key_exists( $_POST['f35_id_username'], $f35_collab_list))
			{
				$f35_id_username	= $_POST['f35_id_username'];
				$contatto->assegna($f35_id_username, $user->getIdUser());
				$contatto->updateContattoDocente();	
				
//				if($f35_id_username != 'null')
//				{//notifiche
					require_once('Notifica/NotificaItem'.PHP_EXTENSION);
					$notifica_titolo = 'Assegnato il contatto del docente '.$docente->getNomeDoc();
					$notifica_titolo = substr($notifica_titolo,0 , 199);
					$notifica_dataIns = $contatto->getUltimaModifica();
					$notifica_urgente = false;
					$notifica_eliminata = false;
					$notifica_messaggio = 
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Ciao! ti � stato assegnato il contatto del docente '.$docente->getNomeDoc().' da '.$user->getIdUser().'

Stato attuale: '.$f35_stati[$f35_stato].'

Report attuale: 
'.$contatto->getReport().'

Link: '.$frontcontroller->getAppSetting('rootUrl').'/index.php?do='.get_class($this).'&id_utente'.$docente->getIdUtente().'
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~';
						
				
					$notifica_user =& User::selectUser($f35_id_username);
					$notifica_destinatario = 'mail://'.$notifica_user->getEmail();
					
					$notifica = new NotificaItem(0, $notifica_titolo, $notifica_messaggio, $notifica_dataIns, $notifica_urgente, $notifica_eliminata, $notifica_destinatario );
					$notifica->insertNotificaItem();
								
					//ultima notifica all'archivio
					$notifica_destinatario = 'mail://'.$frontcontroller->getAppSetting('rootEmail');
					
					$notifica = new NotificaItem(0, $notifica_titolo, $notifica_messaggio, $notifica_dataIns, $notifica_urgente, $notifica_eliminata, $notifica_destinatario );
					$notifica->insertNotificaItem();
//				}//end if su username
			}
			else
				Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'Il form inviato non � valido','file'=>__FILE__,'line'=>__LINE__));
		}
		
		if ( array_key_exists('f35_submit_report', $_POST)  )
		{
			if(array_key_exists('f35_report', $_POST) && trim($_POST['f35_report']) != '')
			{
				$contatto->appendReport("\n\n".$_POST['f35_report']);
				$contatto->updateContattoDocente();	
			}
			else 	
				Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'Il form inviato non � valido','file'=>__FILE__,'line'=>__LINE__));
		}
		
		$template->assign('f35_collab_list', $f35_collab_list);
		$template->assign('f35_stati', $f35_stati);
		$template->assign('f35_stato', $f35_stato);
		$template->assign('f35_report', $f35_report);
		$template->assign('f35_id_username', $f35_id_username);
		$template->assign('ShowContattoDocente_info_docente', $info_docente);
		$template->assign('ShowContattoDocente_info_ruoli', $info_ruoli);
		$template->assign('ShowContattoDocente_titolo', 'Info su '.$docente->getNomeDoc());
		$template->assign('ShowContattoDocente_contatto', array(
														'stato' => $f35_stati[$f35_stato],
														'assegnato a' => $f35_collab_list[$f35_id_username],
														'report' => $contatto->getReport()
														));

		// TODO da attivare quando sar� aggiunto l'argomento nell'help
		//$this->executePlugin('ShowTopic', array('reference' => 'contattodocenti'));
		
		return 'default';
	}	
	
	function _getCollaboratoriUniversibo()
	{
		$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT username, password, email, ultimo_login, ad_username, groups, notifica, phone, default_style, id_utente  FROM utente WHERE groups IN (4,64)';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows == 0) return false;
		
		$lista = array();
		while ($row = $res->fetchRow())
			$lista[] = new User($row[9], $row[5], $row[0], $row[1], $row[2], $row[6], $row[3], $row[4], $row[7], $row[8], NULL);
		
		return $lista;
	}
	
}
?>
