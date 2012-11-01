<?php
namespace Neutron\Plugin\ShowCaseBundle\Controller\Frontend;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class ShowCaseController extends ContainerAware
{
    
    public function indexAction(CategoryInterface $category)
    {   

        $showCaseManager = $this->container->get('neutron_show_case.show_case_manager');
        $entity = $showCaseManager->findOneBy(array('category' => $category));
        
        if (null === $entity){
            throw new NotFoundHttpException();
        }
       
        $template = $this->container->get('templating')->render(
            $entity->getTemplate(), array(
                'entity'   => $entity,     
            )
        );
    
        return  new Response($template);
    }
  
}
