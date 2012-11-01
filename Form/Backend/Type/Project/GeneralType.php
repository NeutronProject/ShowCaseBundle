<?php 
namespace Neutron\Plugin\ShowCaseBundle\Form\Backend\Type\Project;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class GeneralType extends AbstractType
{
      
    protected $projectClass;
    
    protected $projectImageClass;
    
    protected $imageOptions;

    protected $templates;
    
    protected $translationDomain;
    
    public function setProjectClass($projectClass)
    {
        $this->projectClass = $projectClass;
    }
    
    public function setProjectImageClass($projectImageClass)
    {
        $this->projectImageClass = $projectImageClass;
    }
    
    public function setImageOptions(array $imageOptions)
    {
        $this->imageOptions = $imageOptions;
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
            ->add('slug', 'text', array(
                'label' => 'form.slug',
                'translation_domain' => $this->translationDomain
            ))
            ->add('description', 'neutron_input_limiter', array(
                'label' => 'form.description',
                'type' => 'textarea',
                'configs' => array(
                    'limit' => 255
                ),
                'translation_domain' => $this->translationDomain
            ))
            ->add('content', 'neutron_tinymce', array(
                'label' => 'form.content',
                'security' => array('ROLE_SUPER_ADMIN'),
                'configs' => array(
                    'theme' => 'advanced', //simple
                    'skin'  => 'o2k7',
                    'skin_variant' => 'black',
                    //'width' => '60%',
                    'height' => 300,
                    'dialog_type' => 'modal',
                    'readOnly' => false,
                ),
                'translation_domain' => $this->translationDomain
            ))
            ->add('projectDate', 'neutron_datepicker', array(
                'label' => 'form.projectDate',
                'input' => 'datetime',
                'attr' => array(),
                'configs' => array(),
                'translation_domain' => $this->translationDomain
            ))
            ->add('clientName', 'text', array(
                'label' => 'form.clientName',
                'translation_domain' => $this->translationDomain
            ))
            ->add('projectUrl', 'text', array(
                'label' => 'form.projectUrl',
                'translation_domain' => $this->translationDomain
            ))
            ->add('name', 'neutron_multi_image_upload_collection', array(
                'options' => array(
                    'data_class' => $this->projectImageClass
                ),
                'configs' => array(
                    'minWidth' => $this->imageOptions['min_width'],
                    'minHeight' => $this->imageOptions['min_height'],
                    'extensions' => $this->imageOptions['extensions'],
                    'maxSize' => $this->imageOptions['max_size'],
                    'runtimes' => $this->imageOptions['runtimes']
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
            'data_class' => $this->projectClass, 
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));    
    }
    
    public function getName()
    {
        return 'neutron_backend_show_case_project_general';
    }
    
}