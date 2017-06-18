@component('header')
@endcomponent

/**
 * Creating mail event defined by `$mail_event_data`.
 * Optionally, messages can be added for created event
 *
 * Docs to start:
 * - {@link https://dev.1c-bitrix.ru/api_help/main/reference/ceventtype/index.php}
 * - {@link https://dev.1c-bitrix.ru/api_help/main/reference/ceventtype/add.php}
 * - {@link https://dev.1c-bitrix.ru/api_d7/bitrix/main/mail/event/send.php}
 *
 * Base fields that are filled for mail event:
 * - EVENT_NAME varchar(50)
 * - LID char(2)
 * - SORT int
 * - NAME varchar(100)
 * - DESCRIPTION text
 *
 * Base fields that are filled for mail message:
 * - ACTIVE char(1) Y/N
 * - LID char(2)
 * - EMAIL_FROM
 * - EMAIL_TO varchar(255)
 * - BCC varchar(255)
 * - SUBJECT varchar(255)
 * - BODY_TYPE char(4) text/html
 * - MESSAGE text
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

@if (!empty($msgs))
$mail_msgs_data = [
@foreach ($msgs as $msg)
    [
        'ACTIVE' => '{{ $msg['ACTIVE'] }}',
        'LID' => '{{ $msg['LID'] }}',
        'EMAIL_FROM' => '{{ $msg['EMAIL_FROM'] }}',
        'EMAIL_TO' => '{{ $msg['EMAIL_TO'] }}',
        'SUBJECT' => '{{ $msg['SUBJECT'] }}',
        'BODY_TYPE' => '{{ $msg['BODY_TYPE'] }}',
        'MESSAGE' => '{!! $msg['MESSAGE'] !!}',
        'BCC' => '{{ $msg['BCC'] }}',
    ],
@endforeach
];
@endif

$obj_mail_event = new CEventType;

/**
 * Creating a mail event
 */
$r = $obj_mail_event->Add($mail_event_data);
if ($r) {
    echo 'MailEvent with ID: ' . $r . ' added succesfully.' .  PHP_EOL;

    /**
     * Creating mail messages
     */
    if (!empty($mail_msgs_data)) {
        $obj_mail_msg = new CEventMessage;

        foreach ($mail_msgs_data as $msg) {
            $msg['EVENT_NAME'] = $mail_event_data['EVENT_NAME'];
            $r = $obj_mail_msg->Add($msg);
            if ($r) {
                echo 'MailMessage with ID: ' . $r . ' added succesfully.' .  PHP_EOL;
            } else {
                echo 'Error adding MailMessage: ' . $obj_mail_msg->LAST_ERROR  . PHP_EOL;
            }
        }
    }
} else {
    echo 'Error adding MailEvent: ' . $obj_mail_event->LAST_ERROR  . PHP_EOL;
}

echo 'DONE!' . PHP_EOL;
