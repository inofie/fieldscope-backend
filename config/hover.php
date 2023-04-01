<?php
return [
  'routes' => [],
  'dropdown' => [
        'Roofing' => [

        ],
      'Front Elevation' => [

      ],
      'Right Elevation' => [

      ],
      'Back Elevation' => [

      ],
      'Left Elevation' => [

      ]
  ],
    'formulas' => [
        /**
         * Keywords documentation
         * field_path:  Key for a single value
         * field_paths: Key for a "multiple" single values
         * path:        Key for a non-single value (object / Array)
         * $field_type: gets use in logic via eval
         */
        'roofing' => [
            'area_by_pitch' => [
                'title' => 'Roof Pitch and Area',
                'field_path' => null,
                'path' => 'roof/pitch',
            ],
            'total_area_wo_waste' => [
                'title' => 'Total Roof Area w/out Waste (sq)',
                'field_path' => "summary/roof/waste_factor/area/zero",
                'path' => 'roof/pitch',
            ],
            'total_area_w_waste' => [
                'title' => 'Total Roof Area w/out Waste (sq)',
                'field_path' => "summary/roof/waste_factor/area/zero",
                'waste_factor' => "summary/roof/waste_factor/area",
            ]
        ],
        'elevation' => [
            'total_wall_area_wo_waste' =>[
                'title' => 'Front Total Wall Area w/out Waste (sq ft)',
                'field_path' => "elevations/sides/\$field_type/total",
            ],
            'total_wall_area_w_waste' =>[
                'title' => 'Front Total Wall Area w/out Waste (sq ft)',
                'ref_path' => "elevations/sides/\$field_type/area_per_label",
                'field_path' => null,
                'path' => 'facades/siding',
                'waste_factor' => 'area_with_waste_factor_calculation',
            ],
            'level_starter'=> [
                'title' => 'Level Starter (ft)',
                'ref_path' => "elevations/sides/\$field_type/area_per_label",
                'field_path' => null,
                'path' => 'facades/siding',
                'field_paths' => 'trim/level_starter',
            ],
            'sidings'=> [
                'title' => 'Level Starter (ft)',
                'ref_path' => "elevations/sides/\$field_type/area_per_label",
                'field_path' => null,
                'path' => 'facades/siding',
                'field_paths' => "\$sidingType",
            ],
            'facade' => [
                'title' => 'All Facades',
                'ref_path' => "elevations/sides/\$field_type/area_per_label",
                'field_path' => null, /**Key for a single value*/
                'path' => 'facades/siding',
                'field_paths' => [
                    'level_starter' => 'trim/level_starter',
                    'sloped' => 'trim/sloped',
                    'vertical' => 'trim/vertical',

                    'inside_length' => 'corners/inside_length',
                    'outside_length' => 'corners/outside_length',

                    'shutters' => 'shutters',
                    'vents' => 'vents',

                    'openings_top' => 'openings/tops',
                    'openings_sills' => 'openings/sills',
                    'openings_sides' => 'openings/sides',
                ],
            ],
        ],
        'right_elevation' => [

        ],
        'back_elevation' => [

        ],
        'left_elevation' => [

        ]

    ],
    'ref_paths' => []
];