@component('header')
@endcomponent

/**
 * Adding iblock property defined by `$ib_prop_data` array
 *
 * Docs to start:
 * - {@link https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockproperty/add.php}
 * - {@link https://dev.1c-bitrix.ru/api_help/iblock/fields.php#fproperty}
 *
 * Base fields that are filled:
 * - CODE string(50) optional
 * - XML_ID string(100) optional
 * - IBLOCK_ID Int mandatory
 * - NAME string(100) mandatory
 * - ACTIVE char(1) mandatory, default "Y"
 * - IS_REQUIRED char(1) optional
 * - SORT int, default 500
 * - PROPERTY_TYPE char(1) mandatory [S, N, F, L, E, G], default "S"
 * - MULTIPLE char(1) mandatory, default "N"
 * - DEFAULT_VALUE string(255) optional
 * - ROW_COUNT int, default 1
 * - COL_COUNT int, default 30
 * - LIST_TYPE char(1) [L, C], default "L"
 * - SEARCHABLE char(1) mandatory, default "N"
 * - FILTRABLE char(1) mandatory, default "N"
 * - LINK_IBLOCK_ID int optional
 * - WITH_DESCRIPTION char(1) optional
 * - HINT char optional
 *
 * Other fields can be added manually in generated code.
 *
 */

\Bitrix\Main\Loader::includeModule('iblock');

$ib_prop_data = [
    'IBLOCK_ID' => {{ $ibp['IBLOCK_ID'] }},
    'ACTIVE' => '{{ $ibp['ACTIVE'] }}',
    'NAME' => '{{ $ibp['NAME'] }}',
    'HINT' => '{{ $ibp['HINT'] }}',
    'SORT' => {{ $ibp['SORT'] }},
    'CODE' => '{{ $ibp['CODE'] }}',
    'XML_ID' => '{{ $ibp['XML_ID'] }}',
    'LINK_IBLOCK_ID' => {{ $ibp['LINK_IBLOCK_ID'] }},
    'DEFAULT_VALUE' => '{{ $ibp['DEFAULT_VALUE'] }}',
    'LIST_TYPE' => '{{ $ibp['LIST_TYPE'] }}',
    'PROPERTY_TYPE' => '{{ $ibp['PROPERTY_TYPE'] }}',
    'ROW_COUNT' => {{ $ibp['ROW_COUNT'] }},
    'COL_COUNT' => {{ $ibp['COL_COUNT'] }},
    'WITH_DESCRIPTION' => '{{ $ibp['WITH_DESCRIPTION'] }}',
    'SEARCHABLE' => '{{ $ibp['SEARCHABLE'] }}',
    'FILTRABLE' => '{{ $ibp['FILTRABLE'] }}',
    'MULTIPLE' => '{{ $ibp['MULTIPLE'] }}',
    'IS_REQUIRED' => '{{ $ibp['IS_REQUIRED'] }}',

    // set USER_TYPE and USER_TYPE_SETTINGS manually if required
    'USER_TYPE' => false,
    'USER_TYPE_SETTINGS' => false,
];

$ibp = new CIBlockProperty();
$r = $ibp->add($prop);
if ($r) {
    echo 'Iblock property with ID: ' . $r . ' added succesfully.' . PHP_EOL;
} else {
    echo 'Error adding iblock property: ' . $ibp->LAST_ERROR  . PHP_EOL;
}

echo 'Done!' . PHP_EOL;
