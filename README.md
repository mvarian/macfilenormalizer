# normalizeFiles
HFS+ normalizes filenames automatically, while APFS does not.  This MAY create problems when comparing files between two volumes in each format, such as when using Carbon Copy Cloner to back up from one drive to another involving a Synology NAS.  This script will recursively traverse a given ROOT directory and rename files in place to substitute non-ascii characters for ascii equivalents, if possible.
    
  
# DISCLAIMER

This script will make irreversible changes to your file and folder names.  This may break things, especially if altering paths relied on by the operating system, applications, or links/shortcuts/aliases.  Run carefully, and if possible run on a duplicate set of your data and always maintain a separate backup just in case.  Nobody else is responsible if you break something.
  
  
# Usage

*Please note this tool acts recursively on the directory provided, meaning it will include all subfolders and the files in those subfolders*

1. Open `normalizeFiles.php` in a text editor, set the $ROOT variable on line 5 to the path you want to normalize.  
2. Open a terminal window and navigate to the folder containing `normalizeFiles.php`.
3. Execute `php normalizeFiles.php`