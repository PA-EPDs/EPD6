<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $tabla = array(
            1 => array(
                'a' => array(
                    array('CCFWT-000500', 7),
                    array('CCFWT-005000', 5),
                    array('CCT-025000', 8)
                ),
                'b' => array(
                    array('COS-025000', 5)
                ),
                'c' => array(
                    array('COS-025000', 9),
                    array('CCT-025000', 1),
                    array('CCT-025000', 8)
                )
            ),
            2 => array(
                'a' => array(
                    array('CCT-025000', 8),
                    array('CCT-025000', 9)
                )
            )
        );

        function buscarProducto($sku, $tabla) {
            $localizaciones = array();
            $total = 0;

            foreach ($tabla as $pasillo => $estantes) {
                foreach ($estantes as $estante => $productos) {
                    $cantidad = 0;

                    foreach ($productos as $producto) {
                        if ($producto[0] == $sku) {
                            $cantidad += $producto[1];
                        }
                    }

                    if ($cantidad > 0) {
                        $localizaciones[] = array(
                            'pasillo' => $pasillo,
                            'estante' => $estante,
                            'cantidad' => $cantidad
                        );
                        $total += $cantidad;
                    }
                }
            }

            return array(
                'localizaciones' => $localizaciones,
                'total' => $total
            );
        }

        $sku = 'CCT-025000';
        $resultado = buscarProducto($sku, $tabla);

        foreach ($resultado['localizaciones'] as $localizacion) {
            echo 'Pasillo ' . $localizacion['pasillo'] .
            ' - Estante ' . $localizacion['estante'] .
            ' - ' . $localizacion['cantidad'] . ' unidades<br>';
        }

        echo 'Total: ' . $resultado['total'] . ' unidades de ' . $sku;
        ?>
    </body>
</html>
