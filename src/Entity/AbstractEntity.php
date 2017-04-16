<?php
/**
 * Abstract Entity definition
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx\Entity;

use Philo\Blade\Blade;

abstract class AbstractEntity
{

    /**
     * @var int Default sort for SORT fields
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const DEFAULT_SORT = 500;

    /**
     * @var string Common value "N" (no, false)
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const VALUE_N = 'N';

    /**
     * @var string Common value "Y" (yes, true)
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const VALUE_Y = 'Y';

    /**
     * @var mixed Entity data, usually array
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $entity_data;

    /**
     * @var object Instance of Blade template engine
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $blade_instance;

    /**
     * @var string Path to blade templates
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $tpl_path;

    /**
     * @param mixed $entity_data
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function __construct($entity_data)
    {
        $this->prepareEntity($entity_data);

        $this->tpl_path = realpath(__DIR__ . '/../../resources/views');
        $this->blade_instance = new Blade(
            $this->tpl_path,
            $this->tpl_path . '/cache'
        );
    }


    /**
     * Magic method to get oject as a string
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function __toString()
    {
        return $this->render();
    }


    /**
     * Method renders entity as a string of php code
     *
     * @return string Rendered string from blade-template
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function render()
    {
        return $this
            ->blade_instance
            ->view()
            ->make(static::TEMPLATE_NAME, $this->entity_data)
            ->render();
    }


    /**
     * Check if value can be considered YES-value
     *
     * @param mixed $value Value to check
     *
     * @return bool
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected function isYesValue($value)
    {
        return $value === true
            || $value === 'Y'
            || $value === 'y'
            || $value === 'yes';
    }


    /**
     * Method which prepares required keys for a template
     *
     * @param mixed $entity_data
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    abstract protected function prepareEntity(/*array*/ $entity_data);
}
