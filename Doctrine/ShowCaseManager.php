<?php
namespace Neutron\Plugin\ShowCaseBundle\Doctrine;

use Neutron\Plugin\ShowCaseBundle\Model\ShowCaseManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class ShowCaseManager extends AbstractManager implements ShowCaseManagerInterface
{
    public function getQueryBuilderForShowCaseManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForShowCaseManagementDataGrid();
    }
}