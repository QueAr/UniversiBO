<?php

require_once('Canale'.PHP_EXTENSION);

/**
 * Cdl class.
 *
 * Modella una facolt�.
 * Fornisce metodi statici che permettono l'accesso 
 * ottimizzato alle istanze di Facolt�
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Cdl extends Canale{
	
	/**
	 * @private
	 */
	var $cdlCodice = '';
	/**
	 * @private
	 */
	var $cdlNome = '';

	
	
	
	function Facolta($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo, $cod_facolta, $nome_facolta, $uri_facolta)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		$this->facoltaCodice = $cod_facolta;
		$this->facoltaNome   = $nome_facolta;
		$this->facoltaUri    = $uri_facolta;
	}



	/**
	 * Restituisce il nome della facolt�
	 *
	 * @return string
	 */
	function getNome()
	{
		return $this->facoltaNome;
	}



	/**
	 * Restituisce il titolo/nome completo della facolt�
	 *
	 * @return string
	 */
	function getTitoloFacolta()
	{
		return 'FACOLTA\' DI '.$this->getNome();
	}



	/**
	 * Restituisce il link alla homepage ufficiale della facolt�
	 *
	 * @return string
	 */
	function getUri()
	{
		return $this->facoltaUri;
	}



	/**
	 * Restituisce il codice di ateneo a 4 cifre della facolt�
	 * es: ingegneria -> '0021'
	 *
	 * @return string
	 */
	function getCodiceFacolta()
	{
		return $this->facoltaCodice;
	}


	/**
	 * Crea un oggetto facolta dato il suo numero identificativo id_canale
	 * Ridefinisce il factory method della classe padre per restituire un oggetto
	 * del tipo Facolta
	 *
	 * @static
	 * @param int $id_canale numero identificativo del canale
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &factoryCanale($id_canale)
	{
		return Facolta::selectFacoltaCanale($id_canale);
	}
	

	/**
	 * Seleziona da database e restituisce l'oggetto facolt� 
	 * corrispondente al codice id_canale 
	 * 
	 * @static
	 * @param int $id_canale id_del canale corrispondente alla facolt�
	 * @return Facolta
	 */
	function &selectFacoltaCanale($id_canale)
	{
		global $__facoltaElencoCanale;
		
		if ( $__facoltaElencoCanale == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoCanale[$id_canale];
	}
	
	

	/**
	 * Seleziona da database e restituisce l'oggetto facolt� 
	 * corrispondente al codice $cod_facolta 
	 * 
	 * @static
	 * @param string $cod_facolta stringa a 4 cifre del codice d'ateneo della facolt�
	 * @return Facolta
	 */
	function &selectFacoltaCodice($cod_facolta)
	{
		global $__facoltaElencoCodice;
		
		if ( $__facoltaElencoCodice == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoCodice[$cod_facolta];
	}
	

	
	/**
	 * Seleziona da database e restituisce un'array contenente l'elenco 
	 * in ordine alfabetico di tutte le facolt� 
	 * 
	 * @static
	 * @param string $cod_facolta stringa a 4 cifre del codice d'ateneo della facolt�
	 * @return array(Facolta)
	 */
	function &selectFacoltaElenco()
	{
		global $__facoltaElencoAlfabetico;
		
		if ( $__facoltaElencoAlfabetico == NULL )
		{
			Facolta::_selectFacolta();
		}
		
		return $__facoltaElencoAlfabetico;
	}
	
	
	/**
	 * Siccome nella maggiorparte delle chiamate viene eseguito l'accesso a tutte le
	 * facolt� questa procedura si occupa di eseguire il caching degli oggetti facolt�
	 * in variabili static (globali per comodit� implementativa) e permette di 
	 * alleggerire i futuri accessi a DB implementando di fatto insieme ai metodi
	 * select*() i meccanismi di un metodo singleton factory
	 * 
	 * @static
	 * @private
	 * @return none 
	 */
	function _selectFacolta()
	{
		
		global $__facoltaElencoCodice;
		global $__facoltaElencoAlfabetico;
		global $__facoltaElencoCanale;

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, a.id_canale, cod_fac, desc_fac, url_facolta FROM canale a , facolta b WHERE a.id_canale = b.id_canale ORDER BY 15';
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		$__facoltaElencoAlfabetico = array();
		$__facoltaElencoCanale     = array();
		$__facoltaElencoCodice     = array();

		if( $rows = 0) return;
		while (	$res->fetchInto($row) )
		{
			$facolta =& new Facolta($row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
				$row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S', $row[13], $row[14], $row[15]);

			$__facoltaElencoAlfabetico[] =& $facolta;
			$__facoltaElencoCodice[$facolta->getCodiceFacolta()] =& $facolta;
			$__facoltaElencoCanale[$facolta->getIdCanale()] =& $facolta;
		}
		
	}
	
}