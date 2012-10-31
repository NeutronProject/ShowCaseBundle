<?php
namespace Neutron\Plugin\ShowCaseBundle\Entity;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableReferenceInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ShowCaseInterface;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectReferenceInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 *
 */
abstract class AbstractProjectReference 
    implements ProjectReferenceInterface, MultiSelectSortableReferenceInterface
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
     * @var integer
     *
     * @ORM\Column(type="integer", name="position", length=10, nullable=false, unique=false)
     */
    protected $position = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\ShowCaseBundle\Model\ShowCaseInterface", inversedBy="projectReferences")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $showCase;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\ShowCaseBundle\Model\ProjectInterface")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $project;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLabel()
    {
        return $this->project->getTitle();
    }
    
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getShowCase ()
    {
        return $this->showCase;
    }
    
    public function setShowCase (ShowCaseInterface $showCase)
    {
        $this->showCase = $showCase;
    }
    
    public function getProject ()
    {
        return $this->project;
    }
    
    public function setProject (ProjectInterface $project)
    {
        $this->project = $project;
    }
}