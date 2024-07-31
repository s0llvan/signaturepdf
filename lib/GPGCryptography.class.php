<?php

class GPGCryptography
{
    private $symmetricKey = null;
    private $pathHash = null;

    function __construct($key, $pathHash) {
            $this->symmetricKey = $key;
            $this->pathHash = $pathHash;
    }

    private function getFiles($isGpg) {
        $suffix = "";
        if ($isGpg) {
            $suffix = ".gpg";
        }
        $filesTab = glob($this->pathHash.'/*.pdf'.$suffix);

        if(file_exists($this->pathHash."/filename.txt".$suffix)) {
            $filesTab[] = $this->pathHash."/filename.txt".$suffix;
        }

        return $filesTab;
    }

    public function encrypt() {
        putenv('HOME='.sys_get_temp_dir());
        foreach ($this->getFiles(false) as $file) {
            $outputFile = $file.".gpg";
            $command = "gpg --batch --passphrase $this->symmetricKey --symmetric --cipher-algo AES256 -o $outputFile $file > /dev/null";
            $result = shell_exec($command);
            if ($result) {
                echo "Cipher failure";
                return $result;
            }
            $this->hardUnlink($file);

        }
        return true;
    }

    public function decrypt() {
        if (!$this->isEncrypted()) {
            return $this->pathHash;
        }
        if (!$this->symmetricKey) {
            return false;
        }
        $decryptFolder = sys_get_temp_dir()."/".uniqid('pdfsignature.decrypted.'.getmypid(), true);
        putenv('HOME='.sys_get_temp_dir());
        mkdir($decryptFolder);
        foreach ($this->getFiles(true) as $file) {
            $outputFile = $decryptFolder."/".str_replace(".gpg", "", basename($file));
            $command = "gpg --batch --passphrase $this->symmetricKey --decrypt -o $outputFile $file > /dev/null";
            $result = shell_exec($command);
            if ($result) {
                throw new Exception("Decipher failure");
            }
        }
        return $decryptFolder;
    }

    public function isEncrypted() {
        return self::isPathEncrypted($this->pathHash);
    }

    public static function isPathEncrypted($pathHash) {
        return file_exists($pathHash."/filename.txt.gpg");
    }

    public static function hardUnlink($element) {
        if (!$element) {
            return;
        }
        if (is_dir($element)) {
            foreach (glob($element.'/*') as $file) {
                self::hardUnlink($file);
            }
            rmdir($element);
            return;
        }
        $eraser = str_repeat(0, strlen(file_get_contents($element)));
        file_put_contents($element, $eraser);
        unlink($element);
    }

    public static function protectSymmetricKey($key) {
        return preg_replace('/[^0-9a-zA-Z]*/', '', $key);
    }

    public static function createSymmetricKey() {
            $length = 15;
            $keySpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pieces = [];
            $max = mb_strlen($keySpace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $pieces []= $keySpace[random_int(0, $max)];
            }

            return implode('', $pieces);
        }

    public static function isGpgInstalled() {
        $output = null;
        $returnCode = null;

        exec('gpg --version', $output, $returnCode);

        if ($returnCode == 0) {
            return true;
        }
        return false;
    }
}