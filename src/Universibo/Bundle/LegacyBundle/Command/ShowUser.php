<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use \Error;
use Universibo\Bundle\LegacyBundle\Entity\Canale;
use Universibo\Bundle\LegacyBundle\Entity\Docente;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;
use Universibo\Bundle\WebsiteBundle\Entity\User;

/**
 *Questa classe consente la visualizzazione e la possibile modifica
 *dei dati di un utente.
 *@author Daniele Tiles
 */

class ShowUser extends UniversiboCommand
{

    public function execute()
    {
        $frontcontroller = $this->getFrontController();
        $template = $frontcontroller->getTemplateEngine();
        $context = $this->get('security.context');
        $current_user = $context->getToken()->getUser();

        if (!array_key_exists('id_utente', $_GET)
                || !preg_match('/^([0-9]{1,9})$/', $_GET['id_utente'])) {
            Error::throwError(_ERROR_DEFAULT,
                    array('id_utente' => $user->getId(),
                            'msg' => 'L\'id dell\'utente richiesto non e` valido',
                            'file' => __FILE__, 'line' => __LINE__));
        }
        $user = $this->get('universibo_website.repository.user')->find($id_user = $_GET['id_utente']);
        $userId = $user instanceof User ? $user->getId() : 0;

        if (!$context->isGranted('IS_AUTHENTICATED_FULLY')) {
            Error::throwError(_ERROR_DEFAULT,
                    array('id_utente' => $userId,
                            'msg' => 'Le schede degli utenti sono visualizzabili solo se si e` registrati',
                            'file' => __FILE__, 'line' => __LINE__));
        }

        if (!$user || $user->isLocked() || !$user->isEnabled()) {
            Error::throwError(_ERROR_DEFAULT,
                    array('id_utente' => $userId,
                            'msg' => 'L\'utente cercato non e` valido',
                            'file' => __FILE__, 'line' => __LINE__));
        }

        if (!$current_user->hasRole('ROLE_ADMIN') && !$user->hasRole('ROLE_PROFESSOR')
                && !$user->hasRole('ROLE_TUTOR')
                && $userId != $current_user->getId()) {
            Error::throwError(_ERROR_DEFAULT,
                    array('id_utente' => $userId,
                            'msg' => 'Non ti e` permesso visualizzare la scheda dell\'utente',
                            'file' => __FILE__, 'line' => __LINE__));
        }

        $router = $this->get('router');

        $arrayRuoli = $user instanceof User ? $this->get('universibo_legacy.repository.ruolo')->findByIdUtente($user->getId()) : array();
        $canali = array();
        $arrayCanali = array();
        $keys = array_keys($arrayRuoli);
        foreach ($keys as $key) {
            $ruolo = $arrayRuoli[$key];
            if ($ruolo->isMyUniversibo()) {
                $canale = Canale::retrieveCanale($ruolo->getIdCanale());
                if ($canale->isGroupAllowed($current_user->getLegacyGroups())) {
                    $canali = array();
                    $canali['uri'] = $canale->showMe();
                    $canali['tipo'] = $canale->getTipoCanale();
                    $canali['label'] = ($canale->getNome() != '') ? $canale
                                    ->getNome() : $canale
                                    ->getNomeMyUniversibo();
                    $canali['ruolo'] = ($ruolo->isReferente()) ? 'R'
                            : (($ruolo->isModeratore()) ? 'M' : 'none');
                    $canali['modifica'] = $router->generate('universibo_legacy_default', array('do' => 'MyUniversiBOEdit', 'id_canale' => $ruolo->getIdCanale()));
                    $canali['rimuovi'] = $router->generate('universibo_legacy_default', array('do' => 'MyUniversiBORemove', 'id_canale' => $ruolo->getIdCanale()));
                    $arrayCanali[] = $canali;
                }
            }
        }
        usort($arrayCanali, array($this, '_compareMyUniversiBO'));
        $email = $user->getEmail();
        $template->assign('showUserLivelli',$this->get('universibo_legacy.translator.role_name')->translate($user->getRoles()));

        $template->assign('showUserNickname', $user->getUsername());
        $template->assign('showUserEmail', $email);
        $pos = strpos($email, '@');
        $firstPart = substr($email, 0, $pos);
        $secondPart = substr($email, $pos + 1, strlen($email) - $pos);
        $template->assign('showEmailFirstPart', $firstPart);
        $template->assign('showEmailSecondPart', $secondPart);
        $template->assign('showCanali', $arrayCanali);
        $stessi = false;
        if ($userId == $id_user) {
            $stessi = true;
        }
        $template->assign('showDiritti', $stessi);

        $template->assign('showUser_UserHomepage', '');
        if ($user->hasRole('ROLE_PROFESSOR')) {
            $doc = Docente::selectDocente($user->getId());
            $template
                    ->assign('showUser_UserHomepage',
                            $doc->getHomepageDocente());
        }
        $template->assign('showSettings', $router->generate('universibo_legacy_default', array('do' => 'ShowSettings')));

        return 'default';
    }

}
