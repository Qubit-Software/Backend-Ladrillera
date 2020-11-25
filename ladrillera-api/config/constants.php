<?php
return [
    'default' => [
        'from_email' => 'ladrillera21@gmail.com',
        'estatus' => 'Pendiente Pago',
    ],
    'estatus' => [
        0 => "No existe",
        1 => "Despacho finalizado",
        2 => "Despacho sin iniciar",
        3 => "Despacho en proceso",
        4 => "Pendiente Pago",
        5 => "Pedido finalizado"
    ],
    'productos' => [
        "LAD21-MATCO" => [
            "codigo" => "LAD21-MATCO",
            "nombre" => "Bloquelon MATCO",
            "medida" => "Unidad"
        ],
        "LAD21-MALLA" => [
            "codigo" => "LAD21-MALLA",
            "nombre" => "Malla Electrosoldada",
            "medida" => [
                "Rollo/s",
                "Panel/es"
            ]
        ],
        "LAD21-PERFIL" => [
            "codigo" => "LAD21-PERFIL",
            "nombre" => "Perfil Entrepiso",
            "medida" => "Metro/s"
        ],
    ]
];
