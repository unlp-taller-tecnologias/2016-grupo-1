<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExamenRepository extends EntityRepository
{
    public function findAllQB()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->orderBy('e.fecha');

        return $qb;
    }

    public function findByPaciente($paciente)
    {
        $qb = $this->findAllQB();
        $qb
            ->where('e.paciente = :paciente')
            ->setParameter('paciente', $paciente)
        ;

        return $qb;
    }
}
