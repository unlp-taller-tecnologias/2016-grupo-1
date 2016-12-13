<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Examen;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadExamenData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $paciente = $this->getReference('paciente');
        $medico = $this->getReference('medico');
        $examen = new Examen($paciente, $medico);
        $examen
            ->addMedicacion($this->getReference('medicacion'))
            ->addFactor($this->getReference('factor'))
            ->setRuido1(true)
            ->setSoplos(true)
            ->setAntecedentes('Lorem ipsum Laborum nulla tempor consectetur id ad ex magna laborum culpa.')
            ->setDerivadoDesde('Lorem ipsum Amet irure ea Ut ad.')
            ->setProcedimiento('Lorem ipsum Sed voluptate voluptate consequat fugiat in reprehenderit pariatur dolor id sunt occaecat nisi dolor amet officia minim commodo nostrud quis.')
            ->setElectrocardiograma('Lorem ipsum Occaecat enim irure velit consectetur do nostrud qui exercitation exercitation ad cupidatat in irure in Ut consectetur labore irure.')
            ->setComentarios('Lorem ipsum Dolore cupidatat et quis commodo Excepteur consectetur consectetur eu irure amet voluptate sit ullamco Duis laborum ut in non nostrud enim mollit culpa deserunt ut amet ut nulla esse cupidatat ut nostrud id irure nostrud.')
            ->setGradoRiesgo(4)
            ->setFecha(new \DateTime('yesterday'))
        ;

        $manager->persist($examen);
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
