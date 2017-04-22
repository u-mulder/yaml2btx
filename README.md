# yaml2btx
Generating php-codes for bitrix entities from yaml config files

## Usage sample

```
require_once "./yaml2btx/vendor/autoload.php";

$g = new \Yaml2Btx\Generator();
$g->parse('./yaml2btx/configs/iblock.yaml')->save('./output.php');

```
