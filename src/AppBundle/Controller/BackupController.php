<?php namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Examen;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BackupController extends Controller {
    /**
     * @Route("/backup", name="backup_index")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function backupAction(Request $request) {
        $form = $this->createForm('AppBundle\Form\BackupType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->do_backup();
        }

        return $this->render('backup/backup.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    private function do_backup() {
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Servicio de Cardiología - HIGA San Martín")
                ->setTitle("Copia de seguridad")
                ->setSubject("Sistema de Gestión de pacientes");

        $this->getDoctrine()->getRepository("AppBundle:Paciente")->mk_backup_sheet($phpExcelObject, 0);
        $phpExcelObject->addSheet(new \PHPExcel_Worksheet());
        $this->getDoctrine()->getRepository("AppBundle:Visita")->mk_backup_sheet($phpExcelObject, 1);
        $phpExcelObject->addSheet(new \PHPExcel_Worksheet());
        $this->getDoctrine()->getRepository("AppBundle:Examen")->mk_backup_sheet($phpExcelObject, 1);
        $phpExcelObject->addSheet(new \PHPExcel_Worksheet());
        $this->getDoctrine()->getRepository("AppBundle:Usuario")->mk_backup_sheet($phpExcelObject, 3);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'backup_'.date('Y-m-d-H-i-s').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
}
