<?php
namespace Neutron\Plugin\ShowCaseBundle\Model;

interface ShowCaseInterface
{
    public function getId();
    
    public function getTitle();
    
    public function setTitle($title);
    
    public function getTemplate();
    
    public function setTemplate($template);
    
    public function getProjectReferences();
    
    public function addProjectReference(ProjectReferenceInterface $projectReference);
    
    public function removeProjectReference(ProjectReferenceInterface $projectReference);
}