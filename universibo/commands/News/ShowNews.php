<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * ShowNews � un'implementazione di PluginCommand.
 *
 * Mostra la notizia $id_notizia.
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * Nel paramentro di ingresso del deve essere specificato il numero di notizie da visualizzare.
 *
 * @package universibo
 * @subpackage News
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowNews extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param deve contenere: 
	 *  - 'id_notizia' l'id della notizia da visualizzare
	 *	  es: array('id_notizia'=>5) 
	 */
	function execute($param)
	{
		
		$elenco_id_news		=  $param['id_notizie'];

		$bc        =& $this->getBaseCommand();
//		$user      =& $bc->getSessionUser();
//		$canale    =& $bc->getRequestCanale();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();


/*		$id_canale = $canale->getIdCanale();
		$titolo_canale =  $canale->getTitolo();
		$ultima_modifica_canale =  $canale->getUltimaModifica();
		$user_ruoli =& $user->getRuoli();

		

		$template->assign('showNews_addNewsFlag', 'false');
		if (array_key_exists($id_canale, $user_ruoli) || $user->isAdmin())
		{
			$personalizza = true;
			
			if (array_key_exists($id_canale, $user_ruoli))
			{
				$ruolo =& $user_ruoli[$id_canale];
				
				$referente      = $ruolo->isReferente();
				$moderatore     = $ruolo->isModeratore();
				$ultimo_accesso = $ruolo->getUltimoAccesso();
			}
			
			if ( $user->isAdmin() || $referente || $moderatore )
			{
				$template->assign('showNews_addNewsFlag', 'true');
				$template->assign('showNews_addNews', 'Scrivi nuova notizia');
				$template->assign('showNews_addNewsUri', 'index.php?do=NewsAdd&id_canale='.$id_canale);
			}
		}
		else
		{
			$personalizza   = false;
			$referente      = false;
			$moderatore     = false;
			$ultimo_accesso = $user->getUltimoLogin();
		}
		
		$canale_news = $this->getNumNewsCanale($id_canale);

		$template->assign('showNews_desc', 'Mostra le ultime '.$num_news.' notizie del canale '.$id_canale.' - '.$titolo_canale);
*/

		$canale_news = count($elenco_id_news);
		
		if ( $canale_news == 0 )
		{
			$template->assign('showNews_langNewsAvailable', 'Non ci sono notizie da visualizzare');
			$template->assign('showNews_langNewsAvailableFlag', 'false');
		}
		else
		{
			$template->assign('showNews_langNewsAvailable', 'Ci sono '.$canale_news.' notizie');
			$template->assign('showNews_langNewsAvailableFlag', 'true');
		}
		
		$elenco_news =& NewsItem::selectNewsItems($elenco_id_news);
		
		$elenco_news_tpl = array();

		if ($elenco_news ==! false )
		{
			
			$ret_news = count($elenco_news);
			
			for ($i = 0; $i < $ret_news; $i++)
			{
				$news =& $elenco_news[$i];
				//$this_moderatore = ($moderatore && $news->getIdUtente()==$user->getIdUser());
				
				$elenco_news_tpl[$i]['titolo']       = $news->getTitolo();
				$elenco_news_tpl[$i]['notizia']      = $news->getNotizia();
				$elenco_news_tpl[$i]['data']         = $krono->k_date('%j/%m/%Y', $news->getDataIns());
				//echo $personalizza,"-" ,$ultimo_accesso,"-", $news->getUltimaModifica()," -- ";
				//$elenco_news_tpl[$i]['nuova']        = ($personalizza==true && $ultimo_accesso < $news->getUltimaModifica()) ? 'true' : 'false'; 
				$elenco_news_tpl[$i]['autore']       = $news->getUsername();
				$elenco_news_tpl[$i]['autore_link']  = 'ShowUser&id_utente='.$news->getIdUtente();
				$elenco_news_tpl[$i]['id_autore']    = $news->getIdUtente();
				
				$elenco_news_tpl[$i]['scadenza']     = '';
/*				if ( ($news->getDataScadenza()!=NULL) && ( $user->isAdmin() || $referente || $this_moderatore ) )
				{
					$elenco_news_tpl[$i]['scadenza'] = 'Scade il '.$krono->k_date('%j/%m/%Y', $news->getDataScadenza() );
				}
*/				
				$elenco_news_tpl[$i]['modifica']     = '';
				$elenco_news_tpl[$i]['modifica_link']= '';
				$elenco_news_tpl[$i]['elimina']      = '';
				$elenco_news_tpl[$i]['elimina_link'] = '';
/*				if ( $user->isAdmin() || $referente || $this_moderatore )
				{
					$elenco_news_tpl[$i]['modifica']     = 'Modifica';
					$elenco_news_tpl[$i]['modifica_link']= 'NewsEdit&id_news='.$news->getIdNotizia();
					$elenco_news_tpl[$i]['elimina']      = 'Elimina';
					$elenco_news_tpl[$i]['elimina_link'] = 'NewsDelete&id_news='.$news->getIdNotizia().'&id_canale='.$id_canale;
				}
*/
			}
		
		}
		
		$template->assign('showNews_newsList', $elenco_news_tpl);

		
	}
	
	

	
}

?>