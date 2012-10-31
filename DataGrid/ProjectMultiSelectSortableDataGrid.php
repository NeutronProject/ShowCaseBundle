<?php
namespace Neutron\Plugin\ShowCaseBundle\DataGrid;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class ProjectMultiSelectSortableDataGrid
{

    const IDENTIFIER = 'neutron_show_case_project_multi_select_sortable';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;
   

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             ProjectManagerInterface $manager, $translationDomain)
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
                $this->translator->trans('grid.project_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.project_management.title',  array(), $this->translationDomain),
                $this->translator->trans('grid.project_management.slug',  array(), $this->translationDomain),
                $this->translator->trans('grid.project_management.client_name',  array(), $this->translationDomain),
            ))
            ->setColModel(array(
                array(
                    'name' => 'p.title', 'index' => 'p.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'p.slug', 'index' => 'p.slug', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'p.clientName', 'index' => 'p.clientName', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForProjectManagementDataGrid())
            ->setSortName('p.title')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableMultiSelectSortable(true)
            ->setMultiSelectSortableColumn('p.title')
       ;

        return $dataGrid;
    }



}