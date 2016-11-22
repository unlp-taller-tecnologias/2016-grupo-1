<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * PacienteRepository
 */
class PacienteRepository extends EntityRepository
{
    public function findAllServicio()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)');

        return $qb;
    }

    public function findAllPrequirugicos()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)');

        return $qb;
    }

    public function findAllByMultiParametros($parametros)
    {
        $qb = $this->createQueryBuilder('p');

        if (!(is_array($parametros) && count($parametros) > 0)) {
            return $qb;
        }

        if (!empty($parametros['dni'])) {
            $qb->andWhere('p.dni = :dni');
            $qb->setParameter('dni', $parametros['dni']);

            return $qb;
        }

        if (!empty($parametros['apellido'])) {
            $qb->andWhere('p.apellido LIKE :apellido');
            $qb->setParameter('apellido', '%' . $parametros['apellido'] . '%');
        }

        if (!empty($parametros['nombre'])) {
            $qb->andWhere('p.nombre LIKE :nombre');
            $qb->setParameter('nombre', '%' . $parametros['nombre'] . '%');
        }

        if (!empty($parametros['tipo'])) {
            if ($parametros['tipo'] === 'preq') {
                $qb->andWhere('EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)');
            } elseif ($parametros['tipo'] === 'serv') {
                $qb->andWhere('EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)');
            } elseif ($parametros['tipo'] === 'nuevos') {
                $qb->andWhere('NOT EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)');
                $qb->andWhere('NOT EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)');
            }
        }

        return $qb;
    }

}
