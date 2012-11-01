<?php

namespace Neutron\Plugin\ShowCaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_show_case');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronShowCaseBundle')->end()
            ->end()
        ;
    }
    
    private function addShowCaseConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('show_case')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('reference_class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('manager')->defaultValue('neutron_show_case.show_case_manager.default')->end()
                            ->scalarNode('controller_backend')->defaultValue('neutron_show_case.controller.backend.show_case.default')->end()
                            ->scalarNode('controller_frontend')->defaultValue('neutron_show_case.controller.frontend.show_case.default')->end()
                            ->scalarNode('datagrid_management')->defaultValue('neutron_show_case_management')->end()
                            ->arrayNode('templates')
                                ->useAttributeAsKey('name')
                                    ->prototype('scalar')
                                ->end() 
                                ->cannotBeOverwritten()
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('form_backend')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('type')->defaultValue('neutron_backend_show_case')->end()
                                        ->scalarNode('handler')->defaultValue('neutron_show_case.form.backend.handler.show_case.default')->end()
                                        ->scalarNode('name')->defaultValue('neutron_backend_show_case')->end()
                                        ->scalarNode('datagrid')->defaultValue('neutron_show_case_project_multi_select_sortable')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addProjectConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('project')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('manager')->defaultValue('neutron_show_case.project_manager.default')->end()
                            ->scalarNode('controller_backend')->defaultValue('neutron_show_case.controller.backend.project.default')->end()
                            ->scalarNode('controller_frontend')->defaultValue('neutron_show_case.controller.frontend.project.default')->end()
                            ->scalarNode('datagrid_management')->defaultValue('neutron_show_case_project_management')->end()
                            ->arrayNode('templates')
                                ->useAttributeAsKey('name')
                                    ->prototype('scalar')
                                ->end() 
                                ->cannotBeOverwritten()
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('form_backend')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('type')->defaultValue('neutron_backend_show_case_project')->end()
                                        ->scalarNode('handler')->defaultValue('neutron_show_case.form.backend.handler.project.default')->end()
                                        ->scalarNode('name')->defaultValue('neutron_backend_show_case_project')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('image_options')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('min_width')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('min_height')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('extensions')->defaultValue('jpeg,jpg')->end()
                                        ->scalarNode('max_size')->defaultValue('2M')->end()
                                        ->scalarNode('runtimes')->defaultValue('html5,flash')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
}
