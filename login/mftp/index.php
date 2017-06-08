<?php
    $pageLevel = 2;
    include_once('../load.php');

    require_once(dirname(__FILE__) . "/application/api/constants.php");
    includeMonstaConfig();
    require_once(dirname(__FILE__) . '/application/api/lib/helpers.php');
    require_once(dirname(__FILE__) . '/application/api/lib/entry_handlers.php');
    if(file_exists(dirname(__FILE__) . '/mftp_extensions.php'))
        include_once(dirname(__FILE__) . '/mftp_extensions.php');

    require_once(dirname(__FILE__) . '/application/api/system/ApplicationSettings.php');

    $applicationSettings = new ApplicationSettings(APPLICATION_SETTINGS_PATH);

    $serverName = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '');
    $requestURI = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $https = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? "s" : "";

    $pageURL = "http" . $https . "://" . $serverName . $requestURI;

    $debugArg = MONSTA_DEBUG ? "&amp;d=1" : "";

    $languageDir = dirname(__FILE__) . "/application/languages/";

    $languages = readLanguagesFromDirectory($languageDir);

    $license = readDefaultMonstaLicense();
    $isLicensed = !is_null($license) && $license->isLicensed();
    $isEnterpriseEdition = $isLicensed && $license->getLicenseVersion() >= 3 && $license->isMonstaEnterpriseEdition();
    $isPostEntry = $isEnterpriseEdition && isMonstaPostEntry($_SERVER['REQUEST_METHOD'], $_POST);

    $mftpEdition = $isLicensed ? ($isEnterpriseEdition ? 'e' : 'p') : 's';

    $versionQS = "v=" . MONSTA_VERSION . "&amp;r=" . urlencode($pageURL) . "&amp;os=" . getNormalizedOSName() . "&amp;e=" . $mftpEdition . $debugArg;

    if ($isEnterpriseEdition) {
        if (function_exists("mftpInitialLoadValidation")) {
            if (!mftpInitialLoadValidation($isPostEntry))
                exit();
        }
    }
?>
<!DOCTYPE html>
<html ng-app="MonstaFTP">
<head>
    <title>Monsta FTP</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="shortcut icon" type="image/x-icon" href="application/frontend/images/monsta-logo-favicon.png">
    <link rel="apple-touch-icon" href="application/frontend/images/monsta-logo-webclip.png">

    <script>
        var g_defaultLanguage = "<?php print $applicationSettings->getLanguage(); ?>";
        var g_upgradeURL = "http://www.monstaftp.com/upgrade";
        var g_loadComplete = false;
        var g_xhrTimeoutSeconds = <?php print $applicationSettings->getXhrTimeoutSeconds(); ?>;
        var g_isMonstaPostEntry = false;
        var g_pharDataAvailable = <?php print booleanToJsValue(class_exists('PharData')); ?>;
        var g_isNewWindowsInstall = <?php print booleanToJsValue(getNormalizedOSName() == "Windows" && !$isLicensed); ?>;
        var g_ftpConnectionAvailable = <?php print booleanToJsValue(ftpConnectionAvailable()); ?>;
        var g_openSslAvailable = <?php print booleanToJsValue(function_exists("openssl_get_publickey")); ?>;

        <?php
        if ($isLicensed && $isPostEntry) {
        ?>
        g_isMonstaPostEntry = true;
        var g_monstaPostEntryVars = <?php print json_encode(extractMonstaPostEntryVars($_POST)); ?>;
        <?php
        }
        ?>
    </script>

    <!-- jQuery -->
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Angular -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>

    <!-- Open Sans Font -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
    
    <!-- Slider Bar -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/slidebars/2.0.2/slidebars.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/slidebars/2.0.2/slidebars.min.js"></script>

    <!-- Code Mirror -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/codemirror.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/codemirror.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/addon/display/autorefresh.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.17.0/addon/mode/multiplex.min.js"></script>

    <!-- Angular Translate -->
    <script src="application/frontend/js/messageformat.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-translate/2.15.1/angular-translate.min.js"></script>
    <script
        src="//cdnjs.cloudflare.com/ajax/libs/angular-translate/2.15.1/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
    <script
        src="//cdnjs.cloudflare.com/ajax/libs/angular-translate/2.15.1/angular-translate-interpolation-messageformat/angular-translate-interpolation-messageformat.min.js"></script>

    <!-- Monsta -->
    <link rel="stylesheet" href="application/frontend/css/monsta.css">
    <link rel="stylesheet" href="application/frontend/css/theme.css">

    <script src="application/frontend/js/monsta-pre-min-<?php print MONSTA_VERSION; ?>.js"></script>

    <script>
        var versionQS = <?php print json_encode($versionQS); ?> + getFpQs();
        document.write('<scri' + 'pt src="//monstacdn.com/version/mftp-latest-version.php?' + versionQS +'"></scr' + 'ipt>')
    </script>

    <script src="application/frontend/js/monsta-min-<?php print MONSTA_VERSION; ?>.js"></script>
    <?php
        if ($applicationSettings->isSettingsReadFailed()) {
            ?>
            <script>
                var g_settingsReadFailureMesage = "Reading settings.json failed. Check the file is readable and " +
                    "has no syntax errors (http://jsonlint.com might help). You are using the default settings.";

                alert(g_settingsReadFailureMesage);
            </script>
            <?php
        }
    ?>
    <script>
        var g_languageFiles = <?php print json_encode($languages); ?>;
    </script>
</head>
<body>
<?php if (get_magic_quotes_gpc()) { ?>
    <div class="container">
        <div class="grid12">
            <p>
                This PHP install has magic quotes enabled. This feature of PHP has been deprecated, and Monsta FTP is
                not compatible with magic quotes.
            </p>
            <p>
                Please disable PHP magic quotes to use Monsta FTP.
            </p>
            <p>
                For more information, please see:
                <a href="http://redirect.monstaftp.com/magic-quotes">http://redirect.monstaftp.com/magic-quotes</a>.
            </p>
        </div>
    </div>
<?php } else { ?>
    <div id="spinner" ng-controller="SpinnerController" ng-show="spinnerVisible">
        <div>
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        </div>
    </div>
    <div id="file-xfer-drop" ng-controller="DragDropController">
        <div translate>DROP_FILES_INSTRUCTION</div>
    </div>
    <ng-include src="'application/frontend/templates/modal-chmod.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-login.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-editor.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-transfers.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-prompt.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-confirm.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-error.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-upgrade.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-addons.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-settings.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-properties.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-login-link.html'"></ng-include>
    <ng-include src="'application/frontend/templates/modal-choice.html'"></ng-include>

    <div id="sb-site" canvas="container">
        <ng-include src="'application/frontend/templates/body-header.html'"></ng-include>
        <ng-include src="'application/frontend/templates/body-history.html'"></ng-include>
        <ng-include src="'application/frontend/templates/body-files.html'"></ng-include>
        <ng-include src="'application/frontend/templates/body-footer.html'"></ng-include>
    </div>

    <ng-include src="'application/frontend/templates/body-slidebar.html'"></ng-include>
<?php } ?>
</body>
</html>
