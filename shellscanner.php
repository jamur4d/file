<?php
session_start();

function scanDirectory($dir)
{
    $suspicious_patterns = [
        '/eval\s*\(/i',
        '/base64_decode\s*\(/i',
        '/gzinflate\s*\(/i',
        '/str_rot13\s*\(/i',
        '/shell_exec\s*\(/i',
        '/system\s*\(/i',
        '/passthru\s*\(/i',
        '/exec\s*\(/i',
        '/popen\s*\(/i',
        '/proc_open\s*\(/i',
        '/assert\s*\(/i'
    ];

    $results = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

    foreach ($iterator as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['php', 'phtml'])) {
            $lines = file($file->getPathname());
            $contents = implode("", $lines);

            foreach ($suspicious_patterns as $pattern) {
                if (preg_match($pattern, $contents, $match, PREG_OFFSET_CAPTURE)) {
                    $match_offset = $match[0][1];
                    $match_line = substr_count(substr($contents, 0, $match_offset), "\n");

                    $start = max(0, $match_line - 5);
                    $end = min(count($lines) - 1, $match_line + 5);
                    $snippet = implode("", array_slice($lines, $start, $end - $start + 1));

                    $results[] = [
                        'file' => $file->getPathname(),
                        'pattern' => $pattern,
                        'line' => $match_line + 1,
                        'snippet' => $snippet
                    ];
                    break;
                }
            }
        }
    }

    return $results;
}

$scan_results = [];
$directory = '';
$deleted = false;

if (isset($_SESSION['scan_results'])) {
    $scan_results = $_SESSION['scan_results'];
    $directory = $_SESSION['directory'];
}

if (isset($_GET['delete']) && file_exists($_GET['delete'])) {
    unlink($_GET['delete']);
    $deleted = basename($_GET['delete']);
    // Do NOT rescan
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['directory'])) {
    $directory = $_POST['directory'];
    if (is_dir($directory)) {
        $scan_results = scanDirectory($directory);
        $_SESSION['scan_results'] = $scan_results;
        $_SESSION['directory'] = $directory;
    } else {
        $scan_results = 'invalid';
        unset($_SESSION['scan_results']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Shell Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            transition: background 0.3s, color 0.3s;
        }
        body.dark-mode {
            background: #121212;
            color: #e0e0e0;
        }
        h1 { text-align: center; }
        form { text-align: center; margin-bottom: 20px; }
        input[type="text"] {
            width: 80%;
            max-width: 500px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 5px;
            cursor: pointer;
        }
        button:hover { background: #218838; }
        .btn-delete { background: #dc3545; }
        .btn-delete:hover { background: #c82333; }
        .btn-download { background: #007bff; }
        .btn-download:hover { background: #0069d9; }
        .result-block {
            border: 1px solid #ccc;
            background: #fff;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        body.dark-mode .result-block {
            background: #1e1e1e;
            border-color: #333;
        }
        pre {
            background: #222;
            color: #0f0;
            padding: 10px;
            overflow-x: auto;
            border-radius: 5px;
            font-size: 13px;
        }
        code {
            background: #eee;
            padding: 2px 5px;
            border-radius: 3px;
        }
        body.dark-mode code {
            background: #333;
            color: #0ff;
        }
        .theme-toggle {
            text-align: center;
            margin: 10px 0;
        }
        .theme-toggle input[type="checkbox"] {
            margin-right: 5px;
            transform: scale(1.2);
        }
    </style>
    <script>
        function confirmDelete(file) {
            if (confirm('Are you sure you want to delete this file?\n' + file)) {
                window.location.href = '?delete=' + encodeURIComponent(file);
            }
        }

        window.onload = function () {
            const checkbox = document.getElementById("darkToggle");
            const isDark = localStorage.getItem("dark-mode") === "true";
            document.body.classList.toggle("dark-mode", isDark);
            checkbox.checked = isDark;

            checkbox.addEventListener("change", function () {
                document.body.classList.toggle("dark-mode", this.checked);
                localStorage.setItem("dark-mode", this.checked);
            });
        };
    </script>
</head>
<body>
    <h1>🛡️ PHP Shell Scanner</h1>

    <div class="theme-toggle">
        <label>
            <input type="checkbox" id="darkToggle"> 🌗 Dark Mode
        </label>
    </div>

    <form method="post">
        <input type="text" name="directory" placeholder="Enter directory to scan (e.g. /var/www/html)" value="<?= htmlspecialchars($directory) ?>" required>
        <button type="submit">Scan Now</button>
    </form>

    <?php if ($deleted): ?>
        <p style="text-align:center; color:green;">✅ File <strong><?= htmlspecialchars($deleted) ?></strong> has been deleted.</p>
    <?php endif; ?>

    <?php if ($scan_results === 'invalid'): ?>
        <p style="color:red; text-align:center;">❌ Invalid directory. Please check the path.</p>
    <?php elseif (!empty($scan_results)): ?>
        <?php foreach ($scan_results as $i => $result): ?>
            <div class="result-block">
                <strong>#<?= $i + 1 ?></strong><br>
                <strong>File:</strong> <?= htmlspecialchars($result['file']) ?><br>
                <strong>Pattern:</strong> <code><?= htmlspecialchars($result['pattern']) ?></code><br>
                <strong>Line:</strong> <?= $result['line'] ?><br>
                <div style="margin: 10px 0;">
                    <button class="btn-delete" onclick="confirmDelete('<?= htmlspecialchars($result['file']) ?>')">Delete</button>
                    <a href="<?= htmlspecialchars($result['file']) ?>" download>
                        <button type="button" class="btn-download">Download</button>
                    </a>
                </div>
                <pre><?= htmlspecialchars($result['snippet']) ?></pre>
            </div>
        <?php endforeach; ?>

        <form method="post" action="data:text/csv;charset=utf-8,<?= urlencode("File,Pattern,Line\n" . implode("\n", array_map(fn($r) => "{$r['file']},\"{$r['pattern']}\",{$r['line']}", $scan_results))) ?>" style="text-align:center; margin-top:20px;">
            <button type="submit" download="scan-results.csv">⬇️ Download CSV</button>
        </form>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p style="text-align:center;">✅ No suspicious code found in <strong><?= htmlspecialchars($directory) ?></strong>.</p>
    <?php endif; ?>
</body>
</html>
