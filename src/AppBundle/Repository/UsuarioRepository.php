<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Usuario;
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

    /**
     * @param \PHPExcel $phpExcelObject
     * @param integer $sheetIndex
     */
    public function mk_backup_sheet(&$phpExcelObject, $sheetIndex)
    {
        $phpExcelObject->setActiveSheetIndex($sheetIndex);
        $phpExcelObject->getActiveSheet()->setTitle("Usuarios");
        $i = 2;
        $phpExcelObject->getActiveSheet()->setCellValue("A1", "#");
        $phpExcelObject->getActiveSheet()->setCellValue("B1", "Usuario");
        $phpExcelObject->getActiveSheet()->setCellValue("C1", "Nombre");
        $phpExcelObject->getActiveSheet()->setCellValue("D1", "Apellido");
        $phpExcelObject->getActiveSheet()->setCellValue("E1", "Teléfono");
        $phpExcelObject->getActiveSheet()->setCellValue("F1", "Rol");
        $phpExcelObject->getActiveSheet()->setCellValue("G1", "Matricula");
        $phpExcelObject->getActiveSheet()->setCellValue("H1", "Especialidad");
        /** @var Usuario $row */
        foreach ($this->findAll() as $row) {
            $phpExcelObject->getActiveSheet()->setCellValue("A$i", $row->getId());
            $phpExcelObject->getActiveSheet()->setCellValue("B$i", $row->getUsername());
            $phpExcelObject->getActiveSheet()->setCellValue("C$i", $row->getNombre());
            $phpExcelObject->getActiveSheet()->setCellValue("D$i", $row->getApellido());
            $phpExcelObject->getActiveSheet()->setCellValue("E$i", $row->getTelefono());
            $phpExcelObject->getActiveSheet()->setCellValue("F$i", $row->getProfesion());
            $phpExcelObject->getActiveSheet()->setCellValue("G$i", $row->getMatricula());
            $phpExcelObject->getActiveSheet()->setCellValue("H$i", $row->getEspecialidad());
            $i++;
        }
    }
}
