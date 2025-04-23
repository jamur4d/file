<?php
// Set unlimited execution time
set_time_limit(0);

// Increase memory limit
ini_set('memory_limit', '512M'); // Adjust as needed

// Continue executing even if the user disconnects
ignore_user_abort(true);

function scanDirectory($directory, &$results = []) {
    $files = scandir($directory);

    foreach ($files as $key => $value) {
        $path = realpath($directory . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            if (isPhpFile($path)) {
                $results[] = $path;
            }
        } else if ($value != "." && $value != "..") {
            scanDirectory($path, $results);
        }
    }

    return $results;
}

function isPhpFile($file) {
    $phpExtensions = ['php', 'php2', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'pht', 'phtm', 'phtml', 'pgif', 'shtml', 'htaccess', 'phar', 'inc', 'hphp', 'ctp', 'module'];
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return in_array(strtolower($extension), $phpExtensions);
}

function containsSensitiveFunctions($fileContent, $sensitiveFunctions) {
    $matches = [];
    foreach ($sensitiveFunctions as $function) {
        if (preg_match_all('/\b' . preg_quote($function, '/') . '\b/i', $fileContent)) {
            $matches[] = $function;
        }
    }
    return $matches;
}

function displayResults($filePath, $fileContent, $sensitiveFunctions) {
    $functionsFound = containsSensitiveFunctions($fileContent, $sensitiveFunctions);
    
    if (!empty($functionsFound)) {
        $line = 0;
        preg_match_all('/\b(' . implode('|', array_map('preg_quote', $sensitiveFunctions)) . ')\b/i', $fileContent, $matches, PREG_OFFSET_CAPTURE);
        
        foreach ($matches[0] as $match) {
            $line = substr_count(substr($fileContent, 0, $match[1]), "\n") + 1;
        }

        $functionsList = implode(',', $functionsFound);
        return "File: $filePath | Line: $line | Sensitive function: $functionsList";
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['directory'])) {
    $directory = $_POST['directory'];
    $sensitiveFunctions = ['exec', 'shell_exec', 'system', 'passthru', 'eval', 'popen', 'proc_open', 'file_put_contents', 'fwrite', 'fopen', 'file_get_contents', 'unlink', 'rename', 'copy', 'move_uploaded_file', 'scandir', 'opendir', 'readdir'];
    
    $phpFiles = scanDirectory($directory);
    $output = [];

    foreach ($phpFiles as $file) {
        $content = file_get_contents($file);
        $result = displayResults($file, $content, $sensitiveFunctions);

        if (!empty($result)) {
            $output[] = "<div class='result'>$result</div>";
        }
    }

    $output = implode('<br>', $output);
} else {
    $output = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Shell Scanner</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #181818;
            color: #8f8f8f;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
        }

        h1 {
            color: #00FF00;
            font-size: 36px;
            margin: 20px 0;
            animation: flicker 1s infinite;
        }

        @keyframes flicker {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }

        .container {
            background: #222;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 500px;
            overflow-y: auto;
            max-height: 70vh;
        }

        form {
            margin: 20px 0;
        }

        input[type="text"] {
            padding: 10px;
            width: 80%;
            max-width: 400px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #00FF00;
            color: black;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #00cc00;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .result {
            color: #ff9b00;
            background: #444;
            padding: 5px;
            border-radius: 4px;
            margin: 5px 0;
            font-size: 14px;
            white-space: pre-wrap; /* Allow multiline */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Shell Scanner</h1>
        <form method="POST">
            <label for="directory">Enter directory to scan:</label><br>
            <input type="text" name="directory" id="directory" required><br>
            <button type="submit">Scan</button>
        </form>
        <div class="results">
            <?php if (!empty($output)) { echo $output; } ?>
        </div>
    </div>
    <div class="footer">
        <p>Developed by BOYAS</p>
        <a href="https://t.me/boyas293" style="color: #00FF00;">t.me/boyas293</a><br>

    </div>
</body>
</html>
