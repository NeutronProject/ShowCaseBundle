<?php
namespace Neutron\Plugin\ShowCaseBundle\Form\Backend\Handler;

use Neutron\AdminBundle\Acl\AclManager;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ShowCaseHandler extends AbstractFormHandler
{    
    protected function onSuccess()
    {   
        $content = $this->form->get('content')->getData();
        $category = $content->getCategory();

        $this->container->get('neutron_show_case.show_case_manager')->update($content);
 
        $acl = $this->form->get('acl')->getData();
        $this->container->get('neutron_admin.acl.manager')
            ->setObjectPermissions(ObjectIdentity::fromDomainObject($category), $acl);
        
        $this->container->get('object_manager')->flush();
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_show_case.backend.show_case');
    }
}