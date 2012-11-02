<?php
namespace Neutron\Plugin\ShowCaseBundle\Form\Backend\Handler;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ProjectHandler extends AbstractFormHandler
{    
    protected function onSuccess()
    {   
        $general = $this->form->get('general')->getData();

        $this->container->get('neutron_show_case.project_manager')->update($general, true);
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_show_case.backend.project');
    }
}