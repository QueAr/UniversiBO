<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use Symfony\Component\HttpFoundation\Request;
use Universibo\Bundle\CoreBundle\Entity\User;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;
use Universibo\Bundle\LegacyBundle\Framework\Error;

class ShowStatistiche extends UniversiboCommand
{
    public function execute(Request $request)
    {
        $frontcontroller = $this->getFrontController();
        $template = $frontcontroller->getTemplateEngine();

        $krono = $frontcontroller->getKrono();
        $user = $this->get('security.context')->getToken()->getUser();
        $user_ruoli = $user instanceof User ? $this->get('universibo_legacy.repository.ruolo')->findByIdUtente($user->getId()) : [];

        if (!$user->hasRole('ROLE_MODERATOR') && !$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            Error::throwError(_ERROR_DEFAULT,
                    ['id_utente' => $user->getId(),
                            'msg' => "Non hai i diritti necessari per visualizzare la pagina",
                            'file' => __FILE__, 'line' => __LINE__]);
        }

        $db = $this->getContainer()->get('doctrine.dbal.default_connection');

        $query = 'SELECT file_inseriti_giorno.mese, file_inseriti_giorno.anno, sum(file_inseriti_giorno.totale_file) AS file_mese
        FROM file_inseriti_giorno
        GROUP BY file_inseriti_giorno.anno, file_inseriti_giorno.mese
        ORDER BY file_inseriti_giorno.anno DESC, file_inseriti_giorno.mese DESC;';
        //          var_dump($query,$user); die;
        $res = $db->executeQuery($query);

        $listaFilePerMese = [];
        while (false !== ($row = $res->fetch())) {
            $listaFilePerMese[] = ['mese' => $row[0], 'anno' => $row[1],
                    'somma' => $row[2]];
        }

        $query = 'SELECT giorno, mese,anno, iscritti FROM studenti_iscritti ORDER BY anno DESC, mese DESC, giorno DESC;';
        //          var_dump($query,$user); die;
        $res = $db->executeQuery($query);

        $listaUtentiPerMese = [];
        while (false !== ($row = $res->fetch())) {
            $listaUtentiPerMese[] = ['mese' => $row[1], 'anno' => $row[2],
                    'giorno' => $row[0], 'iscritti' => $row[3]];
        }

        $template->assign('ShowStatistiche_elencoUtentiPerMese', $listaUtentiPerMese);
        $template->assign('ShowStatistiche_elencoFilePerMese', $listaFilePerMese);
        $template->assign('ShowStatistiche_titolo', 'Statistiche');
    }
}
