<?php


namespace CommonDataBundle\Repository\Interfaces;


interface CountryRepositoryInterface
{
    public function findEnabledCarriersCountryCodes(): array;
}