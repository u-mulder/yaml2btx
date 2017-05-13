@component('header')  // TODO
@endcomponent

/**
 * Creating mail event defined by `$mail_event_data`.
 *
 * Docs to start:
 * - {@link https://dev.1c-bitrix.ru/api_help/main/reference/ceventtype/index.php}
 * - {@link https://dev.1c-bitrix.ru/api_help/main/reference/ceventtype/add.php}
 * - {@link https://dev.1c-bitrix.ru/api_d7/bitrix/main/mail/event/send.php}
 *
 * Base fields that are filled:
 * - EVENT_NAME varchar(50)
 * - LID char(2)
 * - SORT int
 * - NAME varchar(100)
 * - DESCRIPTION text
 *
 * Other fields can be added manually in generated code.
 */

$mail_event_data = [
    'EVENT_NAME' => '{{ $me['EVENT_NAME'] }}',
    'LID' => '{{ $me['LID'] }}',
    'SORT' => {{ $me['SORT'] }},
    'NAME' => '{{ $me['NAME'] }}',
    'DESCRIPTION' => '{{ $me['DESCRIPTION'] }}',
];

$obj_mail_event = new CEventType;

/**
 * Creating a mail event
 */
$r = $obj_mail_event->Add($mail_event_data);
if ($r) {
    echo 'MailEvent with ID: ' . $r . ' added succesfully.' .  PHP_EOL;
} else {
    echo 'Error adding MailEvent: ' . $obj_mail_event->LAST_ERROR  . PHP_EOL;
}

echo 'DONE!' . PHP_EOL;




    /*$mmo = new CEventMessage;
    $mm = array(
        // TODO - set proper LID for template!
        'SUBJECT' => '#SUBJECT#',
        'BODY_TYPE' => 'text',
        'MESSAGE' => 'Message here with #MACROS#',
        'EVENT_NAME' => '_event_name_',
        'LID' => '_SID_',
        'ACTIVE' => 'Y',
        'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
        'EMAIL_TO' => '#EMAIL_TO#',
    );
    $r = $mmo->add($mm);
    if ($r) {
        echo 'Added MailTemplate with ID: ' . $r . PHP_EOL;
    } else {
        echo 'Error adding MailTemplate: ' . $mmo->LAST_ERROR  . PHP_EOL;
    }*/
