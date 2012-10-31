<?php
namespace Neutron\Plugin\ShowCaseBundle\Entity;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectImageInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\MvcBundle\Model\SluggableInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ShowCaseInterface;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 *
 */
abstract class AbstractProject implements ProjectInterface, SluggableInterface, SeoAwareInterface
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
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="slug", length=255, nullable=false, unique=false)
     */
    protected $slug;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="description", length=255, nullable=true, unique=false)
     */
    protected $description;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", name="content", nullable=true)
     */
    protected $content;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="project_date")
     */
    protected $projectDate;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="client_name", length=255, nullable=true, unique=false)
     */
    protected $clientName;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="project_url", length=255, nullable=true, unique=false)
     */
    protected $projectUrl;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=true, unique=false)
     */
    protected $template;
    
    /**
     * @ORM\ManyToMany(targetEntity="Neutron\Plugin\ShowCaseBundle\Model\ProjectImageInterface", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     * @ORM\JoinTable(
     *   inverseJoinColumns={@ORM\JoinColumn(unique=true,  onDelete="CASCADE")}
     * )
     */
    protected $images;
 
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\SeoBundle\Entity\Seo", cascade={"all"}, orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $seo;

	public function __construct()
    {
        $this->images = new ArrayCollection();
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
    
    public function getSlug ()
    {
        return $this->slug;
    }
    
    public function setSlug ($slug)
    {
        $this->slug = $slug;
    }
    
    public function getDescription ()
    {
        return $this->description;
    }
    
    public function setDescription ($description)
    {
        $this->description = $description;
    }
    
    public function getContent ()
    {
        return $this->content;
    }
    
    public function setContent ($content)
    {
        $this->content = $content;
    }
    
    public function getProjectDate ()
    {
        return $this->projectDate;
    }
    
    public function setProjectDate ($projectDate)
    {
        $this->projectDate = $projectDate;
    }
    
    public function getClientName ()
    {
        return $this->clientName;
    }
    
    public function setClientName ($clientName)
    {
        $this->clientName = $clientName;
    }
    
    public function getProjectUrl ()
    {
        return $this->projectUrl;
    }
    
    public function setProjectUrl ($projectUrl)
    {
        $this->projectUrl = $projectUrl;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function addImage(ProjectImageInterface $image)
    {
        if (!$this->images->contains($image)){
            $this->images->add($image);
        }
    }
    
    public function setImages(array $images)
    {
        foreach ($this->images as $image){
            $this->addImage($image);
        }
    }
    
    public function getImages()
    {
        return $this->images;
    }
    
    public function removeImage(ProjectImageInterface $image)
    {
        if ($this->images->contains($image)){
            $this->images->removeElement($image);
        }
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