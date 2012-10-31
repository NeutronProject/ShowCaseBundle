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

class ShowCaseRepository extends TranslationRepository
{
    public function getQueryBuilderForShowCaseManagementDataGrid()
    {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->select('s.id, c.id as category_id, s.title, c.slug, c.title as category, c.enabled, c.displayed')
            ->innerJoin('s.category', 'c')
            ->groupBy('s.id')
        ;
        
        return $qb;
    }
}