<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Universibo\Bundle\LegacyBundle\Entity\Canale;

use Universibo\Bundle\WebsiteBundle\Entity\User;

use \Error;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;

/**
 * RuoliAdminSearch: permette la ricerca di ruoli all'interno di un canale
 *
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
class RuoliAdminSearch extends UniversiboCommand
{
    public function execute()
    {
        $frontcontroller = $this->getFrontController();
        $template = $frontcontroller->getTemplateEngine();
        $router = $this->get('router');

        $user = $this->get('security.context')->getToken()->getUser();

        $referente = false;

        $user_ruoli = $user instanceof User ? $this->get('universibo_legacy.repository.ruolo')->findByIdUtente($user->getId()) : array();
        $ruoli = array();
        $arrayPublicUsers = array();


        $id_canale = $this->getRequest()->attributes->get('id_canale');
        $canale = Canale::retrieveCanale($id_canale);

        if (!$canale instanceof Canale) {
            throw new NotFoundHttpException('Canale not found');
        }

        $template->assign('common_canaleURI', $canale->showMe($router));
        $template->assign('common_langCanaleNome', 'a '.$canale->getTitolo());

        if (array_key_exists($id_canale, $user_ruoli)) {
            $ruolo = $user_ruoli[$id_canale];
            $referente = $ruolo->isReferente();
        }

        if (!$this->get('security.context')->isGranted('ROLE_ADMIN') && !$referente )
            Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getId(), 'msg' => "Non hai i diritti per modificare i diritti degli utenti su questa pagina.\nLa sessione potrebbe essere scaduta.", 'file' => __FILE__, 'line' => __LINE__));

        $f16_accept = false;
        //postback
        if (array_key_exists('f16_submit', $_POST)  ) {

            if (!array_key_exists('f16_username', $_POST) || !array_key_exists('f16_email', $_POST) )
                Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getId(), 'msg' => 'Il form inviato non e` valido', 'file' => __FILE__, 'line' => __LINE__));

            $f16_accept = true;

            if ($_POST['f16_username'] == '' && $_POST['f16_email'] == '') {
                Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getId(), 'msg' => 'Specificare almeno uno dei due criteri di ricerca', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
                $f16_accept = false;
            }

            if ($_POST['f16_username'] == '')
                $f16_username = '%';
            else
                $f16_username = $_POST['f16_username'];

            if ($_POST['f16_email'] == '')
                $f16_email = '%';
            else
                $f16_email = $_POST['f16_email'];

            if ($f16_accept) {
                $users_search = User::selectUsersSearch($f16_username, $f16_email);

                $users_search_keys = array_keys($users_search);
                foreach ($users_search_keys as $key) {
                    $ruoli_search  = $users_search[$key]->getRuoli();

                    $contactUser = array();
                    $contactUser['utente_link']  = $router->generate('universibo_legacy_user', array('id_utente' => $users_search[$key]->getId()));
                    $contactUser['edit_link']  = $router->generate('universibo_legacy_role_admin_edit', array('id_canale' => $id_canale, 'id_utente' => $users_search[$key]->getId()));
                    $contactUser['nome']  = $users_search[$key]->getUserPublicGroupName();
                    $contactUser['label'] = $users_search[$key]->getUsername();

                    if (array_key_exists($id_canale, $ruoli_search)) {
                        $ruolo_search  = $ruoli_search[$id_canale];
                        $contactUser['ruolo'] = ($ruolo_search->isReferente()) ? 'R' :  (($ruolo_search->isModeratore()) ? 'M' : 'none');
                    } else {

                        $contactUser['ruolo'] = 'none';
                    }

                    $arrayPublicUsers[$users_search[$key]->getUserPublicGroupName(false)][] = $contactUser;

                }

            }

        }

        if (!$f16_accept) {
            $canale_ruoli = $canale->getRuoli();
            $ruoli_keys = array_keys($canale_ruoli);
            foreach ($ruoli_keys as $key) {
                if ($canale_ruoli[$key]->isReferente() || $canale_ruoli[$key]->isModeratore() ) {
                    $ruoli[] = $canale_ruoli[$key];

                    $user = $this->get('universibo_website.repository.user')->find($canale_ruoli[$key]->getId());
                    //var_dump($user);
                    $contactUser = array();
                    $contactUser['utente_link']  = $router->generate('universibo_legacy_user', array('id_utente' => $user->getId()));
                    $contactUser['edit_link']  = $router->generate('universibo_legacy_role_admin_edit', array('id_canale' => $id_canale, 'id_utente' => $user->getId()));
                    $contactUser['nome']  = $user->getUserPublicGroupName();
                    $contactUser['label'] = $user->getUsername();
                    $contactUser['ruolo'] = ($canale_ruoli[$key]->isReferente()) ? 'R' :  (($canale_ruoli[$key]->isModeratore()) ? 'M' : 'none');
                    //var_dump($ruolo);
                    //$arrayUsers[] = $contactUser;
                    $arrayPublicUsers[$user->getUserPublicGroupName(false)][$contactUser['label']] = $contactUser;
                }
            }
        }

        uksort($arrayPublicUsers, "strcmp");
//mettere ogni sotto gruppo in ordine alfabetico (non funziona)
//		$keys = array_keys($arrayPublicUsers);
//		foreach($keys as $key)
//		{
//			uksort($arrayPublicUsers[$key], "strcmp");
//		}

        $template->assign('ruoliAdminSearch_users', $arrayPublicUsers);

        $template->assign('ruoliAdminSearch_langAction', "Modifica i diritti nella pagina\n".$canale->getTitolo());
        $template->assign('ruoliAdminSearch_langSearch', "Cerca un altro utente");

        $this->executePlugin('ShowTopic', array('reference' => 'ruoliadmin'));

        return 'default';
    }
}
