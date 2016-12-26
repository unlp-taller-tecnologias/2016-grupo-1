<?php namespace AppBundle\Repository;

use AppBundle\Entity\Paciente;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * PacienteRepository
 */
class PacienteRepository extends EntityRepository {
    public function findAllServicio() {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('EXISTS (SELECT v FROM AppBundle:Visita v WHERE v.paciente = p)');
        $qb->orWhere(' p.medico IS NOT NULL ');
        $qb->orderBy('p.apellido, p.nombre, p.dni');
        return $qb;
    }

    public function findAllPrequirugicos() {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('EXISTS (SELECT e FROM AppBundle:Examen e WHERE e.paciente = p)');

        return $qb;
    }

    public function findAllByMultiParametros($parametros) {
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

        if (!empty($parametros['medico'])) {
            $qb->andWhere('p.medico = :medico');
            $qb->setParameter('medico', $parametros['medico']);
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

        return $qb->orderBy('p.apellido, p.nombre, p.dni');
    }

    /**
     * @param \PHPExcel $phpExcelObject
     * @param integer $sheetIndex
     */
    public function mk_backup_sheet(&$phpExcelObject, $sheetIndex) {
        $phpExcelObject->setActiveSheetIndex($sheetIndex);
        $phpExcelObject->getActiveSheet()->setTitle("Pacientes");
        $i = 2;
        $phpExcelObject->getActiveSheet()->setCellValue("A1", "#");
        $phpExcelObject->getActiveSheet()->setCellValue("B1", "Apellido");
        $phpExcelObject->getActiveSheet()->setCellValue("C1", "Nombre");
        $phpExcelObject->getActiveSheet()->setCellValue("D1", "DNI");
        $phpExcelObject->getActiveSheet()->setCellValue("E1", "Edad");
        $phpExcelObject->getActiveSheet()->setCellValue("F1", "Sexo");
        $phpExcelObject->getActiveSheet()->setCellValue("G1", "Localidad");
        $phpExcelObject->getActiveSheet()->setCellValue("H1", "Partido");
        $phpExcelObject->getActiveSheet()->setCellValue("I1", "Obra social");
        $phpExcelObject->getActiveSheet()->setCellValue("J1", "Tiene Historia clínica");
        $phpExcelObject->getActiveSheet()->setCellValue("K1", "Tiene Prequirúrgicos");
        /** @var Paciente $row */
        foreach ($this->findAll() as $row) {
            $phpExcelObject->getActiveSheet()->setCellValue("A$i", $row->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("B$i", $row->getApellido());
            $phpExcelObject->getActiveSheet()->setCellValue("C$i", $row->getNombre());
            $phpExcelObject->getActiveSheet()->setCellValue("D$i", $row->getDni());
            $phpExcelObject->getActiveSheet()->setCellValue("E$i", $row->getEdad());
            $phpExcelObject->getActiveSheet()->setCellValue("F$i", $row->getSexo());
            $phpExcelObject->getActiveSheet()->setCellValue("G$i", $row->getLocalidad()->getLocalidad());
            $phpExcelObject->getActiveSheet()->setCellValue("H$i", $row->getLocalidad()->getPartido());
            $phpExcelObject->getActiveSheet()->setCellValue("I$i", $row->getObraSocial());

            $servicio = (count($row->getVisitas()) > 0) ? "Sí" : "No";
            $preq = (count($row->getExamenes()) > 0) ? "Sí" : "No";
            $phpExcelObject->getActiveSheet()->setCellValue("J$i", $servicio);
            $phpExcelObject->getActiveSheet()->setCellValue("K$i", $preq);
            $i++;
        }
    }

}
