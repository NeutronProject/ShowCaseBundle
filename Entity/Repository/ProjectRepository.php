<?php
/*
 * This file is part of NeutronShowCaseBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ShowCaseBundle\Entity\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ProjectRepository extends TranslationRepository
{
    public function getQueryBuilderForProjectManagementDataGrid()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.id, p.title, p.slug, p.clientName');
        
        return $qb;
    }
}