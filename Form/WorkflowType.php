<?php

namespace GOC\WorkflowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class WorkflowType extends AbstractType
{
    private $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id', 'hidden')
                ->add('data', $this->form);
    }

    function getName()
    {
        return 'workflow';
    }
}
