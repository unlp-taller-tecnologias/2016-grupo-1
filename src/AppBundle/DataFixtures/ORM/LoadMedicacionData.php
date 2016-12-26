<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Medicacion;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMedicacionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $medicaciones = [
            'AAS' => null,
            'IECA' => null,
            'Antiarrítmicos' => null,
            'Nitratos' => null,
            'B.Bloq.' => null,
            'Bloq.Ca++' => null,
        ];

        foreach ($medicaciones as $medicacionNombre => $medicacion) {
            $medicacion = new Medicacion();
            $medicacion->setMedicacion($medicacionNombre);
            $medicaciones[$medicacionNombre] = $medicacion;

            $manager->persist($medicacion);
        }

        $manager->flush();

        $this->setReference('medicacion', $medicacion);
    }

    public function getOrder()
    {
        return 9;
    }
}
