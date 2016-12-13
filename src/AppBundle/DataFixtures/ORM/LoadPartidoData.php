<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Partido;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPartidoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $partidos = [
            'La Plata' => null,
            'Florencio Varela' => null,
            'Berisso' => null,
            'Quilmes' => null,
            'Berazategui' => null,
            'Adrogue' => null,
            'Pergamino' => null,
            'San Pedro' => null,
            'Ensenada' => null,
            'Lobos' => null,
            'Brandsen' => null,
            'Calzada' => null,
            'Tandil' => null,
            'Trenque Lauquen' => null,
        ];

        foreach ($partidos as $nombre => $partido) {
            $partido = new Partido();
            $partido->setPartido($nombre);
            $partidos[$nombre] = $partido;

            $manager->persist($partido);
        }

        $manager->flush();

        $this->addReference('La Plata', $partidos['La Plata']);
    }

    public function getOrder()
    {
        return 2;
    }
}
