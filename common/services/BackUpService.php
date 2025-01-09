<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Telegram: Husayn_Hasanov
 * email: hhs.16051998@gmail.com
 * Date: 17/11/22
 * Time: 19:26
 */

namespace common\services;

use common\helpers\TelegramHelper;
use common\helpers\Utilities;
use ZipArchive;

class BackUpService
{
    const COF_DATABASE_PASSWORD = 'BdWKjg5QB55z';
    const COF_DATABASE_USERNAME = 'postgres';
    const COF_DATABASE_NAME = 'leasing';

    public $database_name;
    public $database_username;
    public $database_password;

    public function __construct()
    {
        $this->database_name = self::COF_DATABASE_NAME;
        $this->database_username = self::COF_DATABASE_USERNAME;
        $this->database_password = self::COF_DATABASE_PASSWORD;
    }

    public function make($fileName)
    {
        putenv("PGPASSWORD=" . $this->database_password);
        $dumpcmd = array("pg_dump", "-U", escapeshellarg($this->database_username), "-F", "c", "-b", "-v", "-f", escapeshellarg($fileName), escapeshellarg($this->database_name));
        exec(join(' ', $dumpcmd), $cmdout, $cmdresult);
        putenv("PGPASSWORD");
        if ($cmdresult != 0) {
            var_dump($cmdresult);
        }
    }

    public function dumpDatabase($backupFilePath, $dbName = self::COF_DATABASE_NAME, $user = self::COF_DATABASE_USERNAME, $password = self::COF_DATABASE_PASSWORD, $host = "127.0.0.1", $port = "5432")
    {
        putenv("PGPASSWORD=$password");
        $command = "pg_dump --host=$host --port=$port --username=$user --dbname=$dbName --file=$backupFilePath";
        // Execute the command
        exec($command, $output, $returnValue);
        // Check if the command was executed successfully
        if ($returnValue === 0) {
            echo "Database dumped successfully.\n";
        } else {
            echo "Error dumping database: " . implode("\n", $output);
        }
    }

    public function setFileIntoZip($zipFileName, $fileName, $zipFilePath)
    {
        $password = Utilities::generateRandomPassword(7, 6, 5, 0);//\Yii::$app->params['zip-password'];
        $sourceFile = $zipFilePath . $fileName;
        $zipFile = $zipFilePath . $zipFileName;
        $command = "zip -P {$password} {$zipFile} {$sourceFile}";
        // Execute the command
        exec($command, $output, $returnVar);

        // Check the return value to see if the command executed successfully
        if ($returnVar === 0) {
            echo "ZIP file created successfully with password.\n";
        } else {
            echo "Error creating ZIP file.\n";
            var_dump($returnVar);
        }
        return $password;
    }

    public function set2zip($zipFileName, $fileName, $filePath)
    {
        $zip = new ZipArchive();
        $zip->open($filePath . $zipFileName, ZipArchive::CREATE);
        $zip->addFile($filePath . $fileName);
        $zip->setPassword(\Yii::$app->params['zip-password']);
        $zip->close();
    }

    public function removeOldFiles(TelegramHelper $telegramService)
    {
        $assets_url = "https:" . \Yii::getAlias("@assets_url");
        $dir = "/var/www/murobahauz/assets/backup";
        if ($handle = opendir($dir)) {
            $telegramService->setChatIdBySlug();
            while (false !== ($file = readdir($handle)))
                if ($file != "." && $file != ".." && $file != "rmv.php" && $file != ".gitignore") {
                    $file = $dir . "/" . $file;
                    $filelastmodified = filemtime($file);
                    $now = time();
                    if (($now - $filelastmodified) > 40000) {
                        var_dump($file);
                        if (unlink($file)) {
                            $telegramService->sendMessage("Deleted successfully : " . $assets_url . $file);
                        } else {
                            $telegramService->sendMessage("Cannot delete : " . $assets_url . $file);
                        }
                    }
                }
            closedir($handle);
        }
    }
}