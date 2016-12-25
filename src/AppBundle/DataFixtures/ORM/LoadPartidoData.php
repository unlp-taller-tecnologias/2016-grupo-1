<?php namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Partido;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPartidoData extends AbstractFixture implements OrderedFixtureInterface {
    public function load(ObjectManager $manager) {
        $partidos = [
            'Adolfo Alsina' => null,
            'Alberti' => null,
            'Almirante Brown' => null,
            'Avellaneda' => null,
            'Ayacucho' => null,
            'Azul' => null,
            'Bahía Blanca' => null,
            'Balcarce' => null,
            'Baradero' => null,
            'Arrecifes' => null,
            'Bolívar' => null,
            'Bragado' => null,
            'Coronel Brandsen' => null,
            'Campana' => null,
            'Cañuelas' => null,
            'Carlos Casares' => null,
            'Carlos Tejedor' => null,
            'Carmen de Areco' => null,
            'Daireaux' => null,
            'Castelli' => null,
            'Colón' => null,
            'Coronel Dorrego' => null,
            'Coronel Pringles' => null,
            'Coronel Suárez' => null,
            'Lanús' => null,
            'Chacabuco' => null,
            'Chascomús' => null,
            'Chivilcoy' => null,
            'Dolores' => null,
            'Esteban Echeverría' => null,
            'Exaltación de la Cruz' => null,
            'Florencio Varela' => null,
            'General Alvarado' => null,
            'General Alvear' => null,
            'General Arenales' => null,
            'General Belgrano' => null,
            'General Guido' => null,
            'Zárate' => null,
            'General Madariaga' => null,
            'General Lamadrid' => null,
            'General Las Heras' => null,
            'General Lavalle' => null,
            'General Paz' => null,
            'General Pinto' => null,
            'General Pueyrredón' => null,
            'General Rodríguez' => null,
            'General San Martín' => null,
            'General Viamonte' => null,
            'General Villegas' => null,
            'Gonzales Chaves' => null,
            'Guaminí' => null,
            'Benito Juárez' => null,
            'Junín' => null,
            'La Plata' => null,
            'Laprida' => null,
            'Tigre' => null,
            'Las Flores' => null,
            'Leandro N. Alem' => null,
            'Lincoln' => null,
            'Lobería' => null,
            'Lobos' => null,
            'Lomas de Zamora' => null,
            'Luján' => null,
            'Magdalena' => null,
            'Maipú' => null,
            'Salto' => null,
            'Marcos Paz' => null,
            'Mar Chiquita' => null,
            'La Matanza' => null,
            'Mercedes' => null,
            'Merlo' => null,
            'Monte' => null,
            'Moreno' => null,
            'Navarro' => null,
            'Necochea' => null,
            'Nueve de Julio' => null,
            'Olavarría' => null,
            'Patagones' => null,
            'Pehuajó' => null,
            'Pellegrini' => null,
            'Pergamino' => null,
            'Pila' => null,
            'Pilar' => null,
            'Puán' => null,
            'Quilmes' => null,
            'Ramallo' => null,
            'Rauch' => null,
            'Rivadavia' => null,
            'Rojas' => null,
            'Roque Pérez' => null,
            'Saavedra' => null,
            'Saladillo' => null,
            'San Andrés de Giles' => null,
            'San Antonio de Areco' => null,
            'San Fernando' => null,
            'San Isidro' => null,
            'San Nicolás' => null,
            'San Pedro' => null,
            'San Vicente' => null,
            'Morón' => null,
            'Suipacha' => null,
            'Tandil' => null,
            'Tapalqué' => null,
            'Tordillo' => null,
            'Tornquist' => null,
            'Trenque Lauquen' => null,
            'Tres Arroyos' => null,
            'Veinticinco de Mayo' => null,
            'Vicente López' => null,
            'Villarino' => null,
            'Coronel Rosales' => null,
            'Berisso' => null,
            'Ensenada' => null,
            'San Cayetano' => null,
            'Tres de Febrero' => null,
            'Escobar' => null,
            'Hipólito Yrigoyen' => null,
            'Berazategui' => null,
            'Capitán Sarmiento' => null,
            'Salliqueló' => null,
            'La Costa' => null,
            'Pinamar' => null,
            'Villa Gesell' => null,
            'Monte Hermoso' => null,
            'Tres Lomas' => null,
            'Florentino Ameghino' => null,
            'Presidente Perón' => null,
            'Ezeiza' => null,
            'San Miguel' => null,
            'José C. Paz' => null,
            'Malvinas Argentinas' => null,
            'Punta Indio' => null,
            'Hurlingham' => null,
            'Ituzaingó' => null,
            'Lezama' => null,
            'Otro' => null
        ];

        foreach ($partidos as $nombre => $partido) {
            $partido = new Partido();
            $partido->setPartido($nombre);
            $partidos[$nombre] = $partido;

            $manager->persist($partido);
        }

        $manager->flush();

        foreach (array_keys($partidos) as $partido) {
            $this->addReference($partido, $partidos[$partido]);
        }
    }

    public function getOrder() {
        return 2;
    }

}
