<?php namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PacienteRepository
 */
class PacienteRepository extends EntityRepository {
    public function findAllPrequirugicos() {
        return $this->getEntityManager()
                ->createQueryBuilder()
                ->select("p")
                ->from("AppBundle:Paciente", "p")
                ->andwhere("EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)");
        ;
    }
    
    public function findAllServicio() {
        return $this->getEntityManager()
                ->createQueryBuilder()
                ->select("p")
                ->from("AppBundle:Paciente", "p")
                ->andwhere("EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)");
        ;
    }
    public function findAllByMultiParametros($parametros) {
        $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select("p")
                ->from("AppBundle:Paciente", "p")
        ;
        if (!(is_array($parametros) && count($parametros) > 0)) {
            return $query;
        }

        if (isset($parametros["dni"]) && !empty($parametros["dni"])) {
            $query->andwhere("p.dni = :dni");
            $query->setParameter("dni", $parametros["dni"]);
            return $query;
        }

        if (isset($parametros["apellido"]) && !empty($parametros["apellido"])) {
            $query->andwhere("p.apellido LIKE :apellido");
            $query->setParameter("apellido", '%' . $parametros["apellido"] . '%');
        }

        if (isset($parametros["nombre"]) && !empty($parametros["nombre"])) {
            $query->andwhere("p.nombre LIKE :nombre");
            $query->setParameter("nombre", '%' . $parametros["nombre"] . '%');
        }

        if (isset($parametros["tipo"]) && !empty($parametros["tipo"]) && $parametros["tipo"] == "preq") {
            $query->andwhere("EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)");
        }
        if (isset($parametros["tipo"]) && !empty($parametros["tipo"]) && $parametros["tipo"] == "serv") {
            $query->andwhere("EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)");
        }
        if (isset($parametros["tipo"]) && !empty($parametros["tipo"]) && $parametros["tipo"] == "nuevos") {
            $query->andwhere("NOT EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)");
            $query->andwhere("NOT EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)");
        }
        return $query;
    }

}
