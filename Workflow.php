<?php

namespace GOC\WorkflowBundle;

use Symfony\Component\DependencyInjection\Container;

use GOC\WorkflowBundle\Entity\Progress;
use GOC\WorkflowBundle\Form\WorkflowType;

class Workflow
{
    private $container;
    private $definition;
    private $progress;

    public function __construct(Container $container, WorkflowDefinition $definition, Progress $progress)
    {
        $this->container  = $container;
        $this->definition = $definition;
        $this->progress   = $progress;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function execute($action, $data = null)
    {
        $this->getDefinition()->execute($action, $this->progress, $data);
    }

    public function getStatus()
    {
        return $this->progress->getStatus();
    }

    public function setActor($actor)
    {
        $this->progress->setActor($actor);
    }

    public function getActor()
    {
        return $this->progress->getActor();
    }

    public function getForm()
    {
        return $this->getDefinition()->getForm();
    }

    public function getView()
    {
        return $this->getDefinition()->getView();
    }

    public function getParameters(array $params)
    {
        return array(
            'workflow' => $this,
        ) + $params;
    }

    public function getData()
    {
        return $this->getDefinition()->getData();
    }

    public function createResponse($postCheck = true)
    {
        $this->progress->setData($this->getData());

        $type    = new WorkflowType($this->getForm());
        $form    = $this->container->get('form.factory')->create($type, $this->progress);
        $request = $this->container->get('request');

        if ($postCheck && $request->getMethod() === 'POST') {
            $form->bindRequest($request);

            $actions = $request->request->get('submit');
            $action = key($actions);
            
            if ($form->isValid()) {
                $this->execute($action, $form->getData()->getData());
                return $this->createResponse(false);
            }
        }

        return $this->container->get('templating')->renderResponse(
            $this->getView(), $this->getParameters(array('form' => $form->createView())));
    }
}
