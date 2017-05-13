<?php
/**
 * Entity which creates code for iblock adding
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

class Mailevent extends AbstractEntity
{

    /**
     * @var int Default sort for SORT fields
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_SORT = 150;

    /**
     * @var string Blade template name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const TEMPLATE_NAME = 'mailevent';

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

            $keys = ['EVENT_NAME', 'NAME', 'DESCRIPTION'];
            foreach ($keys as $key) {
                $this->entity_data['me'][$key] = !empty($fields[$key]) ?
                    trim($fields[$key]) : '';
            }

            $this->entity_data['me']['LID'] = !empty($fields['LID']) ?
                substr(trim($fields['LID']), 0, 2) : '';

            $this->entity_data['me']['SORT'] = static::DEFAULT_SORT;
            $sort = !empty($fields['SORT']) ? (int)$fields['SORT'] : 0;
            if (0 < $sort) {
                $this->entity_data['me']['SORT'] = $sort;
            }
        }
    }
}
