@component('header')
@endcomponent

/**
 * Creating iblock template script with D7.
 *
 * Docs to start:
 * - {@link https://dev.1c-bitrix.ru/api_d7/bitrix/iblock/iblocktable/index.php}
 * - {@link https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblock/index.php}
 * - {@link https://dev.1c-bitrix.ru/api_help/iblock/fields.php#fiblock}
 *
 * Base fields that are filled:
 * - IBLOCK_TYPE_ID string(50) mandatory
 * - CODE string(50) optional
 * - NAME string(255) mandatory
 * - ACTIVE bool optional default 'Y'
 * - SORT int optional default 500
 * - LIST_PAGE_URL string(255) optional
 * - DETAIL_PAGE_URL string(255) optional
 * - SECTION_PAGE_URL string(255) optional
 * - DESCRIPTION text optional
 * - DESCRIPTION_TYPE enum ('text', 'html') optional default 'text'
 * - XML_ID string(255) optional
 * - INDEX_ELEMENT bool optional default 'Y'
 * - INDEX_SECTION bool optional default 'N'
 * - VERSION enum (1 or 2) optional default 1
 *
 * Other fields can be added manually in generated code.
 */

\Bitrix\Main\Loader::includeModule('iblock');

$iblock_data = [
    'IBLOCK_TYPE_ID' => '{{ $ib['TYPE'] }}',
    'CODE' => '{{ $ib['CODE'] }}',
    'NAME' => '{{ $ib['NAME'] }}',
    'ACTIVE' => '{{ $ib['ACTIVE'] }}',
    'SORT' => {{ $ib['SORT'] }},
    'LIST_PAGE_URL' => '{{ $ib['LIST_PAGE_URL'] }}',
    'DETAIL_PAGE_URL' => '{{ $ib['DETAIL_PAGE_URL'] }}',
    'SECTION_PAGE_URL' => '{{ $ib['SECTION_PAGE_URL'] }}',
    'DESCRIPTION' => '{!! $ib['DESCRIPTION'] !!}',
    'DESCRIPTION_TYPE' => '{{ $ib['DESC_TYPE'] }}',
    'XML_ID' => '{{ $ib['XML_ID'] }}',
    'INDEX_ELEMENT' => '{{ $ib['INDEX_ELEMENT'] }}',
    'INDEX_SECTION' => '{{ $ib['INDEX_SECTION'] }}',
    'VERSION' => {{ $ib['VERSION'] }},
];

/**
 * Creating an iblock
 */
$r = \Bitrix\Iblock\IblockTable::add($iblock_data);
if ($r->isSuccess()) {
    echo 'Iblock with id ' . $r->getId() . ' created succesfully' . PHP_EOL;
} else {
    echo 'Errors adding iblock: ' . PHP_EOL;
    foreach ($r->getErrors() as $e) {
        echo $e->GetMessage() . PHP_EOL;
    }
}

echo 'DONE!' . PHP_EOL;
