<?php

namespace Neutron\Plugin\ShowCaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronShowCaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach (array('services', 'show_case', 'project') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }         
        
        $this->loadGeneralConfigurations($config, $container);
        
        $this->loadShowCaseConfigurations($config['show_case'], $container);
        
        $this->loadProjectConfigurations($config['project'], $container);
    }
    
    protected function loadGeneralConfigurations(array $config, ContainerBuilder $container)
    {
        if ($config['enable'] === false){
            $container->getDefinition('neutron_show_case.plugin')
                ->clearTag('neutron.plugin');
        }
        
        $container->setParameter('neutron_show_case.enable', $config['enable']);
        $container->setParameter('neutron_show_case.translation_domain', $config['translation_domain']);    
    }
    
    protected function loadShowCaseConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_show_case.show_case_class', $config['class']);
        $container->setParameter('neutron_show_case.project_reference_class', $config['reference_class']);
        $container->setAlias('neutron_show_case.show_case_manager', $config['manager']);    
        $container->setAlias('neutron_show_case.controller.backend.show_case', $config['controller_backend']);    
        $container->setAlias('neutron_show_case.controller.frontend.show_case', $config['controller_frontend']);    
        $container->setParameter('neutron_show_case.datagrid.show_case_management', $config['datagrid_management']);    
        $container->setParameter('neutron_show_case.show_case_templates', $config['templates']);    
        $container->setParameter('neutron_show_case.form.backend.type.show_case', $config['form_backend']['type']);    
        $container->setParameter('neutron_show_case.form.backend.name.show_case', $config['form_backend']['name']);    
        $container->setAlias('neutron_show_case.form.backend.handler.show_case', $config['form_backend']['handler']);    
        $container->setParameter('neutron_show_case.form.backend.datagrid.project_multi_select_sortable', $config['form_backend']['datagrid']);    
    }
    
    protected function loadProjectConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_show_case.project_class', $config['class']);
        $container->setParameter('neutron_show_case.project_main_image_class', $config['main_image_class']);
        $container->setParameter('neutron_show_case.project_image_class', $config['image_class']);
        $container->setAlias('neutron_show_case.project_manager', $config['manager']);    
        $container->setAlias('neutron_show_case.controller.backend.project', $config['controller_backend']);    
        $container->setAlias('neutron_show_case.controller.frontend.project', $config['controller_frontend']);    
        $container->setParameter('neutron_show_case.datagrid.project_management', $config['datagrid_management']);    
        $container->setParameter('neutron_show_case.project_templates', $config['templates']);    
        $container->setParameter('neutron_show_case.project_image_options', $config['image_options']);    
        $container->setParameter('neutron_show_case.project_main_image_options', $config['main_image_options']);    
        $container->setParameter('neutron_show_case.form.backend.type.project', $config['form_backend']['type']);    
        $container->setParameter('neutron_show_case.form.backend.name.project', $config['form_backend']['name']);    
        $container->setAlias('neutron_show_case.form.backend.handler.project', $config['form_backend']['handler']);    
    }
}
