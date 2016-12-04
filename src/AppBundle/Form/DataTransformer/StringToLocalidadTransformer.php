<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Issue;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToLocalidadTransformer implements DataTransformerInterface {
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    /**
     * Transorma un objeto Localidad en su id (string).
     *
     * @param  Issue|null $localidad
     * @return string
     */
    public function transform($localidad) {
        if (null === $localidad) {
            return '';
        }

        return $localidad->getId();
    }

    /**
     * Transformar un id en una localidad.
     *
     * @param  string $id
     * @return Localidad|null
     * @throws TransformationFailedException si no se encuentra una localidad.
     */
    public function reverseTransform($id) {
        if (!$id) {
            return;
        }

        $localidad = $this->manager
                ->getRepository('AppBundle:Localidad')
                ->find($id)
        ;

        if (null === $localidad) {
            throw new TransformationFailedException(
                    'Por favor, seleccione una localidad válida para continuar'
            );
        }

        return $localidad;
    }

}
