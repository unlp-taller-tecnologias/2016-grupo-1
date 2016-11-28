<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function isRemovable($usuario)
    {
        $visitasRepo = $this->getEntityManager()->getRepository('AppBundle:Visita');
        if ($visitasRepo->findOneBy(['medico' => $usuario])) {
            return false;
        }

        $examenesRepo = $this->getEntityManager()->getRepository('AppBundle:Examen');
        if ($examenesRepo->findOneBy(['medico' => $usuario])) {
            return false;
        }

        return true;
    }
}
