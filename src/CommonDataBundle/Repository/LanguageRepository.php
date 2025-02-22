<?php

namespace CommonDataBundle\Repository;


use CommonDataBundle\Entity\Interfaces\LanguageInterface;
use CommonDataBundle\Repository\Interfaces\LanguageRepositoryInterface;

/**
 * Class LanguageRepository
 */
class LanguageRepository extends \Doctrine\ORM\EntityRepository implements LanguageRepositoryInterface
{
    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getEnglishLanguageId()
    {
        return $this->createQueryBuilder('p2o')
            ->select('p2o.id')
            ->where("p2o.code = 'en'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByCode(string $code): ?LanguageInterface
    {
        return $this->findOneBy(['code' => $code]);
    }
}