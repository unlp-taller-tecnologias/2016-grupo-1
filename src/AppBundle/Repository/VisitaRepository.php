<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Visita;
use Doctrine\ORM\EntityRepository;

class VisitaRepository extends EntityRepository
{
    public function findAllQB()
    {
        $qb = $this->createQueryBuilder('v');
        $qb->orderBy('v.fecha', 'desc');

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

    public function cantXPartido($inicio, $fin, $partido = null)
    {
        $qb = $this->createQueryBuilder('v');

        $parameters = [
            'inicio' => $inicio,
            'fin' => $fin,
        ];

        if ($partido !== null) {
            $qb
                ->select('l.localidad AS lugar, COUNT(l.localidad) AS cant')
                ->where('par = :partido')
                ->addGroupBy('l.localidad')
            ;
            $parameters['partido'] = $partido;
        } else {
            $qb
                ->select('par.partido AS lugar, COUNT(par.partido) AS cant')
                ->addGroupBy('par.partido')
            ;
        }

        $qb
            ->join('v.paciente', 'pac')
            ->join('pac.localidad', 'l')
            ->join('l.partido', 'par')
            ->andWhere('v.fecha BETWEEN :inicio AND :fin')
            ->setParameters($parameters)
        ;

        $result = $qb->getQuery()->getArrayResult();

        return $result;
    }

    /**
     * @param \PHPExcel $phpExcelObject
     * @param integer $sheetIndex
     */
    public function mk_backup_sheet(&$phpExcelObject, $sheetIndex)
    {
        $phpExcelObject->setActiveSheetIndex($sheetIndex);
        $phpExcelObject->getActiveSheet()->setTitle("Visitas");
        $i = 2;
        $phpExcelObject->getActiveSheet()->setCellValue("A1", "#");
        $phpExcelObject->getActiveSheet()->setCellValue("B1", "Apellido");
        $phpExcelObject->getActiveSheet()->setCellValue("C1", "Nombre");
        $phpExcelObject->getActiveSheet()->setCellValue("D1", "#Paciente");
        $phpExcelObject->getActiveSheet()->setCellValue("E1", "Fecha");
        $phpExcelObject->getActiveSheet()->setCellValue("F1", "Médico");
        $phpExcelObject->getActiveSheet()->setCellValue("G1", "Motivo de consulta");
        $phpExcelObject->getActiveSheet()->setCellValue("H1", "Observaciones");
        $phpExcelObject->getActiveSheet()->setCellValue("I1", "Notas personales");
        $phpExcelObject->getActiveSheet()->setCellValue("J1", "Diagnóstico");
        /** @var Visita $row */
        foreach ($this->findAll() as $row) {
            $phpExcelObject->getActiveSheet()->setCellValue("A$i", $row->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("B$i", $row->getPaciente()->getApellido());
            $phpExcelObject->getActiveSheet()->setCellValue("C$i", $row->getPaciente()->getNombre());
            $phpExcelObject->getActiveSheet()->setCellValue("D$i", $row->getPaciente()->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("E$i", date_format($row->getFecha(), 'd/m/Y'));
            $phpExcelObject->getActiveSheet()->setCellValue("F$i", $row->getMedico()->getApellido() . ", " . $row->getMedico()->getNombre());
            $motivos = array();
            foreach ($row->getMotivos() as $motivo) {
                $motivos[] = $motivo->getMotivo();
            }
            $phpExcelObject->getActiveSheet()->setCellValue("G$i", implode('; ', $motivos));
            $phpExcelObject->getActiveSheet()->setCellValue("H$i", $row->getObservaciones());
            $phpExcelObject->getActiveSheet()->setCellValue("I$i", $row->getNotasPersonales());
            $diagnosticos = array();
            foreach ($row->getDiagnosticos() as $diagnostico) {
                $diagnosticos[] = $diagnostico->getDiagnostico();
            }
            $phpExcelObject->getActiveSheet()->setCellValue("J$i", implode('; ', $diagnosticos));
            $i++;
        }
    }
}
