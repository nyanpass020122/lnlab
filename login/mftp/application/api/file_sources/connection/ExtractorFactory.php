<?php
    require_once(dirname(__FILE__) . "/ArchiveExtractor.php");
    require_once(dirname(__FILE__) . "/ZipExtractor.php");

    class ExtractorFactory {
        public static function getDefaultExtractor($archivePath, $uploadDirectory) {
            if(class_exists('PharData'))
                return new ArchiveExtractor($archivePath, $uploadDirectory);

            return new ZipExtractor($archivePath, $uploadDirectory);
        }
    }