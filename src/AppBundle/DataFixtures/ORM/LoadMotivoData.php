<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Motivo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMotivoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $motivos = [
            'Claudicación intermitente' => null,
            'Control' => null,
            'Disnea' => null,
            'Dolor precordial' => null,
            'Edemas' => null,
            'Fatiga' => null,
            'Hipertención arterial' => null,
            'Lipotimia' => null,
            'Mareos' => null,
            'Palpitaciones' => null,
            'Pérdida de conocimiento' => null,
            'Síncope' => null,
            'Síntomas neurológicos' => null,
        ];

        foreach ($motivos as $motivoNombre => $motivo) {
            $motivo = new Motivo();
            $motivo->setMotivo($motivoNombre);
            $motivos[$motivoNombre] = $motivo;

            $manager->persist($motivo);
        }

        $manager->flush();

        $this->addReference('motivo', $motivo);
    }

    public function getOrder()
    {
        return 5;
    }
}
