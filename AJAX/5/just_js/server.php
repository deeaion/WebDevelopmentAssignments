<?php

function getDirectoryContents($dir, $baseDir) {
    $result = [];
    $files = array_diff(scandir($dir), array('.', '..'));

    foreach ($files as $file) {
        $filePath = $dir . '/' . $file;
        $relativePath = str_replace($baseDir, '', $filePath);
        $relativePath = ltrim($relativePath, '/');
        $result[] = [
            'name' => $file,
            'path' => $relativePath,
            'type' => is_dir($filePath) ? 'directory' : 'file'
        ];
    }

    return $result;
}

if (isset($_GET['path'])) {
    $baseDir = realpath(__DIR__);
    $path = realpath($baseDir . '/' . $_GET['path']);

    if ($path && strpos($path, $baseDir) === 0) { // Ensure the path is within the base directory
        if (is_dir($path)) {
            $result = getDirectoryContents($path, $baseDir);
            header('Content-Type: application/json');
            echo json_encode($result);
        } elseif (is_file($path)) {
            header('Content-Type: text/plain');
            echo file_get_contents($path);
        } else {
            http_response_code(404);
            echo "Path not found";
        }
    } else {
        http_response_code(400);
        echo "Invalid path";
    }
} else {
    http_response_code(400);
    echo "Path not specified";
}

?>
