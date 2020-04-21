<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
    'tempDir'               => base_path('../temp/'),

	'font_path' => base_path('public/fonts/'),
	'font_data' => [
		'tahoma' => [
			'R'  => 'TahomaRegular.ttf',    // regular font
			// 'B'  => 'Cairo-Bold.ttf',       // optional: bold font
			// 'I'  => 'ExampleFont-Italic.ttf',     // optional: italic font
			// 'BI' => 'ExampleFont-Bold-Italic.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
			'useKashida' => 75,
		]
		// ...add as many as you want.
	]
];
