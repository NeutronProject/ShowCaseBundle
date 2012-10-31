<?php
namespace Neutron\Plugin\ShowCaseBundle\DataGrid;

use Neutron\Plugin\ShowCaseBundle\Model\ShowCaseManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class ShowCaseManagementDataGrid
{

    const IDENTIFIER = 'neutron_show_case_management';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             ShowCaseManagerInterface $manager, $translationDomain)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->router = $router;
        $this->manager = $manager;
        $this->translationDomain = $translationDomain;
    }

    public function build ()
    {
        
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption(
                $this->translator->trans('grid.show_case_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                'category_id',
                $this->translator->trans('grid.show_case_management.title',  array(), $this->translationDomain),
                $this->translator->trans('grid.show_case_management.slug',  array(), $this->translationDomain),
                $this->translator->trans('grid.show_case_management.category',  array(), $this->translationDomain),
                $this->translator->trans('grid.show_case_management.displayed',  array(), $this->translationDomain),
                $this->translator->trans('grid.show_case_management.enabled',  array(), $this->translationDomain),

            ))
            ->setColModel(array(
                array(
                    'name' => 'c.id', 'index' => 'c.id', 'hidden' => true,
                ), 
                array(
                    'name' => 's.title', 'index' => 's.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'c.slug', 'index' => 'c.slug', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'c.title', 'index' => 'c.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'c.displayed', 'index' => 'c.displayed', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ), 
                        
                array(
                    'name' => 'c.enabled', 'index' => 'c.enabled',  'width' => 40, 
                    'align' => 'left',  'sortable' => true, 
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ),

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForShowCaseManagementDataGrid())
            ->setSortName('s.title')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_show_case.backend.show_case.update', array('id' => '{c.id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_show_case.backend.show_case.delete', array('id' => '{c.id}'), true))
            ->setFetchJoinCollection(false)
        ;

        return $dataGrid;
    }



}