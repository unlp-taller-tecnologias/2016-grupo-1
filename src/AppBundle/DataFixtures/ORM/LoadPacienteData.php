<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Paciente;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPacienteData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $partido = $this->getReference('La Plata');
        $localidad = $partido->getLocalidades()[0];

        $paciente = new Paciente();
        $paciente
            ->setNombre('John')
            ->setApellido('Doe')
            ->setDni('00000000')
            ->setSexo('masculino')
            ->setLocalidad($localidad)
            ->setObraSocial('IOMA')
            ->setEdad(40)
            ->setMedico($this->getReference('medico'))
        ;

        $manager->persist($paciente);
        $manager->flush();

        $this->setReference('paciente', $paciente);
    }

    public function getOrder()
    {
        return 4;
    }
}
