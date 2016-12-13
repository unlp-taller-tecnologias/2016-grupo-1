<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUsuarioData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $admin = new Usuario();
        $admin
            ->setUsername('00000000')
            ->setNombre('Admin')
            ->setApellido('Usuario')
            ->setProfesion('secretario')
            ->setEmail('admin@gmail.com')
            ->setPlainPassword('admin')
            ->addRole('ROLE_ADMIN')
            ->setEnabled(true)
        ;
        $manager->persist($admin);

        $medico = new Usuario();
        $medico
            ->setUsername('01010101')
            ->setNombre('Médico')
            ->setApellido('Usuario')
            ->setProfesion('médico')
            ->setEmail('medico@gmail.com')
            ->setPlainPassword('medico')
            ->addRole('ROLE_MEDICO')
            ->setEnabled(true)
        ;
        $manager->persist($medico);

        $manager->flush();

        $this->addReference('medico', $medico);
    }

    public function getOrder()
    {
        return 1;
    }
}
