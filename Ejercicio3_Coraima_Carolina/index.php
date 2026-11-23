<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3 - EPD 6</title>
</head>
<body>
    <h1>Informe de actividades deportivas</h1>

    <?php
    // Registros proporcionados en el enunciado de la EPD 6.
    $cadenaEntrada = <<<'REGISTROS'
SOC001@@Spinning@@45@@15/01/2025@@Ana López@@Sala1
SOC001@@Natación@@30@@16/01/2025@@Miguel Torres@@Piscina1
SOC002@@Spinning@@45@@15/01/2025@@Ana López@@Sala1
SOC001@@Yoga@@60@@17/01/2025@@Carmen Ruiz@@Sala2
SOC003@@Natación@@30@@16/01/2025@@Miguel Torres@@Piscina1
SOC002@@Tenis@@90@@18/01/2025@@David García@@Pista1
SOC001@@Spinning@@45@@19/01/2025@@Ana López@@Sala1
SOC004@@Pilates@@50@@15/01/2025@@Laura Martín@@Sala3
SOC003@@Spinning@@45@@17/01/2025@@Ana López@@Sala1
SOC005@@Natación@@40@@16/01/2025@@Miguel Torres@@Piscina1
SOC004@@Yoga@@60@@18/01/2025@@Carmen Ruiz@@Sala2
SOC002@@Natación@@35@@20/01/2025@@Miguel Torres@@Piscina1
SOC006@@Tenis@@120@@17/01/2025@@David García@@Pista1
SOC001@@Pilates@@50@@21/01/2025@@Laura Martín@@Sala3
SOC007@@Spinning@@45@@18/01/2025@@Ana López@@Sala1
SOC003@@Yoga@@60@@20/01/2025@@Carmen Ruiz@@Sala2
SOC005@@Tenis@@90@@19/01/2025@@David García@@Pista1
SOC008@@Natación@@25@@17/01/2025@@Miguel Torres@@Piscina1
SOC006@@Spinning@@45@@21/01/2025@@Ana López@@Sala1
SOC004@@Natación@@40@@22/01/2025@@Miguel Torres@@Piscina1
SOC007@@Pilates@@55@@20/01/2025@@Laura Martín@@Sala3
SOC002@@Yoga@@60@@22/01/2025@@Carmen Ruiz@@Sala2
SOC009@@Spinning@@45@@19/01/2025@@Ana López@@Sala1
SOC008@@Tenis@@75@@21/01/2025@@David García@@Pista1
SOC005@@Pilates@@50@@23/01/2025@@Laura Martín@@Sala3
SOC010@@Natación@@30@@20/01/2025@@Miguel Torres@@Piscina1
SOC003@@Spinning@@45@@24/01/2025@@Ana López@@Sala1
SOC006@@Yoga@@60@@23/01/2025@@Carmen Ruiz@@Sala2
SOC009@@Natación@@35@@22/01/2025@@Miguel Torres@@Piscina1
SOC001@@Tenis@@105@@25/01/2025@@David García@@Pista1
SOC007@@Spinning@@45@@24/01/2025@@Ana López@@Sala1
SOC010@@Pilates@@50@@22/01/2025@@Laura Martín@@Sala3
SOC004@@Spinning@@45@@25/01/2025@@Ana López@@Sala1
SOC008@@Yoga@@60@@25/01/2025@@Carmen Ruiz@@Sala2
SOC002@@Spinning@@45@@26/01/2025@@Ana López@@Sala1
SOC005@@Natación@@40@@26/01/2025@@Miguel Torres@@Piscina1
SOC011@@Tenis@@80@@23/01/2025@@David García@@Pista1
SOC006@@Pilates@@55@@26/01/2025@@Laura Martín@@Sala3
SOC012@@Spinning@@45@@24/01/2025@@Ana López@@Sala1
SOC003@@Natación@@30@@27/01/2025@@Miguel Torres@@Piscina1
SOC009@@Yoga@@60@@26/01/2025@@Carmen Ruiz@@Sala2
SOC011@@Spinning@@45@@27/01/2025@@Ana López@@Sala1
SOC007@@Natación@@40@@28/01/2025@@Miguel Torres@@Piscina1
SOC010@@Tenis@@95@@27/01/2025@@David García@@Pista1
SOC012@@Pilates@@50@@28/01/2025@@Laura Martín@@Sala3
SOC001@@Spinning@@45@@29/01/2025@@Ana López@@Sala1
SOC008@@Natación@@35@@28/01/2025@@Miguel Torres@@Piscina1
SOC004@@Yoga@@60@@29/01/2025@@Carmen Ruiz@@Sala2
SOC005@@Spinning@@45@@30/01/2025@@Ana López@@Sala1
SOC011@@Pilates@@55@@30/01/2025@@Laura Martín@@Sala3
SOC006@@Natación@@40@@30/01/2025@@Miguel Torres@@Piscina1
REGISTROS;

    function procesarRegistrosActividades($cadenaEntrada) {
        $lineas = explode("\n", trim($cadenaEntrada));
        $socios = array();
        $actividadesGlobales = array();
        $instructoresGlobales = array();
        $minutosGlobales = 0;
        $sesionesGlobales = 0;

        // 1. Leer los registros y agruparlos por socio.
        for ($i = 0; $i < count($lineas); $i++) {
            $datos = explode('@@', trim($lineas[$i]));
            if (count($datos) != 6) {
                continue;
            }

            $id = $datos[0];
            $actividad = $datos[1];
            $minutos = (int) $datos[2];
            $fecha = date_create_from_format('!d/m/Y', $datos[3]);
            $instructor = $datos[4];
            if ($fecha === false) {
                continue;
            }

            if (!isset($socios[$id])) {
                $socios[$id] = array(
                    'minutos' => 0,
                    'sesiones' => 0,
                    'actividades' => array(),
                    'instructores' => array(),
                    'primera' => $fecha,
                    'ultima' => $fecha
                );
            }

            $socios[$id]['minutos'] += $minutos;
            $socios[$id]['sesiones']++;

            if (!isset($socios[$id]['actividades'][$actividad])) {
                $socios[$id]['actividades'][$actividad] = 0;
            }
            $socios[$id]['actividades'][$actividad]++;

            if (!isset($socios[$id]['instructores'][$instructor])) {
                $socios[$id]['instructores'][$instructor] = 0;
            }
            $socios[$id]['instructores'][$instructor]++;

            if ($fecha < $socios[$id]['primera']) {
                $socios[$id]['primera'] = $fecha;
            }
            if ($fecha > $socios[$id]['ultima']) {
                $socios[$id]['ultima'] = $fecha;
            }

            if (!isset($actividadesGlobales[$actividad])) {
                $actividadesGlobales[$actividad] = 0;
            }
            $actividadesGlobales[$actividad]++;

            if (!isset($instructoresGlobales[$instructor])) {
                $instructoresGlobales[$instructor] = 0;
            }
            $instructoresGlobales[$instructor]++;

            $minutosGlobales += $minutos;
            $sesionesGlobales++;
        }

        // 2. Mostrar los resultados de cada socio.
        echo '<table border="1" cellpadding="8">';
        echo '<tr><th>Socio</th><th>Minutos</th><th>Sesiones</th>';
        echo '<th>Actividad favorita</th><th>Periodo de actividad</th>';
        echo '<th>Dias activo</th><th>Instructor principal</th></tr>';

        $ids = array_keys($socios);
        $socioMasActivo = '';
        $maxMinutos = -1;

        for ($i = 0; $i < count($ids); $i++) {
            $id = $ids[$i];
            $socio = $socios[$id];

            if ($socio['minutos'] > $maxMinutos) {
                $maxMinutos = $socio['minutos'];
                $socioMasActivo = $id;
            }

            // Se incluyen todas las actividades empatadas en el maximo.
            $maxActividad = max($socio['actividades']);
            $favoritas = array();
            $claves = array_keys($socio['actividades']);
            for ($j = 0; $j < count($claves); $j++) {
                $nombre = $claves[$j];
                if ($socio['actividades'][$nombre] == $maxActividad) {
                    $favoritas[] = $nombre;
                }
            }

            // Se incluyen todos los instructores empatados.
            $maxInstructor = max($socio['instructores']);
            $principales = array();
            $claves = array_keys($socio['instructores']);
            for ($j = 0; $j < count($claves); $j++) {
                $nombre = $claves[$j];
                if ($socio['instructores'][$nombre] == $maxInstructor) {
                    $principales[] = $nombre;
                }
            }

            $diferencia = date_diff($socio['primera'], $socio['ultima']);
            $dias = date_interval_format($diferencia, '%a');
            $periodo = $socio['primera']->format('d/m/Y') . ' - ' .
                       $socio['ultima']->format('d/m/Y');

            echo '<tr>';
            echo '<td>' . htmlspecialchars($id) . '</td>';
            echo '<td>' . $socio['minutos'] . '</td>';
            echo '<td>' . $socio['sesiones'] . '</td>';
            echo '<td>' . htmlspecialchars(implode(', ', $favoritas)) . '</td>';
            echo '<td>' . $periodo . '</td>';
            echo '<td>' . $dias . '</td>';
            echo '<td>' . htmlspecialchars(implode(', ', $principales)) . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        // 3. Estadisticas globales. Se contemplan los empates.
        $maxActividad = max($actividadesGlobales);
        $populares = array();
        $claves = array_keys($actividadesGlobales);
        for ($i = 0; $i < count($claves); $i++) {
            $nombre = $claves[$i];
            if ($actividadesGlobales[$nombre] == $maxActividad) {
                $populares[] = $nombre;
            }
        }

        $maxInstructor = max($instructoresGlobales);
        $solicitados = array();
        $claves = array_keys($instructoresGlobales);
        for ($i = 0; $i < count($claves); $i++) {
            $nombre = $claves[$i];
            if ($instructoresGlobales[$nombre] == $maxInstructor) {
                $solicitados[] = $nombre;
            }
        }

        echo '<h2>Estadisticas globales</h2>';
        echo '<p>Socio mas activo: ' . $socioMasActivo . ' (' . $maxMinutos . ' minutos)</p>';
        echo '<p>Actividad mas popular: ' . htmlspecialchars(implode(', ', $populares)) .
             ' (' . $maxActividad . ' sesiones)</p>';
        echo '<p>Instructor mas solicitado: ' . htmlspecialchars(implode(', ', $solicitados)) .
             ' (' . $maxInstructor . ' sesiones)</p>';
        echo '<p>Promedio de minutos por sesion: ' .
             round($minutosGlobales / $sesionesGlobales, 2) . '</p>';
        echo '<p>Total de registros: ' . $sesionesGlobales . '</p>';
    }

    procesarRegistrosActividades($cadenaEntrada);
    ?>
</body>
</html>
