<?php
namespace DannyNimmo\SortSequelProFavourites;

class File
{

    /**
     * XML class for passed file
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * Array of favourites
     * @var \SimpleXMLElement[]
     */
    private $sortedFavourites;

    /**
     * Path to favourites file
     * @var string
     */
    private $filePath;

    /**
     * Path to favourites backup
     * @var string
     */
    private $backupPath;

    /**
     * @param string $filePath Path to XML file
     * @throws \Exception
     */
    public function __construct(
        string $filePath
    ) {
        if (file_exists($filePath)) {
            $this->filePath   = $filePath;
            $this->backupPath = $filePath . '-' . time();
            $this->xml = new \SimpleXMLElement(file_get_contents($filePath));
        } else {
            throw new \Exception('Favourites file not found at ' . $filePath);
        }
    }

    /**
     * Sort favourites & save to file
     */
    public function sort()
    {
        $this->generateSortedFavourites();
        $this->removeOriginalFavourites();
        $this->addSortedFavourites();
        $this->saveFavourites();
    }

    /**
     * Create a backup of favourites file
     * @throws \Exception
     */
    public function createBackup()
    {
        if (!copy($this->getFilePath(), $this->getBackupPath())) {
            throw new \Exception('Couldn\'t create backup of favourites to '.$this->getBackupPath());
        }
    }

    /**
     * Sort favourites in XML alphabetically
     * @throws \Exception
     */
    private function generateSortedFavourites()
    {
        $this->sortedFavourites = [];
        foreach ($this->xml->dict->dict->array->children() as $favourite) {
            $this->sortedFavourites[] = clone $favourite;
        }

        usort($this->sortedFavourites, function (\SimpleXMLElement $a, \SimpleXMLElement $b) {
            $aName = $this->getFavouriteName($a);
            $bName = $this->getFavouriteName($b);

            if (!$aName || !$bName) {
                throw new \Exception('Malformed XML in plist file');
            }

            return strcasecmp($aName, $bName);
        });
    }

    /**
     * Returns favourite name from passed favourite, or null if not found
     * @param \SimpleXMLElement $favourite
     * @return string|null
     */
    private function getFavouriteName(\SimpleXMLElement $favourite): ?string
    {
        $name = null;
        $nextIsName = false;
        foreach ($favourite->children() as $attribute) {
            if ($nextIsName) {
                $name = (string)$attribute;
                break;
            }
            if ($attribute->getName() === 'key' && $attribute == 'name') {
                $nextIsName = true;
            }
        }
        return $name;
    }

    /**
     * Remove original favourites from XML object
     */
    private function removeOriginalFavourites()
    {
        unset($this->xml->dict->dict->array->dict);
    }

    /**
     * Add sorted favourites to XML object
     */
    private function addSortedFavourites()
    {
        foreach ($this->sortedFavourites as $favourite) {
            $favouritesList = dom_import_simplexml($this->xml->dict->dict->array);
            $favourite      = dom_import_simplexml($favourite);
            $favouritesList->appendChild($favouritesList->ownerDocument->importNode($favourite, true));
        }
    }

    /**
     * Write XML object to disk
     */
    private function saveFavourites()
    {
        $this->xml->asXML($this->getFilePath());
    }

    /**
     * Get favourites file path
     * @return string
     */
    private function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Get favourites backup file path
     * @return string
     */
    public function getBackupPath(): string
    {
        return $this->backupPath;
    }

}
