<?php

/**
 *
 * NewsItem class
 *
 * Rappresenta una singola news.
 *
 * @package universibo
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */


class NewsItem {
	
	/**
	 * � costante per il valore del flag per le notizie eliminate
	 *
	 * @private
	 */
	var $ELIMINATA='S';
	
	/**
	 * @private
	 */
	var $titolo='';
	
	/**
	 * @private
	 */ 
	var $notizia='';
	 
	/**
	 * @private
	 */
	var $idUtente=0; 

	/**
	 * data e ora di inserimento
	 * @private
	 */
	var $dataIns=0;
	
	
	/**
	 * @private
	 */
	var $dataScadenza=0;
	
		
	/**
	 * @private
	 */
	var $urgente=false; 
	
	/**
	 * @private
	 */
	var $idNotizia=0; 
	 
	/**
	 * @private
	 */
	var $eliminata=false; 
	
	/**
	 * @private
	 */
	var $elencoCanali=NULL; 

	/**
	 * @private
	 */
	var $elencoIdCanali=NULL; 

	
	
	/**
	 * Crea un oggetto NewsItem con i parametri passati
	 * 
	 *
	 * @param  int $id_notizia id della news
	 * @param  string $titolo titolo della news max 150 caratteri
	 * @param  string $notizia corpo della news
	 * @param  int $dataIns timestamp del giorno di inserimento
	 * @param  int $dataScadenza timestamp del giorno di scadenza
	 * @param  boolean $urgente flag notizia urgente o meno
	 * @param  boolean $eliminata flag stato della news
	 * @param  int $id_utente id dell'autore della news
	 * @return NewsItem
	 */
	 
	 function NewsItem($id_notizia, $titolo, $notizia, $dataIns, $dataScadenza, $urgente, $eliminata, $id_utente){
	 	
	 	$this->id_notizia=$id_notizia;
	 	$this->titolo=$titolo;
	 	$this->notizia=$notizia;
	 	$this->dataIns=$dataIns;
	 	$this->dataScadenza=$dataScadenza;
	 	$this->urgente=$urgente;
	 	$this->eliminata=$eliminata;
	 	$this->id_utente=$id_utente;
	 
	 }

	 
	 /**
	  * 
	  * Recupera il titolo della notizia
	  *
	  * @return String 
	  */
	 function getTitolo(){
	 	return $this->titolo;
	 }

	 
	 /**
	  * Recupera il testo della notizia
	  *
	  * @return string 
	  */
	 function getNotizia()
	 {
	 	return $this->notizia;
	 }

	 
	 /**
	 * Recupera l'id_utente dell'autore della notizia
	 *
	 * @return int 
	 */
	 function getIdUtente() 
	 {
	 	return $this->idUtente;
	 }
	 

	/**
	 * Recupera la data di inserimento della notizia
	 *
	 * @return int 
	 */
	function getDataIns() 
	{
	 	return $this->dataIns;
	}
	 
	 
		 
	/**
	 * Recupera la data di scadenza della notizia
	 *
	 * @return int
	 */
	function getDataScadenza() 
	{
	 	return $this->dataScadenza;
	}
	 
	 
	/**
	 * Recupera l'urgenza della notizia
	 *
	 * @return boolean
	 */
	function getUrgente()
	{
	 	return $this->urgente;
	}
	 
	 
	/**
	 * Recupera l'id della notizia
	 *
	 * @return int
	 */
	function getIdNotizia() 
	{
	 	return $this->idNotizia;
	}
	 
	/**
	 * Recupera lo stato della notizia
	 *
	 * @return boolean
	 */
	function getEliminata() 
	{
	 	return $this->eliminata;
	}
	 

	/**
	 * Imposta il titolo della notizia
	 *
	 * @param  string $titolo titolo della news max 150 caratteri
	 */
	function setTitolo($titolo)
	{
	 	$this->titolo=$titolo;
	}
	 

	/**
	 * Imposta il testo della notizia
	 *
	 * @param  string $notizia corpo della news 
	 */
	function setNotizia($notizia)
	{
	 	$this->notizia=$notizia;
	}
	 
	 
	/**
	 * Imposta l'id_utente dell'autore della notizia
	 *
	 * @param  int $id_utente id dell'autore della news 
	 */
	function setIdUtente($id_utente) 
	{
	 	$this->idUtente=$id_utente;
	}
	 
	 
	/**
	 * Imposta la data di inserimento della notizia
	 *
	 * @param  int $dataIns timestamp del giorno di inserimento 
	 */
	function setDataIns($dataIns) 
	{
	 	$this->dataIns=$dataIns;
	}
	
	
	/**
	 * 
	 * Imposta la data di scadenza della notizia
	 *
	 * @param  int $dataScadenza timestamp del giorno di scadenza 
	 */
	function setDataScadenza($dataScadenza) {
	 	$this->dataScadenza=$dataScadenza;
	}
	 

	/**
	 * Imposta l'urgenza della notizia
	 *
	 * @param  boolean $urgente flag notizia urgente o meno
	 */
	function setUrgente($urgente)
	{
		$this->urgente=$urgente;
	}
	 
	 
	
	 
	/**
	 * 
	 * Imposta l'id della notizia
	 *
	 * @param  int $id_notizia id della news
	 */
	function setIdNotizia($id_notizia) 
	{
	 	$this->idNotizia=$id_notizia;
	}
	 
	
	/**
	 * 
	 * Imposta lo stato della notizia
	 *
	 * @param  boolean $eliminata flag stato della news
	 */
	function setEliminata($eliminata) 
	{
	 	$this->eliminata=$eliminata;
	}
	
	 
	/**
	 * Recupera una notizia dal database
	 *
	 * @static
	 * @param int $id_notizia  id della news
	 * @return NewsItem 
	 */
	 function &selectNewsItem ($id_notizia){
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT titolo, notizia, data_inserimento, data_scadenza, flag_urgente, eliminata, id_utente FROM news WHERE id_news='.$db->quote($id_notizia).'AND eliminata!='.$db->quote($this->ELIMINATA);
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
	
		$res->fetchInto($row);	
		
		$news=& new NewsItem($id_notizia,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
		return $news;
	 }
	
	
	/**
	 * Verifica se la notizia � scaduta
	 *
	 * @return boolean
	 */
	function isScaduta() 
	{
	 	return $this->getDataScadenza() < time();
	}
	 
	 
	/**
	 * Seleziona gli id_canale per i quali la notizia � inerente 
	 *
	 * @static
	 * @return array	elenco degli id_canale
	 */
	function &getIdCanali() 
	{
	 	if ($this->elencoIdCanali != NULL) 
	 		return $this->elencoIdCanali;
 		
 		$id_notizia = $this->getIdNotizia();
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_canale FROM news_canale WHERE id_news='.$db->quote($id_notizia).' ORDER BY id_canale';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows = 0) return false;
		
		$elenco_id_canale = array();
		
		while($res->fetchInto($row))
		{
			$elenco_id_canale[] = $row[0];
		}
		
		$this->elencoIdCanali =& $elenco_id_canale;
		
 		return $this->elencoIdCanali;
		
	}
	 

	/**
	 * Seleziona i canali per i quali la notizia � inerente 
	 *
	 * @static
	 * @return array	elenco dei canali
	 */
	function &getCanali() 
	{
	 	if ($this->elencoCanali != NULL) 
	 		return $this->elencoCanali;
 		/*
 		$id_notizia = $this->getIdNotizia();
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT id_canale FROM news_canale WHERE id_news='.$db->quote($id_notizia).' ORDER BY id_canale';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows = 0) return false;
		
		$elenco_id_canale = array();
		
		while($res->fetchInto($row))
		{
			$elenco_id_canale[] = $row[0];
		}
		
		$this->elencoIdCanale = $elenco_id_canale;
		*/
		$this->elencoCanali =& Canale::selectCanali( $this->getIdCanali() );
		
 		return $this->elencoCanali;
		
	}
	 

	/**
	 * rimuove la notizia dal canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function removeCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'DELETE FROM news_canale WHERE id_canale='.$db->quote($id_canale).' AND id_news='.$db->quote($this->id_notizia);
		 //� da testare il funzionamento di =&
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 

		$this->elencoIdCanali  = NULL;
		$this->elencoCanali    = NULL;
	 
	}

	 
	/**
	 * aggiunge la notizia al canale specificato
	 *
	 * @param int $id_canale   identificativo del canale
	 */
	function addCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = 'INSERT INTO news_canale VALUES ('.$db->quote($this->id_notizia).','.$db->quote($id_canale).')';
		 //� da testare il funzionamento di =&
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$this->elencoIdCanali  = NULL;
		$this->elencoCanali    = NULL;
		
	}	 

} 
 
?>