<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use Symfony\Component\HttpFoundation\Request;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;
use Universibo\Bundle\LegacyBundle\Entity\Files\FileItem;

/**
 * ShowAllFilesStudenti e\' un comando che permette di visualizzare tutti i
 * files studenti presenti su UniversiBO
 *
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author barto
 * @author evaimitico
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class ShowPersonalFiles extends UniversiboCommand
{
    public function execute(Request $request)
    {
        $frontcontroller = $this->getFrontController();
        $template = $frontcontroller->getTemplateEngine();
        $user = $this->get('security.context')->getToken()->getUser();
        $router = $this->get('router');

        $idUtente = $user->getId();

        $listaFile = FileItem::selectFileItemsByIdUtente($idUtente, true);

        $files = [];
        foreach ($listaFile as $item) {
            if (!$item instanceof FileItem) {
                continue;
            }

            $files[$item->getIdFile()] = [
                    'nome' => $item->getNomeFile(),
                    'data' => $item->getDataInserimento(),
                    'dimensione' => $item->getDimensione(),
                    'editUri' => $router->generate('universibo_legacy_file_edit', ['id_file' => $item->getIdFile()]),
                    'deleteUri' => $router->generate('universibo_legacy_file_delete', ['id_file' => $item->getIdFile()]),
                    'downloadUri' => $router->generate('universibo_legacy_file_download', ['id_file' => $item->getIdFile()])
            ];
        }

        $template->assign('ShowPersonalFiles_listaFile', $files);
        $template->assign('ShowPersonalFiles_langTitle', 'Gestisci i tuoi file');
    }
}
