<?php
namespace Neutron\Plugin\ShowCaseBundle\Controller\Backend;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectInterface;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\SeoBundle\Model\SeoInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class ProjectController extends ContainerAware
{
    public function indexAction()
    {
        $datagrid = $this->container->get('neutron.datagrid')
            ->get($this->container->getParameter('neutron_show_case.datagrid.project_management'));
    
        $template = $this->container->get('templating')->render(
            'NeutronShowCaseBundle:Backend\Project:index.html.twig', array(
                'datagrid' => $datagrid,
                'translationDomain' =>
                    $this->container->getParameter('neutron_show_case.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {
        $form = $this->container->get('neutron_show_case.form.backend.project');
        $form->setData($this->getData($id));
        
        $handler = $this->container->get('neutron_show_case.form.backend.handler.project');
    
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronShowCaseBundle:Backend\Project:update.html.twig', array(
                'form' => $form->createView(),
                'translationDomain' => $this->container->getParameter('neutron_show_case.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $category = $this->getCategory($id);
        $entity = $this->getEntity($category);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($entity);
            $redirectUrl = $this->container->get('router')->generate('neutron_show_case.backend.project');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronShowCaseBundle:Backend\Project:delete.html.twig', array(
                'entity' => $entity,
                'translationDomain' => $this->container->getParameter('neutron_show_case.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    protected function doDelete(ProjectInterface $entity)
    {
        $this->container->get('neutron_show_case.project_manager')->delete($entity, true);
    }
    
    protected function getEntity($id)
    {
    
        $manager = $this->container->get('neutron_show_case.project_manager');
    
        if ($id){
            $entity = $manager->findOneBy(array('id' => $id));
        } else {
            $entity = $manager->create();
        }
    
        if (!$entity){
            throw new NotFoundHttpException();
        }
    
        return $entity;
    }
    
    protected function getSeo(SeoAwareInterface $entity)
    {
    
        if(!$entity->getSeo() instanceof SeoInterface){
            $entity->setSeo($this->container->get('neutron_seo.manager')->createSeo());
        }
    
        return $entity->getSeo();
    }
    
    protected function getData($id)
    {
        $entity = $this->getEntity($id);
        $seo = $this->getSeo($entity);
    
        return array(
            'general' => $entity,
            'seo'     => $seo,
        );
    }
}