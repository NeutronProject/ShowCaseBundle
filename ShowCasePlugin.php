<?php
namespace Neutron\Plugin\ShowCaseBundle;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Neutron\MvcBundle\Plugin\PluginFactoryInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\Routing\RouterInterface;

use Neutron\MvcBundle\MvcEvents;

use Neutron\MvcBundle\Event\ConfigurePluginEvent;

class ShowCasePlugin
{
    const IDENTIFIER = 'neutron.plugin.show_case';
    
    protected $dispatcher;
    
    protected $factory;
    
    protected $router;
    
    protected $translator;
    
    protected $translationDomain;
    
    public function __construct(EventDispatcher $dispatcher, PluginFactoryInterface $factory, 
            RouterInterface $router, TranslatorInterface $translator, $translationDomain)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->router = $router;
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
        
    }
    
    public function build()
    {
        $plugin = $this->factory->createPlugin(self::IDENTIFIER);
        $plugin
            ->setLabel($this->translator->trans('plugin.show_case.label', array(), $this->translationDomain))
            ->setDescription($this->translator->trans('plugin.show_case.description', array(), $this->translationDomain))
            ->setFrontendRoute('neutron_show_case.frontend.show_case')
            ->setUpdateRoute('neutron_show_case.backend.show_case.update')
            ->setDeleteRoute('neutron_show_case.backend.show_case.delete')
            ->setManagerServiceId('neutron_show_case.show_case_manager')
            ->addBackendPage(array(
                'name'      => 'show_case.management',
                'label'     => 'show_case.management.label',
                'route'     => 'neutron_show_case.backend.show_case',
                'displayed' => true
           ))
            ->addBackendPage(array(
                'name'      => 'project.management',
                'label'     => 'project.management.label',
                'route'     => 'neutron_show_case.backend.project',
                'displayed' => true
           ))
            ->setTreeOptions(array(
                'children_strategy' => 'self',
            ))
        ;
        
        $this->dispatcher->dispatch(
            MvcEvents::onPluginConfigure, 
            new ConfigurePluginEvent($this->factory, $plugin)
        );
        
        return $plugin;
    }
    
}