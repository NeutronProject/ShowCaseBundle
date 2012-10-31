<?php
namespace Neutron\Plugin\ShowCaseBundle\Doctrine;

use Neutron\Plugin\ShowCaseBundle\Model\ProjectManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class ProjectManager extends AbstractManager implements ProjectManagerInterface
{
    public function getQueryBuilderForProjectManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForProjectManagementDataGrid();
    }
}