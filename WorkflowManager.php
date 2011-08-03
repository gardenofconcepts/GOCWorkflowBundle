<?php

namespace GOC\WorkflowBundle;

use Symfony\Component\DependencyInjection\Container;

use GOC\WorkflowBundle\Entity\Progress;

class WorkflowManager
{
    private $container;
    private $progress;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function create($definition, $id)
    {
        if (!is_object($definition)) {
            $definition = $this->loadDefinitionByString($definition);
        }

        if (is_object($definition) && !$definition instanceof WorkflowDefinition) {
            throw Exception::illegalDefinitionObject($definition);
        }

        $em = $this->container->get('doctrine')->getEntityManager();

        // TODO: nicht sonderlich sauber ;)
        if (!$id) {
            $progress = new Progress();
            $progress->setName($definition->getName());
        } else if ($id instanceof Progress) {
            $progress = $id;
        } else if ($id > 0) {
            $progress = $em->find('GOCWorkflowBundle:Progress', $id);
        }

        $em->persist($progress);
        $em->flush();

        return new Workflow($this->container, $definition, $progress);
    }

    public function loadDefinitionByString($definition)
    {
        if (!preg_match('#^([_a-zA-Z0-9]+Bundle):([/_a-zA-Z0-9]+)$#', $definition, $matches)) {
            throw Exception::illegalDefinitionString($definition);
        }

        $bundle = $matches[1];
        $class = $matches[2];

        $bundle = preg_replace('#([A-Z])#', '/\1', $bundle);
        $bundle = substr($bundle, 1, -strlen('_Bundle')) . 'Bundle';

        $class = '/' . $bundle . '/Workflow/' . $class;
        $class = str_replace('/', '\\', $class);

        return new $class($this->container);
    }
}
