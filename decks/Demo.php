<?php

return [
  [
    'id' => '1',
    'nm' => 'Маназмей',
    'cs' => 1,
    'at' => 1,
    'hp' => 3,
    'cl' => 'mage',
    'rr' => 'common',
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '2',
    'nm' => 'Зеркальные копии',
    'cs' => 1,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '3',
    'nm' => 'Чародейские стрелы',
    'cs' => 1,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '4',
    'nm' => 'Интеллект чародея',
    'cs' => 3,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '5',
    'nm' => 'Огненный шар',
    'cs' => 4,
    'cl' => 'mage',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '6',
    'nm' => 'Чародейский выстрел',
    'cs' => 1,
    'cl' => 'hunter',
    'rr' => 'basic',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '7',
    'nm' => 'Тенетник',
    'cs' => 1,
    'at' => 1,
    'hp' => 1,
    'cl' => 'hunter',
    'rr' => 'basic',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){
      return 'tenetnick win!!!';
    }
  ],
  [
    'id' => '8',
    'nm' => 'Взрывная ловушка',
    'cs' => 2,
    'cl' => 'hunter',
    'rr' => 'common',
    'rs' => ['secret'],
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '9',
    'nm' => 'Гиена-падальщица',
    'cs' => 2,
    'at' => 2,
    'hp' => 2,
    'cl' => 'hunter',
    'rr' => 'common',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '10',
    'nm' => 'Смертельный выстрел',
    'cs' => 3,
    'cl' => 'hunter',
    'rr' => 'common',
    'im' => false,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '11',
    'nm' => 'Яйцо дракона',
    'cs' => 1,
    'at' => 0,
    'hp' => 2,
    'rr' => 'rare',
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '12',
    'nm' => 'Мурлок-налетчик',
    'cs' => 1,
    'at' => 2,
    'hp' => 1,
    'rr' => 'basic',
    'rs' => ['murloc'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '13',
    'nm' => 'Солдат Златоземья',
    'cs' => 1,
    'at' => 1,
    'hp' => 2,
    'rr' => 'basic',
    'ef' => ['taunt'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '14',
    'nm' => 'Раздражатор',
    'cs' => 2,
    'at' => 1,
    'hp' => 2,
    'rr' => 'common',
    'ef' => ['taunt', 'shield'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '15',
    'nm' => 'Воин Синежабрых',
    'cs' => 2,
    'at' => 2,
    'hp' => 1,
    'rr' => 'basic',
    'rs' => ['murloc'],
    'ef' => ['charge'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '16',
    'nm' => 'Боец Северного Волка',
    'cs' => 2,
    'at' => 2,
    'hp' => 2,
    'rr' => 'basic',
    'ef' => ['taunt'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '17',
    'nm' => 'Железноклюв',
    'cs' => 2,
    'at' => 2,
    'hp' => 1,
    'rr' => 'common',
    'rs' => ['beast'],
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '18',
    'nm' => 'Маг Даларана',
    'cs' => 3,
    'at' => 1,
    'hp' => 4,
    'rr' => 'basic',
    'im' => true,
    'ih' => false,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '19',
    'nm' => 'Черный дракончик',
    'cs' => 1,
    'at' => 2,
    'hp' => 1,
    'rr' => 'common',
    'rs' => ['dragon'],
    'im' => true,
    'ih' => true,
    'cb' => function($game){ return 'cb!!!'; }
  ],
  [
    'id' => '20',
    'nm' => 'Зеркальная копия',
    'cs' => 0,
    'at' => 0,
    'hp' => 2,
    'rr' => 'common',
    'rs' => ['taunt'],
    'im' => true,
    'ih' => true,
    'cb' => function($game){ return 'cb!!!'; }
  ],
];
