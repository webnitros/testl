<?php

return [
    'temporary_file_upload' => [
        'rules' => 'file|mimes:png,jpg,pdf,zip,csv,xml|max:112000', // (100MB max, and only pngs, jpegs, and pdfs.)
    ]
];
