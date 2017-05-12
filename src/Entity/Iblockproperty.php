<?php
/**
 * Entity which creates code for iblock adding
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

class Iblockproperty extends AbstractEntity
{

    /**
     * @var int Col count by default
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_COL_COUNT = 30;

    /**
     * @var string Default type for a property
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_PROPERTY_TYPE = 'S';

    /**
     * @var int Row count by default
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_ROW_COUNT = 1;

    /**
     * @var int Iblock version type
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const IBLOCK_VERSION_DEFAULT = 2;

    /**
     * @var int Iblock version type
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const IBLOCK_VERSION_ONE = 1;

    /**
     * @var string List type "Checkbox"
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const LIST_TYPE_CHECKBOX = 'C';

    /**
     * @var string List type "List" or select
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const LIST_TYPE_LIST = 'L';

    /**
     * @var string Blade template name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const TEMPLATE_NAME = 'iblockproperty';

    /**
     * @var array Allowed property types
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $allowed_prop_types = [
        'S' => 1,
        'N' => 1,
        'L' => 1,
        'F' => 1,
        'G' => 1,
        'E' => 1,
    ];

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

            $keys = ['IBLOCK_ID', 'LINK_IBLOCK_ID'];
            foreach ($keys as $key) {
                $id = !empty($fields[$key])? (int)$fields[$key] : 0;
                $this->entity_data['ibp'][$key] = 0 < $id ? $id : 0;
            }

            $int_vals = [
                'ROW_COUNT' => self::DEFAULT_ROW_COUNT,
                'COL_COUNT' => self::DEFAULT_COL_COUNT,
                'SORT' => self::DEFAULT_SORT,
            ];
            foreach ($int_vals as $key => $def_val) {
                $val = !empty($fields[$key])? (int)$fields[$key] : 0;
                $this->entity_data['ibp'][$key] = 0 < $val ? $val : $def_val;
            }

            $l_type = !empty($fields['LIST_TYPE']) ?
                trim($fields['LIST_TYPE']) : self::LIST_TYPE_CHECKBOX;
            $this->entity_data['ibp']['LIST_TYPE'] = $l_type == self::LIST_TYPE_CHECKBOX ?
                self::LIST_TYPE_CHECKBOX : self::LIST_TYPE_LIST;

            $p_type = !empty($fields['PROPERTY_TYPE']) ?
                trim($fields['PROPERTY_TYPE']) : self::DEFAULT_PROPERTY_TYPE;
            if (!isset($this->allowed_prop_types[$p_type])) {
                $p_type = self::DEFAULT_PROPERTY_TYPE;
            }
            $this->entity_data['ibp']['PROPERTY_TYPE'] = $p_type;

            $yn_vals = [
                'ACTIVE' => self::VALUE_Y,
                'FILTRABLE' => self::VALUE_N,
                'IS_REQUIRED' => self::VALUE_N,
                'MULTIPLE' => self::VALUE_N,
                'SEARCHABLE' => self::VALUE_N,
                'WITH_DESCRIPTION' => self::VALUE_N,
            ];
            foreach ($yn_vals as $key => $def_val) {
                $this->entity_data['ibp'][$key] = $def_val;
                if (!empty($fields[$key])) {
                    $val = trim($fields[$key]);
                    $this->entity_data['ibp'][$key] = $this->isNoValue($val)?
                        self::VALUE_N : self::VALUE_Y;
                }
            }

            $str_vals = ['NAME', 'HINT', 'CODE', 'XML_ID', 'DEFAULT_VALUE'];
            foreach ($str_vals as $key) {
                $this->entity_data['ibp'][$key] = !empty($fields[$key]) ?
                    trim($fields[$key]) : '';
            }
        }
    }
}
