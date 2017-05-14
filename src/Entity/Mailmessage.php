<?php
/**
 * Entity which creates code for event message adding
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

class Mailmessage extends AbstractEntity
{

    /**
     * @var string Blade template name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const TEMPLATE_NAME = 'mailmessage';

    /**
     * Method prepares data for using in blade template
     *
     * `??` operator not used because not all users have php7
     * `?:` operator not used because it emits warning
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected function prepareEntity($entity_data)
    {
        if (!empty($entity_data['fields'])) {
            $fields = $this->normalizeKeys($entity_data['fields']);

            $this->entity_data['msg'] = [];

            $this->entity_data['msg']['ACTIVE'] =
                !empty($fields['ACTIVE']) && $this->isNoValue($fields['ACTIVE']) ?
                self::VALUE_N : self::VALUE_Y;

            $this->entity_data['msg']['LID'] = !empty($fields['LID']) ?
                substr(trim($fields['LID']), 0, 2) : '';

            $keys = ['EMAIL_FROM', 'EMAIL_TO', 'BCC', 'SUBJECT', 'MESSAGE'];
            foreach ($keys as $key) {
                $this->entity_data['msg'][$key] = !empty($fields[$key]) ?
                    trim($fields[$key]) : '';
            }

            $desc_type =
                !empty($fields['BODY_TYPE']) && self::DESC_TYPE_HTML == $fields['BODY_TYPE'] ?
                self::DESC_TYPE_HTML : self::DESC_TYPE_TEXT;
            $this->entity_data['msg']['BODY_TYPE'] = $desc_type;
        }
    }
}
