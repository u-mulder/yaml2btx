@component('header')
@endcomponent

/**
 * Adding user field defined by `$uf_data` array
 *
 * Docs to start:
 * - {@link https://dev.1c-bitrix.ru/learning/course/?COURSE_ID=43&LESSON_ID=3496}
 *
 * Bitrix core file to inspect:
 * - /bitrix/modules/main/classes/general/userfield.php
 *
 * Base fields that are filled:
 * - ENTITY_ID entity code (USER, SECTION, BLOG, etc)
 * - FIELD_NAME field name
 * - USER_TYPE_ID field type
 * - XML_ID for import/export
 * - SORT, default is 100
 * - MULTIPLE is multiple, default "N"
 * - MANDATORY is mandatory, default "N"
 * - SHOW_IN_LIST show in admin list, default "Y"
 * - EDIT_IN_LIST allow edit in form, default "Y"
 * - IS_SEARCHABLE allow search, default "N"
 * - SHOW_FILTER - show in filter and filter type [N - not show, I - exact match, E - pattern, S - substring]
 * - EDIT_FORM_LABEL - arrays like array("ru"=>"привет", "en"=>"hello")
 * - LIST_COLUMN_LABEL - arrays like array("ru"=>"привет", "en"=>"hello")
 * - LIST_FILTER_LABEL - arrays like array("ru"=>"привет", "en"=>"hello")
 * - ERROR_MESSAGE - arrays like array("ru"=>"привет", "en"=>"hello")
 * - HELP_MESSAGE - arrays like array("ru"=>"привет", "en"=>"hello")
 *
 * Other fields can be added manually in generated code.
 *
 * Currently in d7 method `Bitrix\Main\UserFieldTable::add`
 * throws `NotImplementedException` warning.
 *
 * So we first try to use it, and if exception is
 * caught then use plain old `CUserTypeEntity`
 */
$uf_data = [
    'ENTITY_ID' => '{{ $uf['ENTITY_ID'] }}',
    'FIELD_NAME' => '{{ $uf['FIELD_NAME'] }}',
    'USER_TYPE_ID' => '{{ $uf['USER_TYPE_ID'] }}',
    'XML_ID' => '{{ $uf['XML_ID'] }}',
    'SORT' => {{ $uf['SORT'] }},

    'MULTIPLE' => '{{ $uf['MULTIPLE'] }}',
    'MANDATORY' => '{{ $uf['MANDATORY'] }}',
    'SHOW_FILTER' => '{{ $uf['SHOW_FILTER'] }}',
    'SHOW_IN_LIST' => '{{ $uf['SHOW_IN_LIST'] }}',
    'EDIT_IN_LIST' => '{{ $uf['EDIT_IN_LIST'] }}',
    'IS_SEARCHABLE' => '{{ $uf['IS_SEARCHABLE'] }}',

    'EDIT_FORM_LABEL' => array(
        @foreach($uf['EDIT_FORM_LABEL'] as $k => $v)
        '{{ $k }}' => '{{ $v }}',
        @endforeach
    ),
    'LIST_COLUMN_LABEL' => array(
        @foreach($uf['LIST_COLUMN_LABEL'] as $k => $v)
        '{{ $k }}' => '{{ $v }}',
        @endforeach
    ),
    'LIST_FILTER_LABEL' => array(
        @foreach($uf['LIST_FILTER_LABEL'] as $k => $v)
        '{{ $k }}' => '{{ $v }}',
        @endforeach
    ),
    'ERROR_MESSAGE' => array(
        @foreach($uf['ERROR_MESSAGE'] as $k => $v)
        '{{ $k }}' => '{{ $v }}',
        @endforeach
    ),
    'HELP_MESSAGE' => array(
        @foreach($uf['HELP_MESSAGE'] as $k => $v)
        '{{ $k }}' => '{{ $v }}',
        @endforeach
    ),

    // set Settings manually if required
    'SETTINGS' => array(),
];
$uf_added = false;
try {
    $r = \Bitrix\Main\UserFieldTable::add($uf_added);
    if ($r->isSuccess()) {
        echo 'Userfield with id ' . $r->getId() . ' created succesfully' . PHP_EOL;
    } else {
        echo 'Errors adding Userfield: ' . PHP_EOL;
        foreach ($r->getErrors() as $e) {
            echo $e->GetMessage() . PHP_EOL;
        }
    }

    $uf_added = true;
} catch (\NotImplementedException $e) {
    // nothing to do here
}

if (!$uf_added) {
    $utype = new CUserTypeEntity();
    $r = $utype->add($uf_data);
    if ($r) {
        echo 'Userfield with id ' . $r . ' created succesfully' . PHP_EOL;
    } else {
        echo 'Error adding UserField: ' . $utype->LAST_ERROR  . PHP_EOL;
    }
}

echo 'Done!' . PHP_EOL;
