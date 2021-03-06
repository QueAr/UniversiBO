<?php

namespace Universibo\Bundle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MyUniversiBOController extends Controller
{
    /**
     * @Template()
     */
    public function boxAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return ['roles' => []];
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $rolesRepo = $this->get('universibo_legacy.repository.ruolo');
        $channelRepo = $this->get('universibo_legacy.repository.canale2');
        $channelRouter = $this->get('universibo_legacy.routing.channel');

        $roles = $rolesRepo->findByIdUtente($user->getId());

        $displayRoles = [];

        foreach ($roles as $role) {
            if ($role->isMyUniversibo()) {
                $name = $role->getNome();

                $channel = $channelRepo->find($role->getIdCanale());

                if (strlen($name) === 0) {
                    $name = $channel->getNome();
                }

                $displayRoles[] = ['link' => $channelRouter->generate($channel),
                    'name' => $name, 'referente' => $role->isReferente(),
                    'moderatore' => $role->isModeratore()];
            }
        }

        return ['roles' => $displayRoles];
    }
}
