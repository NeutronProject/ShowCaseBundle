<?php 
namespace Neutron\Plugin\ShowCaseBundle\Form\Backend\Type\ShowCase;

use Neutron\Bundle\DataGridBundle\DataGrid\DataGridInterface;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class ContentType extends AbstractType
{
    
    protected $dataGrid;

    protected $showCaseClass;
    
    protected $projectReferenceClass;
    
    protected $projectClass;

    protected $templates;
    
    protected $translationDomain;
    
    public function setDataGrid(DataGridInterface $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }
    
    public function setShowCaseClass($showCaseClass)
    {
        $this->showCaseClass = $showCaseClass;
    }

    public function setProjectReferenceClass($projectReferenceClass)
    {
        $this->projectReferenceClass = $projectReferenceClass;
    }
    
    public function setProjectClass($projectClass)
    {
        $this->projectClass = $projectClass;
    }
    
    public function setTemplates(array $templates)
    {
        $this->templates = $templates;
    }
    
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {   
        $builder
            ->add('title', 'text', array(
                'label' => 'form.title',
                'translation_domain' => $this->translationDomain
            ))
            ->add('projectReferences', 'neutron_multi_select_sortable_collection', array(
                'label' => 'form.projectReference',
                'grid' => $this->dataGrid,
                'translation_domain' => $this->translationDomain,
                'options' => array(
                    'data_class' => $this->projectReferenceClass,
                    'inversed_class' => $this->projectClass,
                    'inversed_name' => 'project',
                )
            ))
            ->add('template', 'choice', array(
                'choices' => $this->templates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.template',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => $this->showCaseClass, 
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));    
    }
    
    public function getName()
    {
        return 'neutron_backend_show_case_content';
    }
    
}