<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VisitaRepository extends EntityRepository
{
    public function findAllQB()
    {
        $qb = $this->createQueryBuilder('v');
        $qb->orderBy('v.fecha');

        return $qb;
    }

    public function findByPaciente($paciente)
    {
        $qb = $this->findAllQB();
        $qb
            ->where('v.paciente = :paciente')
            ->setParameter('paciente', $paciente)
        ;

        return $qb;
    }
}
