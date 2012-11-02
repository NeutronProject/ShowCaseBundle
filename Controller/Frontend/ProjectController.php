<?php
namespace Neutron\Plugin\ShowCaseBundle\Controller\Frontend;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class ProjectController extends ContainerAware
{
    
    public function indexAction($categorySlug, $projectSlug)
    {   
        
        $categoryManager = $this->container->get('neutron_mvc.category.manager');
        
        $projectManager = $this->container->get('neutron_show_case.project_manager');
     
        $category = $categoryManager
            ->findCategoryBySlug($categorySlug, true, $this->container->get('request')->getLocale());
        
        if (null === $category){
            throw new NotFoundHttpException();
        }
        
        if (false === $this->container->get('neutron_admin.acl.manager')->isGranted($category, 'VIEW')){
            throw new AccessDeniedException();
        }

        $project = $projectManager->findOneBy(array('slug' => $projectSlug));
        
        if (null === $project){
            throw new NotFoundHttpException();
        }
        
        $template = $this->container->get('templating')->render(
            $project->getTemplate(), array(
                'category' => $category,
                'entity' => $project,     
            )
        );
    
        return  new Response($template);
    }
   
}
