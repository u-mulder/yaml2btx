<?php
/**
 * Entity which creates code for iblock adding
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

class Userfield extends AbstractEntity
{

    /**
     * @var int Default sort for SORT fields
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_SORT = 100;

    /**
     * @var string Default user type for entity
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_USER_TYPE = 'string';

    /**
     * @var string Blade template name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const TEMPLATE_NAME = 'userfield';

    /**
     * @var string Commonly used prefix for userfield's name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const UF_PREFIX = 'UF_';

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
            $fields = array_change_key_case(
                $entity_data['fields'],
                CASE_UPPER
            );

            $this->entity_data['uf']['ENTITY_ID'] = '';
            $entity_id = !empty($fields['ENTITY_ID']) ?
                trim(strtoupper($fields['ENTITY_ID'])) : '';
            if ($entity_id) {
                $this->entity_data['uf']['ENTITY_ID'] = $entity_id;
            }

            $this->entity_data['uf']['FIELD_NAME'] = '';
            $f_name = !empty($fields['FIELD_NAME']) ?
                trim(strtoupper($fields['FIELD_NAME'])) : '';
            if ($f_name) {
                $this->entity_data['uf']['FIELD_NAME'] = $this->addUfPrefix($f_name);
            }

            $this->entity_data['uf']['USER_TYPE_ID'] = static::DEFAULT_USER_TYPE;
            $u_type = !empty($fields['USER_TYPE_ID']) ?
                trim($fields['USER_TYPE_ID']) : '';
            if ($u_type) {
                $this->entity_data['uf']['USER_TYPE_ID'] = $u_type;
            }

            $this->entity_data['uf']['SORT'] = static::DEFAULT_SORT;
            $sort = !empty($fields['SORT']) ? (int)$fields['SORT'] : 0;
            if (0 < $sort) {
                $this->entity_data['uf']['SORT'] = $sort;
            }

            $yn_fields = [
                'MULTIPLE' => self::VALUE_N,
                'MANDATORY' => self::VALUE_N,
                'SHOW_IN_LIST' => self::VALUE_Y,
                'EDIT_IN_LIST' => self::VALUE_Y,
                'IS_SEARCHABLE' => self::VALUE_N,
            ];
            foreach ($yn_fields as $k => $v) {
                $value = !empty($fields[$k]) ? strtoupper(trim($fields[$k])) : $v;
                $this->entity_data['uf'][$k] = $value == self::VALUE_N ?
                    self::VALUE_N : self::VALUE_Y;
            }

            $this->entity_data['uf']['XML_ID'] = !empty($fields['XML_ID']) ?
                trim($fields['XML_ID']) : '';

            $this->entity_data['uf']['SHOW_FILTER'] = 'N';
            $filter_options = ['N' => 1, 'I' => 1, 'E' => 1, 'S' => 1];
            $filter_type = !empty($fields['SHOW_FILTER']) ?
                trim($fields['SHOW_FILTER']) : '';
            if ($filter_type && isset($filter_options[$filter_type])) {
                $this->entity_data['uf']['SHOW_FILTER'] = $filter_type;
            }

            $lang_msgs = [
                 'EDIT_FORM_LABEL',
                 'LIST_COLUMN_LABEL',
                 'LIST_FILTER_LABEL',
                 'ERROR_MESSAGE',
                 'HELP_MESSAGE',
            ];
            foreach ($lang_msgs as $v) {
                $this->entity_data['uf'][$v] = !empty($fields[$v]) && is_array($fields[$v]) ?
                    $fields[$v] : [];
            }
        }
    }


    /**
     * Add `self::UF_PREFIX` to field name if required
     *
     * @param string $str Field name
     *
     * @return string Field name prefixed with `self::UF_PREFIX` if required
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected function addUfPrefix($str)
    {
        return strpos($str, self::UF_PREFIX) === 0 ?
            $str : (self::UF_PREFIX . $str);
    }
}
