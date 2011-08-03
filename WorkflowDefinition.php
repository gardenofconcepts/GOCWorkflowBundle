<?php

namespace GOC\WorkflowBundle;

use Symfony\Component\DependencyInjection\Container;

class WorkflowDefinition
{
    private $container;
    private $form;
    private $data;
    private $view;
    private $parameters = array();

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute($action, $progress, $data)
    {
        echo $action;
        
        $this->setView('GOCWorkflowBundle::Workflow/process.html.twig');

        if ($action == 'init') {
            $this->setForm(new \Adticket\Elvis\CommunicationBundle\Form\MailingBlock());
            $this->setData($this->container->get('doctrine')->getEntityManager()->find('AdticketElvisCommunicationBundle:MailingBlock', 1));
            return;
        }

        if ($action == 'next') {
            $this->setForm(new \Adticket\Elvis\ContactBundle\Form\Contact\AddressType());
            $this->setData(new \Adticket\Elvis\ContactBundle\Entity\Contact\Address());
        }
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
