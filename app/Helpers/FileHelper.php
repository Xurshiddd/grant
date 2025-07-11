<?php

if (!function_exists('file_icon')) {
    function file_icon(string $ext): array
    {
        return match (strtolower($ext)) {
            'pdf'               => ['fa-file-pdf',   'text-red-500'],
            'doc', 'docx'       => ['fa-file-word',  'text-blue-600'],
            'png', 'jpg', 'jpeg', 'webp'
                                => ['fa-file-image', 'text-yellow-500'],
            default             => ['fa-file',       'text-gray-400'],
        };
    }
}
