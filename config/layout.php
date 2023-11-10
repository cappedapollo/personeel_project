<?php
return [
    // Base Layout
    'js' => [
        'breakpoints' => [
            'sm' => 576,
            'md' => 768,
            'lg' => 992,
            'xl' => 1200,
            'xxl' => 1200
        ],
        'colors' => [
            'theme' => [
                'base' => [
                    'white' => '#ffffff',
                    'primary' => '#6993FF',
                    'secondary' => '#E5EAEE',
                    'success' => '#1BC5BD',
                    'info' => '#8950FC',
                    'warning' => '#FFA800',
                    'danger' => '#F64E60',
                    'light' => '#F3F6F9',
                    'dark' => '#212121'
                ],
                'light' => [
                    'white' => '#ffffff',
                    'primary' => '#E1E9FF',
                    'secondary' => '#ECF0F3',
                    'success' => '#C9F7F5',
                    'info' => '#EEE5FF',
                    'warning' => '#FFF4DE',
                    'danger' => '#FFE2E5',
                    'light' => '#F3F6F9',
                    'dark' => '#D6D6E0'
                ],
                'inverse' => [
                    'white' => '#ffffff',
                    'primary' => '#ffffff',
                    'secondary' => '#212121',
                    'success' => '#ffffff',
                    'info' => '#ffffff',
                    'warning' => '#ffffff',
                    'danger' => '#ffffff',
                    'light' => '#464E5F',
                    'dark' => '#ffffff'
                ]
            ],
            'gray' => [
                'gray-100' => '#F3F6F9',
                'gray-200' => '#ECF0F3',
                'gray-300' => '#E5EAEE',
                'gray-400' => '#D6D6E0',
                'gray-500' => '#B5B5C3',
                'gray-600' => '#80808F',
                'gray-700' => '#464E5F',
                'gray-800' => '#1B283F',
                'gray-900' => '#212121'
            ]
        ],
        'font-family' => 'Poppins'
    ],

    // Assets
    'resources' => [
        'favicon' => 'media/logos/favicon.ico',
        'logo' => 'media/logos/logo.png',
        'authorization_img' => 'media/error/bg5.jpg',
        'logo_email' => 'media/logos/logo-email.jpg',
        'logo_pdf' => 'media/logos/logo-email.jpg',
        'login_side_logo' => 'media/login-side.jpg',
        'no_user' => 'media/users/blank.jpg',
        'lang-flag-en' => 'media/flags/226-united-states.svg',
        'lang-flag-du' => 'media/flags/netherlands.png',
        'pdf_bkgd' => 'media/bg/pdf-background.jpg',
        'pdf_bkgd_center_en' => 'media/bg/pdf-background-center-en.jpg',
        'pdf_bkgd_center_du' => 'media/bg/pdf-background-center-du.jpg',
        'checkmark' => 'media/icons/checkmark.png',
        '2fa_logo' => 'media/logos/2fa-logo.png',
        'popup_icon' => 'media/logos/popup.png',
        'fonts' => [
            'google' => [
                'families' => [
                    'Poppins:300,400,500,600,700'
                ]
            ]
        ],
        'css' => [
            'plugins/global/plugins.bundle.css',
            'css/style.bundle.css?v=2.0',
            'css/themes/layout/header/base/light.css?v=1.2',
            'css/themes/layout/header/menu/light.css?v=1.2',
            'css/themes/layout/brand/light.css?v=1.2',
            'css/themes/layout/aside/light.css?v=1.3',
            'css/custom.css?v='.time(),
        ],
        'js' => [
            'plugins/global/plugins.bundle.js',
            'js/scripts.bundle.js',
        ],
        'index_css' => [
            'plugins/custom/datatables/datatables.bundle.css',
        ],
        'index_js' => [
            'plugins/custom/datatables/datatables.bundle.js',
            'js/custom-table.js?v='.time(),
            'js/delete-alert.js',
        ],
        'validation_js' => 'js/form-validate.js?v='.time(),
        'custom_js' => 'js/custom.js?v='.time(),
        'login_css' => 'css/pages/login/login-1.css?v='.time(),
        'login_js' => 'js/login-general.js',
        'reset_js' => 'js/reset-password.js',
    ],

];