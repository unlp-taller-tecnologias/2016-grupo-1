<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Factor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFactorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $factores = [
            'Dislipemia' => null,
            'Diabetes' => null,
            'Hipertensión arterial' => null,
            'Obesidad' => null,
            'Sedentarismo' => null,
            'Stress' => null,
            'Tabaquismo' => null,
        ];

        foreach ($factores as $factorNombre => $factor) {
            $factor = new Factor();
            $factor->setFactor($factorNombre);
            $factores[$factorNombre] = $factor;

            $manager->persist($factor);
        }

        $manager->flush();

        $this->addReference('factor', $factor);
    }

    public function getOrder()
    {
        return 8;
    }
}
