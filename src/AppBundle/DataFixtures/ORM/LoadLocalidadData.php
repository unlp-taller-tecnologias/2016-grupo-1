<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Localidad;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLocalidadData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $partidos = [
            'La Plata' => [
                'Villa Elvira' => null,
                'Los Hornos' => null,
                'Aeropuerto' => null,
                'Centro' => null,
                'El Mondongo' => null,
                'Barrio Jardín' => null,
                'Villa Montoro' => null,
                'Las Quintas' => null,
                'Villa Alba' => null,
                'Monasterio' => null,
                'City Bell' => null,
                'Tolosa' => null,
                'Olmos' => null,
                'Parque Cicardi' => null,
                'Romero' => null,
                'El Dique' => null,
                'Cementerio' => null,
                'La Loma' => null,
                'Gambier' => null,
            ],
        ];

        foreach ($partidos as $partidoNombre => $localidades) {
            $partido = $this->getReference($partidoNombre);
            foreach ($localidades as $localidadNombre => $localidad) {
                $localidad = new Localidad();
                $localidad->setLocalidad($localidadNombre);
                $localidad->setPartido($partido);
                $localidades[$localidadNombre] = $localidad;

                $manager->persist($localidad);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
