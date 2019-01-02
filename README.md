# normalizeFiles
HFS+ normalizes filenames automatically, while APFS does not.  This can create problems when comparing files between two volumes in each format, such as when using Carbon Copy Cloner to back up from one drive to another.  This script will recursively traverse a given ROOT directory and rename files in place to substitute non-ascii characters for ascii equivalents, if possible.
