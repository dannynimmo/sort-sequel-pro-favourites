# Sort Sequel Pro Favourites

I have many saved favourites in my Sequel Pro, and I needed a way to sort these alphabetically.

This has only been tested on the latest version of [Sequel Pro](https://www.sequelpro.com/) (v1.1.2). A backup of your favourites file should be made before sorting, however please use at your own risk!


## Installation

1. Download the latest release:
    ```bash
    curl --output /usr/local/bin/sort-sequel-pro-favourites https://raw.githubusercontent.com/dannynimmo/sort-sequel-pro-favourites/0.1.0/sort-sequel-pro-favourites.phar
    ```
2. Make the file executable:
    ```bash
    chmod u+x /usr/local/bin/sort-sequel-pro-favourites
    ```
3. Verify your installation:
    ```bash
    sort-sequel-pro-favourites --version
    ```
    The command should execute successfully and output the version information:
    > Sort Sequel Pro Favourites version 0.1.0


## Usage

Run from the command line, passing in the path to your favourites file (on MacOS the default location is `~/Library/Application\ Support/Sequel\ Pro/Data/Favorites.plist`):
```bash
sort-sequel-pro-favourites --file /path/to/Favorites.plist
```
