<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Visita;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadVisitaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $paciente = $this->getReference('paciente');
        $medico = $this->getReference('medico');
        $visita = new Visita($paciente, $medico);
        $visita
            ->addMotivo($this->getReference('motivo'))
            ->addDiagnostico($this->getReference('diagnostico'))
            ->setObservaciones('Lorem ipsum Mollit dolore velit aliquip esse non nostrud nostrud dolore eu Duis aliquip aliqua in deserunt mollit sunt commodo labore minim eiusmod do id incididunt ut Duis eiusmod aliqua nisi officia veniam dolore in in ex fugiat.')
            ->setNotasPersonales('Lorem ipsum Ex Excepteur nostrud aliquip consequat dolor Excepteur ut et id veniam enim veniam incididunt reprehenderit nulla dolor laboris dolor.')
            ->setFecha(new \DateTime())
        ;

        $manager->persist($visita);
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}
