<?php

namespace GOC\WorkflowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkflowController extends Controller
{
    public function executeAction($action, $id)
    {
        if (($data = $this->getRequest()->request->get('workflow'))) {
            $id = (int)$data['id'];
        }

        $workflow = $this->get('goc_workflow.manager')->create( $this->getRequest()->attributes->get('definition'), (int)$id );
        $workflow->setActor( $this->get('security.context')->getToken()->getUser() );
        $workflow->execute($action);

        return $workflow->createResponse();
    }
}
