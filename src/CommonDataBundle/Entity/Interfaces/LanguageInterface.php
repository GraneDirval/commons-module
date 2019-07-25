<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 05.03.19
 * Time: 17:03
 */

namespace CommonDataBundle\Entity\Interfaces;


interface LanguageInterface
{

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;
}