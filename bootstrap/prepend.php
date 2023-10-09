<?php
/**
 * Script for loading environment variables from .env file Secrets
 */
// Путь к файлу с переменными окружения, если он задан в переменной SECRET_ENV в docker-compose.yml то используем его
$envFilePath = getenv('SECRET_ENV');
if (!empty($envFilePath)) {
    if (file_exists($envFilePath) && $envFile = file_get_contents($envFilePath)) {
        $envLines = array_filter(explode("\n", $envFile));
        foreach ($envLines as $line) {
            // Игнорирование пустых строк и комментариев
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            $parts = explode('=', $line, 2);
            putenv(trim($parts[0]) . '=' . trim($parts[1], " \t\n\r\0\x0B\"'"));
        }
    }
}
