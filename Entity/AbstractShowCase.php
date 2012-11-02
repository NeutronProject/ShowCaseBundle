<?php
namespace Neutron\Plugin\ShowCaseBundle\Entity;

use Neutron\SeoBundle\Model\SeoInterface;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\MvcBundle\Model\CategoryAwareInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectReferenceInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Neutron\Plugin\ShowCaseBundle\Model\ShowCaseInterface;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 *
 */
abstract class AbstractShowCase implements ShowCaseInterface, CategoryAwareInterface, SeoAwareInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string 
     * 
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="title", length=255, nullable=true, unique=false)
     */
    protected $title;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=true, unique=false)
     */
    protected $template;
    
    /**
     * @ORM\OneToMany(targetEntity="Neutron\Plugin\ShowCaseBundle\Model\ProjectReferenceInterface", mappedBy="showCase", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $projectReferences;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\MvcBundle\Model\Category\CategoryInterface", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $category;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\SeoBundle\Entity\Seo", cascade={"all"}, orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $seo;
    
    public function __construct()
    {
        $this->projectReferences = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function getProjectReferences()
    {
        return $this->projectReferences;
    }
    
    public function addProjectReference(ProjectReferenceInterface $projectReference)
    { 
        if (!$this->projectReferences->contains($projectReference)){ 
            $this->projectReferences->add($projectReference);
            $projectReference->setShowCase($this);
        }
    
        return $this;
    }
    
    
    public function removeProjectReference(ProjectReferenceInterface $projectReference)
    {
        if ($this->projectReferences->contains($projectReference)){
            $this->projectReferences->removeElement($projectReference);
        }
    
        return $this;
    }
    
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
        return $this;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
        return $this;
    }
    
    public function getSeo()
    {
        return $this->seo;
    }
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}