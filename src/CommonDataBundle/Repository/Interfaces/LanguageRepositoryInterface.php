<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 05.03.19
 * Time: 17:05
 */

namespace CommonDataBundle\Repository\Interfaces;

use CommonDataBundle\Entity\Interfaces\LanguageInterface;

interface LanguageRepositoryInterface
{
    public function findByCode(string $code): ?LanguageInterface;
}