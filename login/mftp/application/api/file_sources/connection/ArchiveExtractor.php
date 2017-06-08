<?php

    require_once(dirname(__FILE__) . "/../../lib/helpers.php");
    require_once(dirname(__FILE__) . "/../PathOperations.php");
    require_once(dirname(__FILE__) . "/../../lib/LocalizableException.php");
    require_once(dirname(__FILE__) . "/../../lib/helpers.php");
    require_once(dirname(__FILE__) . "/ConnectionFactory.php");

    class ArchiveExtractor {
        private $archivePath;
        private $uploadDirectory;
        private $extractDirectory;
        private $flatFileList;
        protected $archiveHandle;

        public function __construct($archivePath, $uploadDirectory) {
            $this->archivePath = $archivePath;
            $this->uploadDirectory = $uploadDirectory;
            $this->existingDirectories = array();
            $this->flatFileList = null;
            $this->archiveHandle = null;
        }

        protected function getArchivePath() {
            return $this->archivePath;
        }

        private function listArchiveContents($item, $initial = false) {
            if($initial)
                $this->flatFileList[] = array($item->getPathname(), $item->isDir());

            foreach ($item as $subItem) {
                $itemRecordedAlready = false;

                foreach ($this->flatFileList as $existingItem) {
                    if($existingItem[0] == $subItem->getPathname()) {
                        $itemRecordedAlready = true;
                        break;
                    }
                }

                if(!$itemRecordedAlready)
                    $this->flatFileList[] = array($subItem->getPathname(), $subItem->isDir());

                if ($subItem->isDir()) {
                    $subItemIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($subItem));

                    $this->listArchiveContents($subItemIterator);
                }
            }
        }

        protected function extractArchiveFilePath($archivePath, $fullFilePath) {
            $pharUrl = "phar://" . $archivePath;

            $filePathWithGarbage = substr($fullFilePath, strlen($pharUrl));
            $firstSlashPos = strpos($filePathWithGarbage, "/");

            if ($firstSlashPos !== false)
                return substr($filePathWithGarbage, $firstSlashPos + 1);
            else
                return $filePathWithGarbage;
        }

        protected function setupArchiveHandle($archivePath) {
            if($this->archiveHandle !== null)
                return;

            try {
                $this->archiveHandle = new PharData($archivePath);
            } catch (UnexpectedValueException $e) {
                throw new LocalizableException("Could not read archive file at " . $archivePath,
                    LocalizableExceptionDefinition::$ARCHIVE_READ_ERROR, array(
                        "path" => $archivePath
                    ));
            }
        }

        public function getFileCount() {
            $this->buildFlatFileList();
            return count($this->flatFileList);
        }

        protected function handleBuildFlatFileList() {
            $this->setupArchiveHandle($this->archivePath);

            $this->listArchiveContents($this->archiveHandle, true);
        }

        private function buildFlatFileList() {
            if($this->flatFileList !== null)
                return;

            $this->flatFileList = array();
            $this->handleBuildFlatFileList();
        }

        protected function getFileInfoAtIndex($fileIndex) {
            return $this->flatFileList[$fileIndex];
        }

        public function extractAndUpload($connection, $fileOffset, $stepCount) {
            $connection->changeDirectory($this->uploadDirectory);

            $this->createExtractDirectory();

            $fileMax = min($this->getFileCount(), $fileOffset + $stepCount);

            for (; $fileOffset < $fileMax; ++$fileOffset)
                $this->extractAndUploadItem($connection, $this->archiveHandle, $this->getFileInfoAtIndex($fileOffset));

            return $this->getFileCount() == $fileOffset;
        }

        private function getTransferOperation($connection, $localPath, $remotePath) {
            return TransferOperationFactory::getTransferOperation(strtolower($connection->getProtocolName()),
                array(
                    "localPath" => $localPath,
                    "remotePath" => $remotePath
                )
            );
        }

        private function createExtractDirectory() {
            $tempPath = tempnam(monstaGetTempDirectory(), basename($this->archivePath) . "extract-dir");

            if (file_exists($tempPath))
                unlink($tempPath);

            mkdir($tempPath);
            if (!is_dir($tempPath))
                throw new Exception("Temp archive dir was not a dir");

            $this->extractDirectory = $tempPath;
        }

        private function isPathTraversalPath($itemName) {
            return strpos($itemName, "../") !== FALSE || strpos($itemName, "..\\") !== FALSE;
        }

        protected function extractFileToDisk($archive, $extractDir, $itemPath){
            $archive->extractTo($extractDir, $itemPath, true);
        }

        private function extractAndUploadItem($connection, $archive, $itemInfo) {
            if ($this->isPathTraversalPath($itemInfo[0]))
                return;

            if($itemInfo[1] === true) // is directory
                return;

            $archiveInternalPath = $this->extractArchiveFilePath($this->archivePath, $itemInfo[0]);

            if(DIRECTORY_SEPARATOR == "\\")
                $archiveInternalPath = str_replace("\\", "/", $archiveInternalPath); // fix in windows

            $this->extractFileToDisk($archive, $this->extractDirectory, $archiveInternalPath);

            $itemPath = PathOperations::join($this->extractDirectory, $archiveInternalPath);

            if (is_null($itemInfo[1]) && is_dir($itemPath))
                return;

            $uploadPath = PathOperations::join($this->uploadDirectory, $archiveInternalPath);

            $remoteDirectoryPath = remoteDirname($uploadPath);

            if (!$this->directoryRecordExists($remoteDirectoryPath)) {
                $connection->makeDirectoryWithIntermediates($remoteDirectoryPath);
                $this->recordExistingDirectories(PathOperations::directoriesInPath($remoteDirectoryPath));
            }

            $uploadOperation = $this->getTransferOperation($connection, $itemPath, $uploadPath);

            try {
                $connection->uploadFile($uploadOperation);
            } catch (Exception $e) {
                @unlink($itemPath);
                throw $e;
                // this should be done in a finally to avoid repeated code but we need to support PHP < 5.5
            }

            @unlink($itemPath);
        }

        private function directoryRecordExists($directoryPath) {
            // this is not true directory exists function, just if we have created it or a subdirectory in this object
            return array_search(PathOperations::normalize($directoryPath), $this->existingDirectories) !== false;
        }

        private function recordDirectoryExists($directoryPath) {
            if ($this->directoryRecordExists($directoryPath))
                return;

            $this->existingDirectories[] = PathOperations::normalize($directoryPath);
        }

        private function recordExistingDirectories($existingDirectories) {
            foreach ($existingDirectories as $existingDirectory) {
                $this->recordDirectoryExists($existingDirectory);
            }
        }
    }