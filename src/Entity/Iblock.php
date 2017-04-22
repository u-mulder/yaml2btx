<?php
/**
 * Entity which creates code for iblock adding
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

class Iblock extends AbstractEntity
{

    /**
     * @var string Detail url by default
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const IBLOCK_DETAIL_URL = 'detail.php';

    /**
     * @var string List url by default
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const IBLOCK_LIST_URL = 'index.php';

    /**
     * @var string Section url by default
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const IBLOCK_SECTION_URL = 'section.php';

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
     * @var string Blade template name
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const TEMPLATE_NAME = 'iblock';

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

            $keys = ['TYPE', 'CODE', 'NAME'];
            foreach ($keys as $key) {
                $this->entity_data['ib'][$key] = !empty($fields[$key]) ?
                    trim($fields[$key]) : '';
            }

            $this->entity_data['ib']['ACTIVE'] =
                !empty($fields['ACTIVE']) && $this->isNoValue($fields['ACTIVE']) ?
                self::VALUE_N : self::VALUE_Y;

            $sort = !empty($fields['SORT']) ?
                (int)$fields['SORT'] : self::DEFAULT_SORT;
            $this->entity_data['ib']['SORT'] = 0 < $sort? $sort : self::DEFAULT_SORT;

            $urls = [
                'SECTION_PAGE_URL' => static::IBLOCK_SECTION_URL,
                'LIST_PAGE_URL' => static::IBLOCK_LIST_URL,
                'DETAIL_PAGE_URL' => static::IBLOCK_DETAIL_URL,
            ];
            foreach ($urls as $k => $v) {
                $url = !empty($fields[$k]) ? trim($fields[$k]) : '';
                $this->entity_data['ib'][$k] =
                    $url ?: static::SITE_DIR_MACRO . $v;
            }

            $this->entity_data['ib']['DESCRIPTION'] = !empty($fields['DESCRIPTION']) ?
                trim($fields['DESCRIPTION']) : '';

            $desc_type =
                !empty($fields['DESC_TYPE']) && self::DESC_TYPE_HTML == $fields['DESC_TYPE'] ?
                self::DESC_TYPE_HTML : self::DESC_TYPE_TEXT;
            $this->entity_data['ib']['DESC_TYPE'] = $desc_type;

            $this->entity_data['ib']['XML_ID'] = !empty($fields['XML_ID']) ?
                trim($fields['XML_ID']) : '';

            $this->entity_data['ib']['INDEX_ELEMENT'] =
                !empty($fields['INDEX_ELEMENT']) && $this->isYesValue($fields['INDEX_ELEMENT']) ?
                self::VALUE_Y : self::VALUE_N;

            $this->entity_data['ib']['INDEX_SECTION'] =
                !empty($fields['INDEX_SECTION']) && $this->isYesValue($fields['INDEX_SECTION']) ?
                self::VALUE_Y : self::VALUE_N;

            $version = !empty($fields['VERSION']) ?
                (int)$fields['VERSION'] : self::IBLOCK_VERSION_DEFAULT;
            $this->entity_data['ib']['VERSION'] = $version == self::IBLOCK_VERSION_DEFAULT?
                self::IBLOCK_VERSION_DEFAULT : self::IBLOCK_VERSION_ONE;
        }
    }
}
