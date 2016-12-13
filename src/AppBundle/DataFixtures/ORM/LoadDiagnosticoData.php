<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Diagnostico;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDiagnosticoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $diagnosticos = [
            'Accidente cerebrovascular' => null,
            'Arritmia' => null,
            'Cardiopatía isquémica ' => null,
            'Derrame pericárdico' => null,
            'Endocarditis' => null,
            'Enfermedad vascular periférica ' => null,
            'Hipertensión Arterial' => null,
            'Insuficiencia cardíaca' => null,
            'Lipotimia' => null,
            'Miocarditis' => null,
            'Miocardiopatía' => null,
            'Pericarditis' => null,
            'Síncope' => null,
            'Valvulopatías' => null,
        ];

        foreach ($diagnosticos as $diagnosticoNombre => $diagnostico) {
            $diagnostico = new Diagnostico();
            $diagnostico->setDiagnostico($diagnosticoNombre);
            $diagnosticos[$diagnosticoNombre] = $diagnostico;

            $manager->persist($diagnostico);
        }

        $manager->flush();

        $this->addReference('diagnostico', $diagnostico);
    }

    public function getOrder()
    {
        return 6;
    }
}
