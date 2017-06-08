<?php
    require_once(dirname(__FILE__) . "/../constants.php");
    require_once(dirname(__FILE__) . "/../file_sources/PathOperations.php");
    require_once(dirname(__FILE__) . '/../licensing/KeyPairSuite.php');
    require_once(dirname(__FILE__) . '/../licensing/LicenseReader.php');
    require_once(dirname(__FILE__) . '/../licensing/LicenseFactory.php');

    if(!MONSTA_DEBUG)
        includeMonstaConfig();

    function monstaGetTempDirectory() {
        // a more robust way of getting the temp directory

        $configTempDir = defined("MONSTA_TEMP_DIRECTORY") ? MONSTA_TEMP_DIRECTORY : "";

        if($configTempDir != "")
            return $configTempDir;

        return ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }

    function languageCmp($a, $b) {
        strcmp($a[1], $b[1]);
    }

    function readLanguagesFromDirectory($languageDir) {
        $languageFiles = scandir($languageDir);

        $languages = array();

        foreach ($languageFiles as $languageFile) {
            if(strlen($languageFile) < 6)
                continue;

            $splitFileName = explode(".", $languageFile);

            if(count($splitFileName) != 2)
                continue;

            if($splitFileName[1] != "json")
                continue;

            $fullFilePath = PathOperations::join($languageDir, $languageFile);

            $languageContentsRaw = file_get_contents($fullFilePath);
            if($languageContentsRaw === false)
                continue;

            $languageContents = json_decode($languageContentsRaw, true);

            if($languageContents === false)
                continue;

            if(!isset($languageContents['Language Display Name']))
                continue;

            $languages[] = array($splitFileName[0], $languageContents['Language Display Name']);
        }

        usort($languages, "languageCmp");

        return $languages;
    }

    function getTempUploadPath($remotePath) {
        $fileName = basename($remotePath);

        return tempnam(monstaGetTempDirectory(), $fileName);
    }

    function readUpload($uploadPath) {
        $inputHandler = fopen('php://input', "r");
        $fileHandler = fopen($uploadPath, "w+");

        while (FALSE !== ($buffer = fgets($inputHandler, 65536)))
            fwrite($fileHandler, $buffer);

        fclose($inputHandler);
        fclose($fileHandler);
    }

    function readDefaultMonstaLicense() {
        $keyPairSuite = new KeyPairSuite(PUBKEY_PATH);
        $licenseReader = new LicenseReader($keyPairSuite);
        $licenseArr = $licenseReader->readLicense(MONSTA_LICENSE_PATH);

        return LicenseFactory::getMonstaLicenseFromArray($licenseArr);
    }

    function b64DecodeUnicode($rawData) {
        if($rawData == "")
            return "";

        $decodedData = base64_decode($rawData);

        $urlEncodedData = "";

        foreach (str_split($decodedData) as $char)
            $urlEncodedData .= sprintf("%%%02x", ord($char));

        return urldecode($urlEncodedData);
    }

    function b64EncodeUnicode($rawData) {
        $urlEncodedData = rawurlencode($rawData);

        $ordinalizedData = preg_replace_callback("/%([0-9A-F]{2})/",
            function($matches){
                $intVal = intval($matches[1], 16);
                return chr($intVal);
            }, $urlEncodedData);

        return base64_encode($ordinalizedData);
    }

    function succeededFailedText($successFailure) {
        return $successFailure ? "succeeded" : "failed";
    }

    function getNormalizedOSName() {
        if (strtoupper(substr(PHP_OS, 0, 5)) == 'LINUX')
            return "Linux";
        elseif (strtoupper(substr(PHP_OS, 0, 7)) == 'FREEBSD')
            return "FreeBSD";
        elseif (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
            return "Windows";
        else
            return PHP_OS;
    }

    function booleanToJsValue($boolVal) {
        return $boolVal ? "true": "false";
    }

    function ftpConnectionAvailable() {
        return function_exists("socket_create") || function_exists("ftp_connect");
    }

    function remoteDirname($path) {
        // on windows machines dirname will be \ for root files, we want it to be / for remote paths
        $dirname = dirname($path);
        return ($dirname == "\\") ? "/" : $dirname;
    }