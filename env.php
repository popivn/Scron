<?php
// env.php
function loadEnv($path)
{
    if (!file_exists($path)) {
        throw new Exception(".env file not found at: " . $path);
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Bỏ qua comment
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Tách key=value
        list($name, $value) = explode("=", $line, 2);

        $name = trim($name);
        $value = trim($value);

        // Nếu có dấu nháy thì bỏ đi
        $value = trim($value, "'\"");

        // Lưu vào $_ENV và $_SERVER
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
        }
        if (!array_key_exists($name, $_SERVER)) {
            $_SERVER[$name] = $value;
        }
        putenv("$name=$value"); // Cho phép dùng getenv()
    }
}
