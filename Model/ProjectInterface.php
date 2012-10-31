<?php
namespace Neutron\Plugin\ShowCaseBundle\Model;

interface ProjectInterface
{
    public function getId();
    
    public function getTitle();
    
    public function setTitle($title);
    
    public function getDescription ();
    
    public function setDescription ($description);
    
    public function getContent ();
    
    public function setContent ($content);
    
    public function getProjectDate ();
    
    public function setProjectDate ($projectDate);
    
    public function getClientName ();
    
    public function setClientName ($clientName);
    
    public function getProjectUrl ();
    
    public function setProjectUrl ($projectUrl);
    
    public function getTemplate();
    
    public function setTemplate($template);
    
    public function addImage(ProjectImageInterface $image);
    
    public function setImages(array $images);
    
    public function getImages();
    
    public function removeImage(ProjectImageInterface$image);
}