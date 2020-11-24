<?php
return [
    'default' => [
        'from_email' => 'ladrillera21@gmail.com',
        'option_attachment' => '13',
        'option_email' => '14',
        'option_monetery' => '15',
        'option_ratings' => '16',
        'option_textarea' => '17',
    ],
    'status' => [
        0 => "No existe",
        1 => "Despacho finalizado",
        2 => "Despacho sin iniciar",
        3 => "Despacho en proceso",
        4 => "Pendiente Pago"
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
