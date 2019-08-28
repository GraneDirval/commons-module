<?php

namespace CommonDataBundle\Repository;


use CommonDataBundle\Repository\Interfaces\CountryRepositoryInterface;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

/**
 * Class CountryRepository
 */
class CountryRepository extends EntityRepository implements CountryRepositoryInterface
{
    /**
     * @return array
     */
    public function findEnabledCarriersCountryCodes(): array
    {
        $qb = $this->createQueryBuilder('v');
        $qb->innerJoin('carrier', 'c','WITH', 'c.countryCode = v.countryCode AND c.published = true')
            ->select('v')
            ->groupBy('c.countryCode');

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_OBJECT);
    }
}