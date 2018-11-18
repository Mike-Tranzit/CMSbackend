<?php
require_once __DIR__ . '/../../common/models/auth/Users.php';

return [
   // 'identityClass' => 'cms\modules\v1\models\auth\Users',
    'identityClass' => 'common\models\auth\Users',
    'enableAutoLogin' => false,
    'enableSession' => false,
];