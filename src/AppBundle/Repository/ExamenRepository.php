<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Examen;
use Doctrine\ORM\EntityRepository;

class ExamenRepository extends EntityRepository
{
    public function findAllQB() {
        $qb = $this->createQueryBuilder('e');
        $qb->orderBy('e.fecha');

        return $qb;
    }

    public function findByPaciente($paciente) {
        $qb = $this->findAllQB();
        $qb
            ->where('e.paciente = :paciente')
            ->setParameter('paciente', $paciente)
        ;

        return $qb;
    }

    /**
     * @param \PHPExcel $phpExcelObject
     * @param integer $sheetIndex
     */
    public function mk_backup_sheet(&$phpExcelObject, $sheetIndex) {
        $phpExcelObject->setActiveSheetIndex($sheetIndex);
        $phpExcelObject->getActiveSheet()->setTitle("Prequirúrgicos");
        $i = 2;
        $phpExcelObject->getActiveSheet()->setCellValue("A1", "#");
        $phpExcelObject->getActiveSheet()->setCellValue("B1", "Apellido");
        $phpExcelObject->getActiveSheet()->setCellValue("C1", "Nombre");
        $phpExcelObject->getActiveSheet()->setCellValue("D1", "#Paciente");
        $phpExcelObject->getActiveSheet()->setCellValue("E1", "Medico");
        $phpExcelObject->getActiveSheet()->setCellValue("F1", "Fecha");
        $phpExcelObject->getActiveSheet()->setCellValue("G1", "Derivado desde");
        $phpExcelObject->getActiveSheet()->setCellValue("H1", "Procedimiento");
        $phpExcelObject->getActiveSheet()->setCellValue("I1", "Antecedentes");
        $phpExcelObject->getActiveSheet()->setCellValue("J1", "Factores de riesgo");
        $phpExcelObject->getActiveSheet()->setCellValue("K1", "Otros factores");
        $phpExcelObject->getActiveSheet()->setCellValue("L1", "Medicación");
        $phpExcelObject->getActiveSheet()->setCellValue("M1", "Otra medicación");
        $phpExcelObject->getActiveSheet()->setCellValue("N1", "Ruido 1");
        $phpExcelObject->getActiveSheet()->setCellValue("O1", "Ruido 2");
        $phpExcelObject->getActiveSheet()->setCellValue("P1", "Ruido 3");
        $phpExcelObject->getActiveSheet()->setCellValue("Q1", "Ruido 4");
        $phpExcelObject->getActiveSheet()->setCellValue("R1", "TA");
        $phpExcelObject->getActiveSheet()->setCellValue("S1", "Soplos");
        $phpExcelObject->getActiveSheet()->setCellValue("T1", "Obs. soplos");
        $phpExcelObject->getActiveSheet()->setCellValue("U1", "Ap. respiratorio");
        $phpExcelObject->getActiveSheet()->setCellValue("V1", "ECG");
        $phpExcelObject->getActiveSheet()->setCellValue("W1", "Comentarios");
        $phpExcelObject->getActiveSheet()->setCellValue("X1", "Grado de riesgo");
        /** @var Examen $row */
        foreach ($this->findAll() as $row) {
            $phpExcelObject->getActiveSheet()->setCellValue("A$i", $row->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("B$i", $row->getPaciente()->getApellido());
            $phpExcelObject->getActiveSheet()->setCellValue("C$i", $row->getPaciente()->getNombre());
            $phpExcelObject->getActiveSheet()->setCellValue("D$i", $row->getPaciente()->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("E$i", $row->getMedico()->getApellido() . ", " . $row->getMedico()->getNombre());
            $phpExcelObject->getActiveSheet()->setCellValue("F$i", date_format($row->getFecha(), 'd/m/Y'));
            $phpExcelObject->getActiveSheet()->setCellValue("G$i", $row->getDerivadoDesde());
            $phpExcelObject->getActiveSheet()->setCellValue("H$i", $row->getProcedimiento());
            $phpExcelObject->getActiveSheet()->setCellValue("I$i", $row->getAntecedentes());
            $factores = array();
            foreach ($row->getFactores() as $factor) {
                $factores[] = $factor->getFactor();
            }
            $phpExcelObject->getActiveSheet()->setCellValue("J$i", implode('; ', $factores));
            $phpExcelObject->getActiveSheet()->setCellValue("K$i", $row->getOtrosFactores());
            $medicaciones = array();
            foreach ($row->getMedicaciones() as $medicacion) {
                $medicaciones[] = $medicacion->getMedicacion();
            }
            $phpExcelObject->getActiveSheet()->setCellValue("L$i", implode('; ', $medicaciones));
            $phpExcelObject->getActiveSheet()->setCellValue("M$i", $row->getOtrasMedicaciones());
            $phpExcelObject->getActiveSheet()->setCellValue("N$i", $row->getRuido1());
            $phpExcelObject->getActiveSheet()->setCellValue("O$i", $row->getRuido2());
            $phpExcelObject->getActiveSheet()->setCellValue("P$i", $row->getRuido3());
            $phpExcelObject->getActiveSheet()->setCellValue("Q$i", $row->getRuido4());
            $phpExcelObject->getActiveSheet()->setCellValue("R$i", $row->getTensionArterialSistolica() . "/" . $row->getTensionArterialDiastolica());
            $phpExcelObject->getActiveSheet()->setCellValue("S$i", $row->getSoplos());
            $phpExcelObject->getActiveSheet()->setCellValue("T$i", $row->getSoplosComentario());
            $phpExcelObject->getActiveSheet()->setCellValue("U$i", $row->getAparatoRespiratorio());
            $phpExcelObject->getActiveSheet()->setCellValue("V$i", $row->getElectrocardiograma());
            $phpExcelObject->getActiveSheet()->setCellValue("W$i", $row->getComentarios());
            $phpExcelObject->getActiveSheet()->setCellValue("X$i", $row->getGradoRiesgo());
            $i++;
        }
    }

}
