# yii2-auth-wac
Yii2 CompositAuth with AccessControl integration.

By default, AuthMethod checks only the internal "optional" property to test whether it is possible to get into this
action without authorization. You should duplicate the access rules in AuthMethod and AccessControl. WacAuth allows
you to automatically check the guest access rules in AccessControl when AuthMethod is authorized.

## Installation

Either run

`composer require --prefer-dist matrozov/yii2-wac-auth`

## Usage example

### Before:
```php
$behaviors['authenticator'] = [
    'class' => HttpBearerAuth::className(),
    'optional' => ['index']
];

$behaviors['access'] = [
    'class' => AccessControl::className(),
    'only' => ['index'],
    'rules' => [
        [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['?'],
        ],
    ],
];
```

You specify the "optional" property and roles="?" at the same time for your action "index".

### After:
```php
$behaviors['authenticator'] = [
    'class' => WacAuth::className(),
    'authMethods' => [
        HttpBearerAuth::className()
    ]
];

$behaviors['access'] = [
    'class' => AccessControl::className(),
    'only' => ['index'],
    'rules' => [
        [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['?'],
        ],
    ],
];
```

You wrap HttpBearerAuth in WacAuth and now it automatically takes into account roles="?" in AccessControl.