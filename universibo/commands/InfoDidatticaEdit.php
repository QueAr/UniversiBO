<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('InfoDidattica'.PHP_EXTENSION);

/**
 * ShowCdl: mostra un corso di laurea
 * Mostra i collegamenti a tutti gli insegnamenti attivi nel corso di laurea
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class InfoDidatticaEdit extends UniversiboCommand 
{

	function execute() 
	{
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();
			
		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
			Error::throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'id del canale richiesto non ? valido', 'file' => __FILE__, 'line' => __LINE__));
		
		$id_canale = $_GET['id_canale'];
		if (!$user->isAdmin() && (!array_key_exists($id_canale, $user_ruoli) || !$user_ruoli[$id_canale]->isReferente()))
			Error::throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUtente(), 'msg' => "Non hai i diritti per eseguire l\'perazione richiesta.\nLa sessione potrebbe essere scaduta", 'file' => __FILE__, 'line' => __LINE__));
		
		
		$info_didattica = InfoDidattica::retrieveInfoDidattica($id_canale);
		$insegnamento = Canale::retrieveCanale($id_canale);
		
		
		
		$template->assign('infoDid_title', $insegnamento->getTitolo() );
		$template->assign('infoDid_backUri', $insegnamento->showMe() );
		
		//var_dump($info_didattica);
		$f18_homepageLink = $info_didattica->getHomepageAlternativaLink();
		
		$f18_obiettiviLink = $info_didattica->getObiettiviEsameLink();
		$f18_obiettiviInfo = $info_didattica->getObiettiviEsame();
		
		$f18_programmaLink = $info_didattica->getProgrammaLink();
		$f18_programmaInfo = $info_didattica->getProgramma();
		
		$f18_materialeLink = $info_didattica->getTestiConsigliatiLink();
		$f18_materialeInfo = $info_didattica->getTestiConsigliati();
		
		$f18_modalitaLink = $info_didattica->getModalitaLink();
		$f18_modalitaInfo = $info_didattica->getModalita();
		
		//$appelli = '';
		$f18_appelliLink = $info_didattica->getAppelliLink();
		$f18_appelliInfo = $info_didattica->getAppelli();
		
		$f18_accept = false;
		if(array_key_exists('f18_submit', $_POST))
		{
			$f18_accept = true;
			if( !array_key_exists('f18_homepageLink', $_POST) ||
				!array_key_exists('f18_obiettiviLink', $_POST) ||
				!array_key_exists('f18_obiettiviInfo', $_POST) ||
				!array_key_exists('f18_programmaLink', $_POST) ||
				!array_key_exists('f18_programmaInfo', $_POST) ||
				!array_key_exists('f18_materialeLink', $_POST) ||
				!array_key_exists('f18_materialeInfo', $_POST) ||
				!array_key_exists('f18_modalitaLink', $_POST) ||
				!array_key_exists('f18_modalitaInfo', $_POST) ||
				!array_key_exists('f18_appelliLink', $_POST) ||
				!array_key_exists('f18_appelliInfo', $_POST) )
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'Il form inviato non ? valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_accept = false;
			}
			
			$f18_homepageLink = $_POST['f18_homepageLink'];
			$f18_obiettiviInfo = $_POST['f18_obiettiviInfo'];
			$f18_programmaInfo = $_POST['f18_programmaInfo'];
			$f18_materialeInfo = $_POST['f18_materialeInfo'];
			$f18_modalitaInfo = $_POST['f18_modalitaInfo'];
			$f18_appelliInfo = $_POST['f18_appelliInfo'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_obiettiviLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina degli obiettivi deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_obiettiviLink = 'http://';
				$f18_accept = false;
			}
			else $f18_obiettiviLink = $_POST['f18_obiettiviLink'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_programmaLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina del programma deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_programmaLink = 'http://';
				$f18_accept = false;
			}
			else $f18_programmaLink = $_POST['f18_programmaLink'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_materialeLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina del materiale deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_materialeLink = 'http://';
				$f18_accept = false;
			}
			else $f18_materialeLink = $_POST['f18_materialeLink'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_modalitaLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina delle modalit? d\'esame deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_modalitaLink = 'http://';
				$f18_accept = false;
			}
			$f18_modalitaLink = $_POST['f18_modalitaLink'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_appelliLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina degli appelli deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_appelliLink = 'http://';
				$f18_accept = false;
			}
			else $f18_appelliLink = $_POST['f18_appelliLink'];
			
			if (!ereg('(^(http(s)?|ftp)://|^.{0}$)', $_POST['f18_homepageLink'] ) ) 
			{
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUtente(), 'msg' => 'L\'URL del link alla pagina degli appelli deve iniziare con https://, http:// o ftp://, verificare di non aver lasciato spazi vuoti', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f18_homepageLink = 'http://';
				$f18_accept = false;
			}
			else $f18_homepageLink = $_POST['f18_homepageLink'];
			
			
			
			if($f18_accept)
			{
				$info_didattica->setObiettiviEsameLink($f18_obiettiviLink);
				$info_didattica->setObiettiviEsame($f18_obiettiviInfo);
				
				$info_didattica->setProgrammaLink($f18_programmaLink);
				$info_didattica->setProgramma($f18_programmaInfo);
				
				$info_didattica->setTestiConsigliatiLink($f18_materialeLink);
				$info_didattica->setTestiConsigliati($f18_materialeInfo);
				
				$info_didattica->setModalitaLink($f18_modalitaLink);
				$info_didattica->setModalita($f18_modalitaInfo);
				
				$info_didattica->setAppelliLink($f18_appelliLink);
				$info_didattica->setAppelli($f18_appelliInfo);
				
				$info_didattica->setHomepageAlternativaLink($f18_homepageLink);
				
				$info_didattica->updateInfoDidattica();
				
				return 'success';
				
			}
			
		}
		
		
		
		$template->assign('infoDid_langHomepageAlternativaLink', 'Link ad una homepage alternativa' );
		$template->assign('f18_homepageLink', $f18_homepageLink );
		
		$template->assign('infoDid_langObiettiviInfo', 'Obiettivi del corso' );
		$template->assign('infoDid_langObiettiviLink', 'Link a pagina esterna alternativa con gli obiettivi del corso' );
		$template->assign('f18_obiettiviLink', $f18_obiettiviLink );
		$template->assign('f18_obiettiviInfo', $f18_obiettiviInfo );
		
		$template->assign('infoDid_langProgrammaInfo', 'Programma d\'esame' );
		$template->assign('infoDid_langProgrammaLink', 'Link a pagina esterna alternativa con il programma d\'esame' );
		$template->assign('f18_programmaLink', $f18_programmaLink );
		$template->assign('f18_programmaInfo', $f18_programmaInfo );
		
		$template->assign('infoDid_langMaterialeInfo', 'Materiale didattico e testi consigliati' );
		$template->assign('infoDid_langMaterialeLink', 'Link a pagina esterna alternativa con materiale didattico e testi consigliati' );
		$template->assign('f18_materialeLink', $f18_materialeLink );
		$template->assign('f18_materialeInfo', $f18_materialeInfo );
		
		$template->assign('infoDid_langModalitaInfo', 'Modalit? d\'esame' );
		$template->assign('infoDid_langModalitaLink', 'Link a pagina esterna alternativa con modalit? d\'esame');
		$template->assign('f18_modalitaLink', $f18_modalitaLink );
		$template->assign('f18_modalitaInfo', $f18_modalitaInfo );
		
		$template->assign('infoDid_langAppelliInfo', 'Appelli d\'esame' );
		$template->assign('infoDid_langAppelliLink', 'Link a pagina esterna alternativa con appelli d\'esame');
		$template->assign('f18_appelliLink', $f18_appelliLink );
		$template->assign('f18_appelliInfo', $f18_appelliInfo );
		$template->assign('infoDid_langAppelliUniwex', 'Ci scusiamo con gli utenti ma al momento non ? pi? possibile visualizzare le informazioni riguardanti gli appelli d\'esame riportati su Uniwex');
		
		//$this->executePlugin('ShowNewsLatest', array( 'num' => 5  ));
		//$this->executePlugin('ShowFileTitoli', array());
		return 'default';
	}

}

?>