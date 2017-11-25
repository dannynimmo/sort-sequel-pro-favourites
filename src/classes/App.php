<?php
namespace DannyNimmo\SortSequelProFavourites;

class App
{

    const NAME    = 'Sort Sequel Pro Favourites';
    const VERSION = '0.1.0';

    const ROUTE_VERSION = 'version';
    const ROUTE_SORT    = 'sort';
    const ROUTE_USAGE   = 'usage';

    const EXIT_CODE_SUCCESS = 0;
    const EXIT_CODE_ERROR   = 1;

    /**
     * Cli class
     * @var Cli
     */
    private $cli;

    /**
     * File class
     * @var File
     */
    private $file;

    /**
     * App constructor
     */
    public function __construct()
    {
        $this->cli = new Cli();
    }

    /**
     * Start application
     */
    public function start()
    {
        switch ($this->cli->route()) {
            case self::ROUTE_VERSION:
                $versionMessage = sprintf('%s version %s', self::NAME, self::VERSION);
                $this->finish(self::EXIT_CODE_SUCCESS, $versionMessage);
                break;
            case self::ROUTE_SORT:
                try {
                    $this->sort();
                    $messageLines = [
                        'A backup was created at '.$this->file->getBackupPath(),
                        'Your favourites have been sorted!'
                    ];
                    $this->finish(self::EXIT_CODE_SUCCESS, implode("\n", $messageLines));
                } catch (\Exception $e) {
                    $this->finish(self::EXIT_CODE_ERROR, 'Error: ' . $e->getMessage());
                }
                break;
            case self::ROUTE_USAGE:
            default:
                $this->finish(self::EXIT_CODE_SUCCESS, $this->cli->getUsage());
                break;
        }
    }

    /**
     * Sort favourites
     */
    private function sort()
    {
        $this->file = new File($this->cli->getFilePath());
        $this->file->createBackup();
        $this->file->sort();
    }

    /**
     * Finish up application
     * @param int $exitCode CLI exit code
     * @param string|null $message Optional message to output
     */
    public function finish(
        int $exitCode,
        ?string $message
    ) {
        if ($message) {
            echo $message;
            if (substr($message, -1) !== "\n") {
                echo "\n";
            }
        }
        exit($exitCode);
    }

}
