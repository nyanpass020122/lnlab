<?php

    require_once(dirname(__FILE__) . '/ArchiveExtractor.php');

    class ZipExtractor extends ArchiveExtractor {
        protected function setupArchiveHandle($archivePath) {
            if($this->archiveHandle !== null)
                return;

            $this->archiveHandle = new ZipArchive();

            if ($this->archiveHandle->open($archivePath, ZipArchive::CHECKCONS) !== true) {
                throw new LocalizableException("Could not read zip file at " . $archivePath,
                    LocalizableExceptionDefinition::$ARCHIVE_READ_ERROR, array(
                        "path" => $archivePath
                    ));
            }
        }

        public function getFileCount() {
            $this->setupArchiveHandle($this->getArchivePath());

            return $this->archiveHandle->numFiles;
        }

        protected function getFileInfoAtIndex($fileIndex) {
            $this->setupArchiveHandle($this->getArchivePath());

            return array(
                $this->archiveHandle->getNameIndex($fileIndex),
                null
            );
        }

        protected function extractArchiveFilePath($archivePath, $fullFilePath) {
            return $fullFilePath;
        }

        protected function extractFileToDisk($archive, $extractDir, $itemPath){
            $archive->extractTo($extractDir, $itemPath);
        }
    }