<?php
namespace DannyNimmo\SortSequelProFavourites;

class Cli
{

    const ARGUMENT_FILE_SHORT    = 'f';
    const ARGUMENT_FILE_LONG     = 'file';

    const ARGUMENT_VERSION_SHORT = 'v';
    const ARGUMENT_VERSION_LONG  = 'version';

    const ARGUMENT_HELP_SHORT    = 'h';
    const ARGUMENT_HELP_LONG     = 'help';

    /**
     * Returns App route based on CLI arguments, or null if no arguments found
     * @return string|null
     */
    public function route(): ?string
    {
        $route = null;

        $options = getopt(
            self::ARGUMENT_VERSION_SHORT .
            self::ARGUMENT_HELP_SHORT .
            self::ARGUMENT_FILE_SHORT . ':',
            [
                self::ARGUMENT_VERSION_LONG,
                self::ARGUMENT_HELP_LONG,
                self::ARGUMENT_FILE_LONG . ':',
            ]
        );

        if (isset($options[self::ARGUMENT_HELP_SHORT]) || isset($options[self::ARGUMENT_HELP_LONG])) {
            $route = App::ROUTE_USAGE;
        } elseif (isset($options[self::ARGUMENT_VERSION_SHORT]) || isset($options[self::ARGUMENT_VERSION_LONG])) {
            $route = App::ROUTE_VERSION;
        } elseif (isset($options[self::ARGUMENT_FILE_SHORT]) || isset($options[self::ARGUMENT_FILE_LONG])) {
            $route = App::ROUTE_SORT;
        }

        return $route;
    }

    /**
     * Get CLI usage instructions
     * @return string
     */
    public function getUsage(): string
    {
        return '
Usage: sort-sequel-pro-favourites.php -'.self::ARGUMENT_FILE_SHORT.' <file>

Sorts Sequel Pro favourites list alphabetically. Works with the latest version of Sequel Pro (v1.1.2).

Options:
  -'.self::ARGUMENT_FILE_SHORT.', --'.self::ARGUMENT_FILE_LONG.'     Path to Sequel Pro favourites .plist file  (MacOS default: ~/Library/Application\ Support/Sequel\ Pro/Data/Favorites.plist)
  -'.self::ARGUMENT_VERSION_SHORT.', --'.self::ARGUMENT_VERSION_LONG.'  Print version information
  -'.self::ARGUMENT_HELP_SHORT.', --'.self::ARGUMENT_HELP_LONG.'     Usage information
';
    }

    /**
     * Get path to file passed via CLI argument
     * @return string|null Path to file, or null if not valid
     */
    public function getFilePath(): ?string
    {
        $file = null;
        $options = getopt(
            self::ARGUMENT_FILE_SHORT . ':',
            [self::ARGUMENT_FILE_LONG . ':']
        );

        $fileShortSet = (isset($options[self::ARGUMENT_FILE_SHORT]) && is_string($options[self::ARGUMENT_FILE_SHORT]));
        $fileLongSet  = (isset($options[self::ARGUMENT_FILE_LONG]) && is_string($options[self::ARGUMENT_FILE_LONG]));

        if (
            ($fileShortSet || $fileLongSet)
            && !($fileShortSet && $fileLongSet)
        ) {
            $file = ($fileShortSet) ? $options[self::ARGUMENT_FILE_SHORT] : $options[self::ARGUMENT_FILE_LONG];
        }

        return $file;
    }

}
