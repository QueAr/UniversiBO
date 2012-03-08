<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('InteractiveCommand/InformativaPrivacyInteractiveCommand'.PHP_EXTENSION);


/**
 * ShowRules is an extension of UniversiboCommand class.
 *
 * It shows rules page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowRules extends UniversiboCommand {
	function execute()
	{

		$template = $this->frontController->getTemplateEngine();
		$template->assign('rules_langTitleAlt', 'Regolamento');
		$template->assign('rules_langServicesRules', file_get_contents($this->frontController->getAppSetting('regolamento')));
		$template->assign('rules_langPrivacySubTitle', 'INFORMATIVA SULLA PRIVACY');
		// TODO bisogna trovare un buon posto da cui recuperare l'informativa
		$testoInformativa = InformativaPrivacyInteractiveCommand::getAttualeInformativaPrivacy ();										
		$template->assign('rules_langPrivacy', $testoInformativa['testo']);
		$template->assign('rules_langTitle', 'REGOLAMENTO PER L\'UTILIZZO DEI SERVIZI');
		$template->assign('rules_langFacSubtitle', 'Universit� di Bologna');

		$template->assign('rules_langForum', 'NORME PER L\'UTILIZZO DEL FORUM');
		$template->assign('rules_langForumRules', 'Se avete domande da fare o, ancora meglio, se avete qualcosa 
      da comunicare non esitate ad usufruire del forum facendo attenzione a 
      rispettare le seguenti regole e consigli:
      
    [list]
      [*]se volete porre una domanda, controllate bene che l\'informazione cercata 
        non sia gi� presente all\'interno del sito o che non sia gi� 
        stata posta in un vecchio messaggio; 
      [*]i messaggi vengono raggruppati in discussioni(topic): per cui se rispondete 
        ad un messaggio, il vostro verr� visualizzato subito al di sotto 
        del precedente. Per facilitare a tutti la navigazione tra i diversi 
        topic ci� che pi� conta � che il primo a postare 
        un messaggio utilizzi un titolo opportuno e significativo. 
     [*]quando possibile cercate di rispondere all\'interno di un topic gi� 
        iniziato; 
     [*]evitate di scrivere messaggi troppo lunghi, altrimenti potreste rischiare 
        che nessuno li legga; 
      [*]se volete fare delle critiche non siate offensivi e fate in modo che 
        siano costruttive; 
        [*]non postate lo stesso messaggio pi� volte; 
        [*]se possibile non riportare il messaggio a cui rispondi, casomai, quando 
          servisse, riporta solo una frase; 
        [*]non usate esclusivamente lettere maiuscole(usare maiuscole significa 
          gridare). 
      [/list]
      
      Sul Forum � assolutamente vietato:
      
      [list]
        [*]postare messaggi offensivi; 
        [*]postare messaggi contenenti volgarit� contrari alla morale 
          pubblica, messaggi politici/razziali, messaggi con contenuto osceno, 
          pornografico, ecc.; 
        [*]postare messaggi illeciti o link di siti illegali (pirateria, hacking, 
          pornografia); 
        [*]postare messaggi con qualsiasi forma di spam o pubblicit�. 
      [/list]
      
      Il compito dei moderatori sar� quello di garantire il rispetto 
        assoluto delle regole e di consentire il corretto svolgimento delle discussioni. 
        Per cui potranno:
        
      [list]
        [*]controllare che discussioni troppo accese non degenerino oltre i limiti 
          di un civile e razionale dibattito.  
        [*]cancellare o modificare, senza alcun preavviso, un messaggio ritenuto 
          offensivo o comunque non consono allo spirito del forum. 
        [*]cancellare messaggi identici ripetuti pi� volte; 
         intervenire a loro insindacabile giudizio. 
      [/list]
      
      Contestazioni sull\'operato dei moderatori effettuate sul forum saranno 
        prontamente chiuse o eliminate. Spiegazioni e critiche (non in chiave 
        polemica) rivolte a moderatori e amministratori sono accette ma solo ed 
        esclusivamente in forma privata (via mail)<!-- o tramite il messenger 
        del forum-->.
        
      
       Siete invitati a segnalare ai moderatori eventuali irregolarit� 
        di determinati messaggi.
        
      ');

		return 'default';
	}

}

?>