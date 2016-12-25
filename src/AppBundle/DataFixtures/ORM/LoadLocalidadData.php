<?php namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Localidad;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLocalidadData extends AbstractFixture implements OrderedFixtureInterface {
    public function load(ObjectManager $manager) {
        $partidos = [
            'La Plata' => [
                'Villa Elvira' => null,
                'Los Hornos' => null,
                'Barrio Aeropuerto' => null,
                'La Plata' => null,
                'Barrio Jardín' => null,
                'Villa Montoro' => null,
                'Las Quintas' => null,
                'Villa Alba' => null,
                'Barrio Monasterio' => null,
                'City Bell' => null,
                'Tolosa' => null,
                'Lisandro Olmos' => null,
                'Parque Sicardi' => null,
                'Melchor Romero' => null,
                'San Carlos' => null,
                'Ringuelet' => null,
                'Gonnet' => null,
                'Villa Elisa' => null,
                'Arturo Seguí' => null
            ],
            'Berisso' => [
                'Berisso' => null,
                'Los Talas' => null,
                'El Carmen' => null,
                'Villa Argüello' => null
            ],
            'Ensenada' => [
                'Ensenada' => null,
                'Punta Lara' => null,
                'Villa Catela' => null,
                'El Dique' => null
            ],
            'Adolfo Alsina' => [
                'Carhué' => null
            ],
            'Alberti' => [
                'Alberti' => null
            ],
            'Almirante Brown' => [
                'Burzaco' => null,
                'Adrogué' => null,
                'Glew' => null,
                'Claypole' => null,
                'Longchamps' => null,
                'Rafael Calzada' => null,
                'José Mármol' => null
            ],
            'Avellaneda' => [
                'Avellaneda' => null,
                'Sarandí' => null,
                'Villa Domínico' => null
            ],
            'Ayacucho' => [
                'Ayacucho' => null
            ],
            'Azul' => [
                'Azul' => null
            ],
            'Bahía Blanca' => [
                'Bahía Blanca' => null,
                'Cabuldo' => null,
                'General Cerri' => null
            ],
            'Balcarce' => [
                'Balcarce' => null
            ],
            'Baradero' => [
                'Baradero' => null
            ],
            'Arrecifes' => [
                'Arrecifes' => null
            ],
            'Bolívar' => [
                'Bolívar' => null
            ],
            'Bragado' => [
                'Bragado' => null,
                'Mechita' => null
            ],
            'Coronel Brandsen' => [
                'Coronel Brandsen' => null,
                'Gómez' => null
            ],
            'Campana' => [
                'Campana' => null
            ],
            'Cañuelas' => [
                'Cañuelas' => null,
                'Uribelarrea' => null
            ],
            'Carlos Casares' => [
                'Carlos Casares' => null
            ],
            'Carlos Tejedor' => [
                'Carlos Tejedor' => null
            ],
            'Carmen de Areco' => [
                'Carmen de Areco' => null
            ],
            'Daireaux' => [
                'Daireaux' => null
            ],
            'Castelli' => [
                'Castelli' => null
            ],
            'Colón' => [
                'Colón' => null
            ],
            'Coronel Dorrego' => [
                'Coronel Dorrego' => null
            ],
            'Coronel Pringles' => [
                'Coronel Pringles' => null
            ],
            'Coronel Suárez' => [
                'Coronel Suárez' => null
            ],
            'Lanús' => [
                'Lanús' => null,
                'Remedios de Escalada' => null,
                'Monte Chingolo' => null
            ],
            'Chacabuco' => [
                'Chacabuco' => null
            ],
            'Chascomús' => [
                'Chascomús' => null
            ],
            'Chivilcoy' => [
                'Chivilcoy' => null
            ],
            'Dolores' => [
                'Dolores' => null
            ],
            'Esteban Echeverría' => [
                'Monte Grande' => null
            ],
            'Exaltación de la Cruz' => [
                'Capilla del Señor' => null
            ],
            'Florencio Varela' => [
                'Florencio Varela' => null,
                'Gobernador Costa' => null,
                'Ingeniero Allan' => null,
                'Zeballos' => null,
                'Bosques' => null,
                'Villa Vatteone' => null
            ],
            'General Alvarado' => [
                'Miramar' => null,
                'Mechongué' => null
            ],
            'General Alvear' => [
                'General Alvear' => null
            ],
            'General Arenales' => [
                'General Arenales' => null
            ],
            'General Belgrano' => [
                'General Belgrano' => null
            ],
            'General Guido' => [
                'General Guido' => null,
                'Labardén' => null
            ],
            'Zárate' => [
                'Zárate' => null,
                'Lima' => null
            ],
            'General Madariaga' => [
                'General Madariaga' => null
            ],
            'General Lamadrid' => [
                'General Lamadrid' => null
            ],
            'General Las Heras' => [
                'General Las Heras' => null
            ],
            'General Lavalle' => [
                'General Lavalle' => null
            ],
            'General Paz' => [
                'Ranchos' => null,
                'Villanueva' => null,
                'Loma Verde' => null
            ],
            'General Pinto' => [
                'General Pinto' => null
            ],
            'General Pueyrredón' => [
                'Mar del Plata' => null,
                'Batán' => null,
                'Sierra de los Padres' => null
            ],
            'General Rodríguez' => [
                'General Rodríguez' => null
            ],
            'General San Martín' => [
                'Billinghurst' => null,
                'Loma Hermosa' => null,
                'José León Suárez' => null,
                'San Andrés' => null,
                'San Martín' => null,
                'Villa Ballester' => null,
                'Villa Lynch' => null,
                'Villa Maipú' => null
            ],
            'General Viamonte' => [
                'Los Toldos' => null
            ],
            'General Villegas' => [
                'General Villegas' => null
            ],
            'Gonzales Chaves' => [
                'Adolfo Gonzales Chaves' => null
            ],
            'Guaminí' => [
                'Guaminí' => null
            ],
            'Benito Juárez' => [
                'Benito Juárez' => null
            ],
            'Junín' => [
                'Juntín' => null
            ],
            'Laprida' => [
                'Laprida' => null
            ],
            'Tigre' => [
                'Tigre' => null
            ],
            'Las Flores' => [
                'Las Flores' => null
            ],
            'Leandro N. Alem' => [
                'Vedia' => null
            ],
            'Lincoln' => [
                'Lincoln' => null
            ],
            'Lobería' => [
                'Lobería' => null
            ],
            'Lobos' => [
                'Lobos' => null
            ],
            'Lomas de Zamora' => [
                'Lomas de Zamora' => null,
                'Temperley' => null,
                'Banfield' => null,
                'Llavallol' => null,
                'Turdera' => null,
                'Villa Centenario' => null,
                'Villa Fiorito' => null,
                'Ingeniero Budge' => null,
                'Villa Albertina' => null,
                'San José' => null
            ],
            'Luján' => [
                'Luján' => null
            ],
            'Magdalena' => [
                'Atalaya' => null,
                'Magdalena' => null
            ],
            'Maipú' => [
                'Maipú' => null,
                'Las Armas' => null
            ],
            'Salto' => [
                'Salto' => null
            ],
            'Marcos Paz' => [
                'Marcos Paz' => null
            ],
            'Mar Chiquita' => [
                'Santa Clara del Mar' => null,
                'Mar Chiquita' => null,
                'Coronel Vidal' => null,
                'Coronel Pirán' => null
            ],
            'La Matanza' => [
                'San Justo' => null,
                '20 de Junio' => null,
                'Aldo Bonzi' => null,
                'Ciudad Evita' => null,
                'González Catán' => null,
                'Gregorio de Laferrere' => null,
                'Isidro Casanova' => null,
                'La Tablada' => null,
                'Lomas del Mirador' => null,
                'Rafael Castillo' => null,
                'Ramos Mejía' => null,
                'Tapiales' => null,
                'Villa Luzuriaga' => null,
                'Villa Madero' => null,
                'Virrey del Pino' => null
            ],
            'Mercedes' => [
                'Mercedes' => null
            ],
            'Merlo' => [
                'Merlo' => null,
                'San Antonio de Padua' => null,
                'Libertad' => null,
                'Mariano Acosta' => null
            ],
            'Monte' => [
                'San Miguel del Monte' => null
            ],
            'Moreno' => [
                'Moreno' => null,
                'La Reja' => null
            ],
            'Navarro' => [
                'Navarro' => null
            ],
            'Necochea' => [
                'Necochea' => null,
                'Quequén' => null
            ],
            'Nueve de Julio' => [
                'Nueve de Julio' => null
            ],
            'Olavarría' => [
                'Olavarría' => null
            ],
            'Patagones' => [
                'Carmen de Patagones' => null,
                'Stroeder' => null,
                'Villalonga' => null,
                'Pradere' => null
            ],
            'Pehuajó' => [
                'Pehuajó' => null
            ],
            'Pellegrini' => [
                'Pellegrini' => null
            ],
            'Pergamino' => [
                'Pergamino' => null
            ],
            'Pila' => [
                'Pila' => null
            ],
            'Pilar' => [
                'Pilar' => null,
                'Del Viso' => null
            ],
            'Puán' => [
                'Puán' => null
            ],
            'Quilmes' => [
                'Quilmes' => null,
                'Quilmes Oeste' => null,
                'Bernal' => null,
                'Bernal Oeste' => null,
                'Ezpeleta' => null,
                'Ezpeleta Oeste' => null,
                'San Francisco Solano' => null,
                'Villa La Florida' => null
            ],
            'Ramallo' => [
                'Ramallo' => null,
                'Estación Ramallo' => null
            ],
            'Rauch' => [
                'Rauch' => null
            ],
            'Rivadavia' => [
                'América' => null
            ],
            'Rojas' => [
                'Rojas' => null
            ],
            'Roque Pérez' => [
                'Roque Pérez' => null
            ],
            'Saavedra' => [
                'Pigüé' => null,
                'Saavedra' => null
            ],
            'Saladillo' => [
                'Saladillo' => null
            ],
            'San Andrés de Giles' => [
                'San Andrés de Giles' => null
            ],
            'San Antonio de Areco' => [
                'San Antonio de Areco' => null
            ],
            'San Fernando' => [
                'San Fernando' => null,
                'Victoria' => null,
                'Virreyes' => null
            ],
            'San Isidro' => [
                'San Isidro' => null,
                'Beccar' => null,
                'Martínez' => null,
                'Acassuso' => null,
                'Boulogne Sur Mer' => null,
                'Villa Adelina' => null
            ],
            'San Nicolás' => [
                'San Nicolás de los Arroyos' => null
            ],
            'San Pedro' => [
                'San Pedro' => null
            ],
            'San Vicente' => [
                'San Vicente' => null,
                'Alejandro Korn' => null,
                'Domselaar' => null
            ],
            'Morón' => [
                'Castelar' => null,
                'Morón' => null,
                'El Palomar' => null,
                'Haedo' => null
            ],
            'Suipacha' => [
                'Suipacha' => null
            ],
            'Tandil' => [
                'Tandil' => null
            ],
            'Tapalqué' => [
                'Tapalqué' => null
            ],
            'Tordillo' => [
                'Tordillo' => null
            ],
            'Tornquist' => [
                'Tornquist' => null,
                'Sierra de la Ventana' => null,
                'Saldungaray' => null,
                'Villa Ventana' => null
            ],
            'Trenque Lauquen' => [
                'Trenque Lauquen' => null
            ],
            'Tres Arroyos' => [
                'Tres Arroyos' => null,
                'Claromecó' => null,
                'Copetonas' => null,
                'Orense' => null,
                'Reta' => null
            ],
            'Veinticinco de Mayo' => [
                'Veinticinco de Mayo' => null,
                'Norberto de la Riestra' => null,
                'Gobernador Ugarte' => null
            ],
            'Vicente López' => [
                'Vicente López' => null,
                'Carapachay' => null,
                'Florida' => null,
                'Florida Oeste' => null,
                'La Lucila' => null,
                'Munro' => null,
                'Olivos' => null,
                'Villa Martelli' => null,
                'Villa Adelina' => null
            ],
            'Villarino' => [
                'Médanos' => null,
                'Pedro Luro' => null,
                'Mayor Buratovich' => null,
                'Hilario Ascasubi' => null
            ],
            'Coronel Rosales' => [
                'Punta Alta' => null
            ],
            'San Cayetano' => [
                'San Cayetano' => null
            ],
            'Tres de Febrero' => [
                'Ciudadela' => null,
                'José Ingenieros' => null,
                'Villa Raffo' => null,
                'Sáenz Peña' => null,
                'Caseros' => null,
                'Villa Bosch' => null,
                'Martín Coronado' => null,
                'Lomas del Palomar' => null,
                'Pablo Podestá' => null,
                'Loma Hermosa' => null
            ],
            'Escobar' => [
                'Belén de Escobar' => null,
                'Garín' => null,
                'Ingeniero Maschwitz' => null
            ],
            'Hipólito Yrigoyen' => [
                'Henderson' => null
            ],
            'Berazategui' => [
                'Berazategui' => null,
                'Hudson' => null,
                'Gutiérrez' => null,
                'Ranelagh' => null,
                'Sourigues' => null,
                'Pereyra' => null,
                'Plátanos' => null,
                'Villa España' => null,
                'El Pato' => null
            ],
            'Capitán Sarmiento' => [
                'Capitán Sarmiento' => null
            ],
            'Salliqueló' => [
                'Salliqueló' => null
            ],
            'La Costa' => [
                'San Clemente del Tuyú' => null,
                'Las Toninas' => null,
                'Costa Chica' => null,
                'Santa Teresita' => null,
                'Mar del Tuyú' => null,
                'Costa del Este' => null,
                'Aguas Verdes' => null,
                'La Lucila del Mar' => null,
                'Costa Azul' => null,
                'San Bernardo del Tuyú' => null,
                'Mar de Ajó' => null,
                'Nueva Atlantis' => null,
                'Punta Médanos' => null,
                'Pinar del Sol' => null,
                'Costa Esmeralda' => null
            ],
            'Pinamar' => [
                'Pinamar' => null,
                'Ostende' => null,
                'Valeria del Mar' => null,
                'Cariló' => null
            ],
            'Villa Gesell' => [
                'Villa Gesell' => null,
                'Mar Azul' => null,
                'Mar de las Pampas' => null,
                'Las Gaviotas' => null
            ],
            'Monte Hermoso' => [
                'Monte Hermoso' => null
            ],
            'Tres Lomas' => [
                'Tres Lomas' => null
            ],
            'Florentino Ameghino' => [
                'Florentino Ameghino' => null
            ],
            'Presidente Perón' => [
                'Guernica' => null
            ],
            'Ezeiza' => [
                'Ezeiza' => null,
                'Canning' => null,
                'Carlos Spegazzini' => null,
                'La Unión' => null,
                'Tristán Suárez' => null
            ],
            'San Miguel' => [
                'Bella Vista' => null,
                'Muñiz' => null,
                'San Miguel' => null,
                'Campo de Mayo' => null,
                'Santa María' => null
            ],
            'José C. Paz' => [
                'José C. Paz' => null
            ],
            'Malvinas Argentinas' => [
                'Gran Bourg' => null,
                'Los Polvorines' => null,
                'Malvinas Argentinas' => null,
                'Tortuguitas' => null
            ],
            'Punta Indio' => [
                'Verónica' => null,
                'Punta Indio' => null,
                'Pipinas' => null,
                'Álvarez Jonte' => null
            ],
            'Hurlingham' => [
                'Hurlingham' => null,
                'Villa Tesei' => null,
                'William C. Morris' => null
            ],
            'Ituzaingó' => [
                'Ituzaingó' => null,
                'Parque Leloir' => null
            ],
            'Lezama' => [
                'Lezama' => null
            ],
            'Otro' => [
                'Otra' => null
            ]
        ];

        foreach ($partidos as $partidoNombre => $localidades) {
            $partido = $this->getReference($partidoNombre);
            foreach ($localidades as $localidadNombre => $localidad) {
                $localidad = new Localidad();
                $localidad->setLocalidad($localidadNombre);
                $localidad->setPartido($partido);
                $localidades[$localidadNombre] = $localidad;

                $manager->persist($localidad);
            }
        }

        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }

}
