
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignacion de turnos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Asignacion de turnos de trabajo</h1>

    <?php
    $empleados = array(
        'Ana Lopez' => 'Entrenadora Personal',
        'Miguel Torres' => 'Socorrista',
        'Carmen Ruiz' => 'Recepcionista',
        'David Garcia' => 'Monitor de Piscina',
        'Laura Martin' => 'Instructora de Spinning',
        'Javier Moreno' => 'Mantenimiento'
    );

    $turnos = array(
        'Mañana' => '07:00-15:00',
        'Tarde' => '15:00-23:00',
        'Noche' => '23:00-07:00'
    );

    function asignarTurnos($empleados, $turnos, $cantidad) {
        $nombres = array_keys($empleados);
        $nombresTurnos = array_keys($turnos);

        shuffle($nombres);
        shuffle($nombresTurnos);

        $asignaciones = array();

        foreach ($turnos as $turno => $horario) {
            $asignaciones[$turno] = array();
        }

        for ($i = 0; $i < $cantidad; $i++) {
            if ($i < count($nombresTurnos)) {
                $turno = $nombresTurnos[$i];
            } else {
                $posicion = rand(0, count($nombresTurnos) - 1);
                $turno = $nombresTurnos[$posicion];
            }

            $nombre = $nombres[$i];
            $asignaciones[$turno][] = $nombre;
        }

        return $asignaciones;
    }

    $cantidad = rand(3, count($empleados));

    $asignaciones = asignarTurnos(
        $empleados,
        $turnos,
        $cantidad
    );

    echo "<p>Empleados seleccionados: " . $cantidad . "</p>";

    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Turno</th>";
    echo "<th>Horario</th>";
    echo "<th>Empleado</th>";
    echo "<th>Especialidad</th>";
    echo "</tr>";
    echo "</thead>";

    echo "<tbody>";

    foreach ($asignaciones as $turno => $listaEmpleados) {
        foreach ($listaEmpleados as $nombre) {
            echo "<tr>";
            echo "<td>" . $turno . "</td>";
            echo "<td>" . $turnos[$turno] . "</td>";
            echo "<td>" . $nombre . "</td>";
            echo "<td>" . $empleados[$nombre] . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
    ?>
</body>
</html>
