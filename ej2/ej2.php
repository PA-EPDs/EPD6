<?php
declare(strict_types=1);

const LONGITUD_MIN = 6;
const LONGITUD_MAX = 10;
const LONGITUD_PREFIJO = 3;

function generarCodigoActividad(string $nombre, int $longitud): string
{
    static $codigosGenerados = [];

    if ($longitud < LONGITUD_MIN || $longitud > LONGITUD_MAX) {
        throw new InvalidArgumentException(
            'La longitud debe estar entre ' . LONGITUD_MIN . ' y ' . LONGITUD_MAX . '.'
        );
    }

    // Limpieza del nombre y prefijo en mayúsculas.
    $nombreLimpio = preg_replace('/[^A-Za-z0-9]/', '', $nombre);
    if ($nombreLimpio === '') {
        throw new InvalidArgumentException('El nombre no contiene caracteres válidos.');
    }
    $prefijo = strtoupper(substr($nombreLimpio, 0, LONGITUD_PREFIJO));

    $longitudSufijo = $longitud - strlen($prefijo);

    do {
        // uniqid() devuelve la hora actual en hexadecimal; sus últimos caracteres
        // son los que cambian entre llamadas, por eso se toman del final.
        $sufijo = strtoupper(substr(uniqid(), -$longitudSufijo));
        $codigo = $prefijo . $sufijo;
    } while (isset($codigosGenerados[$codigo]));

    $codigosGenerados[$codigo] = true;

    return $codigo;
}

$pruebas = [
    ['yoga', 8],
    ['spinning', 10],
    ['natacion', 6],
    ['.Running', 9],
    ['yoga', 8], // mismo nombre y longitud: el código debe ser distinto
    ['Pilates', 5], // longitud inválida
    ['¡¡¡', 8],     // nombre sin caracteres válidos
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EPD 6 - Ej2: Códigos de actividad</title>
</head>
<body>
    <h1>Generador de códigos de actividad</h1>
    <table border="1" cellpadding="4">
        <tr>
            <th>Actividad</th>
            <th>Longitud</th>
            <th>Resultado</th>
        </tr>
        <?php foreach ($pruebas as [$actividad, $longitud]): ?>
            <tr>
                <td><?= htmlspecialchars($actividad) ?></td>
                <td><?= $longitud ?></td>
                <td>
                    <?php
                    try {
                        echo generarCodigoActividad($actividad, $longitud);
                    } catch (InvalidArgumentException $e) {
                        echo 'Error: ' . htmlspecialchars($e->getMessage());
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>