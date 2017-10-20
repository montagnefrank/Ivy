<?php

$config["admin"]["main_tabs"] = array(
    "Administrador" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Proveedores', 'cont' => 'proveedor', 'icon' => 'fa-rocket'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'),
                array('nombre' => 'Pendientes', 'cont' => 'pendientes', 'icon' => 'fa-check-square-o'),
                array('nombre' => 'Usuarios', 'cont' => 'usuarios', 'icon' => 'fa-user'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'),
                array('nombre' => 'Comprar', 'cont' => 'compras', 'icon' => 'fa-shopping-cart'),
                array('nombre' => 'Ventas', 'cont' => 'ventas/factura_ventas', 'icon' => 'fa-file-text'),
                array('nombre' => 'Compras', 'cont' => 'ventas/factura_compras', 'icon' => 'fa-file-text-o'),
                array('nombre' => 'Cobrar', 'cont' => 'ventas/pendientes_cobro', 'icon' => 'fa-pencil-square-o'))
        ),
        "Contabilidad" => array('cont' => 'PADRE', 'icon' => 'fa-book',
            'hijos' => array(
                array('nombre' => 'Retenciones', 'cont' => 'ventas/retenciones', 'icon' => 'fa-gavel'),
                array('nombre' => 'Plan', 'cont' => 'planes', 'icon' => 'fa-list'))
        ),
        "Reportes" => array('cont' => 'PADRE', 'icon' => 'fa-hospital-o',
            'hijos' => array(
                array('nombre' => 'General', 'cont' => 'ventas/reporteGeneral', 'icon' => 'fa-pie-chart'),
                array('nombre' => 'Por Cliente', 'cont' => 'ventas/porCliente', 'icon' => 'fa-pie-chart')
            )
        ),
    ),
    "Sistemas" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'),
                array('nombre' => 'Pendientes', 'cont' => 'pendientes', 'icon' => 'fa-check-square-o'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'))
        )
    ),
    "Contador" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Proveedores', 'cont' => 'proveedor', 'icon' => 'fa-rocket'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'),
                array('nombre' => 'Comprar', 'cont' => 'compras', 'icon' => 'fa-shopping-cart'),
                array('nombre' => 'Ventas', 'cont' => 'ventas/factura_ventas', 'icon' => 'fa-file-text'),
                array('nombre' => 'Compras', 'cont' => 'ventas/factura_compras', 'icon' => 'fa-file-text-o'))
        ),
        "Contabilidad" => array('cont' => 'PADRE', 'icon' => 'fa-book',
            'hijos' => array(
                array('nombre' => 'Retenciones', 'cont' => 'ventas/retenciones', 'icon' => 'fa-gavel'),
                array('nombre' => 'Plan', 'cont' => 'planes', 'icon' => 'fa-list'))
        ),
        "Reportes" => array('cont' => 'PADRE', 'icon' => 'fa-hospital-o',
            'hijos' => array(
                array('nombre' => 'General', 'cont' => 'ventas/reporteGeneral', 'icon' => 'fa-pie-chart'),
                array('nombre' => 'Por Cliente', 'cont' => 'ventas/porCliente', 'icon' => 'fa-pie-chart')
            )
        ),
    ),
    "Vendedor" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'),
                array('nombre' => 'Pendientes', 'cont' => 'pendientes', 'icon' => 'fa-check-square-o'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'),
                array('nombre' => 'Ventas', 'cont' => 'ventas/factura_ventas', 'icon' => 'fa-file-text'))
        )
    ),
    "Administrador Grupo" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Proveedores', 'cont' => 'proveedor', 'icon' => 'fa-rocket'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'),
                array('nombre' => 'Pendientes', 'cont' => 'pendientes', 'icon' => 'fa-check-square-o'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'),
                array('nombre' => 'Comprar', 'cont' => 'compras', 'icon' => 'fa-shopping-cart'))
        ),
    ),
    "Jefe de Area" => array(
        "Empresa" => array('cont' => 'PADRE', 'icon' => 'fa-industry',
            'hijos' => array(
                array('nombre' => 'Clientes', 'cont' => 'clientes', 'icon' => 'fa-coffee'),
                array('nombre' => 'Proveedores', 'cont' => 'proveedor', 'icon' => 'fa-rocket'),
                array('nombre' => 'Productos', 'cont' => 'productos', 'icon' => 'fa-television'),
                array('nombre' => 'Pendientes', 'cont' => 'pendientes', 'icon' => 'fa-check-square-o'))
        ),
        "Administraci&oacute;n" => array('cont' => 'PADRE', 'icon' => 'fa-line-chart',
            'hijos' => array(
                array('nombre' => 'Vender', 'cont' => 'ventas', 'icon' => 'fa-credit-card'),
                array('nombre' => 'Comprar', 'cont' => 'compras', 'icon' => 'fa-shopping-cart'))
        ),
    )
);
?>