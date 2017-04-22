# yaml2btx
Generating php-codes for bitrix entities from yaml config files

## Usage sample

```
require_once "./vendor/autoload.php";

$g = new \Yaml2Btx\Generator();
$g->parse('./config/iblock.yaml')->save('./output/output.php');

```
