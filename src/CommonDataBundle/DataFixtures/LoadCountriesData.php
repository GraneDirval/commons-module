<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 4/17/18
 * Time: 4:11 PM
 */

namespace CommonDataBundle\DataFixtures;


use CommonDataBundle\Entity\Country;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ExtrasBundle\Utils\FixtureDataLoader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadCountriesData extends AbstractFixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = FixtureDataLoader::loadDataFromJSONFile(__DIR__ . '/Data/', 'countries.json');

        foreach ($data as $row) {
            $countryCode = $row['countryCode'];
            $countryName = $row['countryName'];
            $currency = $row['currencyCode'];
            $isoNumeric = $row['isoNumeric'];
            $isoAlpha = $row['isoAlpha3'];
            $uuid = $row['uuid'];

            $country = new Country($uuid);
            $country->setCountryCode($countryCode);
            $country->setCountryName($countryName);
            $country->setCurrencyCode($currency);
            $country->setIsoNumeric($isoNumeric);
            $country->setIsoAlpha3($isoAlpha);
            $this->addReference(sprintf('country_%s', $uuid), $country);

            $manager->persist($country);
        }

        $manager->flush();

    }

}