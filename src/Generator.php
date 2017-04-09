<?php
/**
 *
 * @author u_mulder <m264695502@gmail.com>
 */

namespace Yaml2Btx;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Yaml2Btx\ConfigFileException;
use Yaml2Btx\Entity\AbstractEntity;

class Generator
{

    /**
     * @var string Array key for storing entity type
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const ENTITY_TYPE_KEY = 'type';

    /**
     * @var string Exception message
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_EMPTY_PATH = 'Empty filepath provided';

    /**
     * @var string Exception message template
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_ENTITY_NOT_SUPPORTED = 'Entity with type "%s" is not supported';

    /**
     * @var string Exception message
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_ENTITY_UNKNOWN = 'Bad or no entity data';

    /**
     * @var string Exception message
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_NO_ENTITY = 'No entity prepared';

    /**
     * @var string Exception message template
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_NOT_EXISTS = 'Provided file "%s" not exists';

    /**
     * @var string Exception message template
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_NOT_READABLE = 'Provided file "%s" not readable';

    /**
     * @var string Exception message template
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    const EXC_PARSE_YAML = 'Fail to parse provided yaml: %s';

    /**
     * @var array Currently supported entities
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $allowed_entities = [
        'form' => 1,
        'iblock' => 1,
        'iblockelement' => 1,
        'iblockproperty' => 1,
        'iblocksection' => 1,
        'mailevent' => 1,
        'mailtemplate' => 1,
        'userfield' => 1,
    ];

    /**
     * @var
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    protected $entity;

    /**
     * Getting, checking and parsing content of a yaml-file, defined by $filepath
     *
     * @param string $filepath Path to yaml-description
     *
     * @throws Yaml2Btx\ConfigFileException if filepath is empty, not readable or provided yaml cannot be parsed
     *
     * @return object Instance of current class
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function parse(/*string*/ $filepath)
    {
        $filepath = trim($filepath);

        if (!file_exists($filepath)) {
            throw new ConfigFileException(sprintf(self::EXC_NOT_EXISTS, $filepath));
        }

        if (!is_readable($filepath)) {
            throw new ConfigFileException(sprintf(self::EXC_NOT_READABLE, $filepath));
        }

        try {
            $value = Yaml::parse(file_get_contents($filepath));
        } catch (ParseException $e) {
            throw new ConfigFileException(sprintf(self::EXC_PARSE_YAML, $e->getMessage()));
        }

        $this->initEntity($value);

        return $this;
    }


    /**
     * Checking and initing code generation entity
     *
     * According to {@link http://api.symfony.com/3.2/Symfony/Component/Yaml/Parser.html#method_parse}
     * Yaml::parse returns `mixed`. so argument type is not strictly defined
     *
     * @param mixed $data
     *
     * @throws \Exception In case of entity creation or if entity is not supported or empty
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function initEntity($data)
    {
        if (is_array($data) && !empty($data[static::ENTITY_TYPE_KEY])) {
            $type = $data[static::ENTITY_TYPE_KEY];
            if ($this->isAllowedEntityType($type)) {
                $entity_class = __NAMESPACE__ . '\\Entity\\' . ucfirst($type);

                /* Catch exception in your scripts */
                $this->entity = new $entity_class($data);
            } else {
                throw new \Exception(sprintf(self::EXC_ENTITY_NOT_SUPPORTED, $type));
            }
        } else {
            throw new \Exception(self::EXC_ENTITY_UNKNOWN);
        }
    }


    /**
     * Check if provided entity type is supported
     *
     * @param string $type Entity type
     *
     * @return bool
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function isAllowedEntityType(/*string*/ $type)
    {
        $type = strtolower($type);

        return isset($this->allowed_entities[$type]);
    }


    /**
     * Saving entity to destination defined by $filepath
     *
     * @param string $filepath Path to output file
     *
     * @throws Yaml2Btx\ConfigFileException If destination path is empty
     * @throws \Exception If current entity is not an instance of Yaml2Btx\AbstractEntity
     *
     * @return bool Data saved to file (true) or error(s) happen while writing (false)
     *
     * @see Yaml2Btx\AbstractEntity
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function save(/*string*/ $filepath)
    {
        $filepath = trim($filepath);

        if (!$filepath) {
            throw new ConfigFileException(self::EXC_EMPTY_PATH);
        }

        if (!($this->entity instanceof AbstractEntity)) {
            throw new \Exception(self::EXC_ENTITY_UNKNOWN);
        }

        $res = file_put_contents($filepath, $this->entity->render());

        return $res;
    }


    /**
     * // TODO later
     * Method will be completed later
     *
     * @author u_mulder <m264695502@gmail.com>
     */
    public function download()
    {
        throw new \Exception('Method ' . __METHOD__ . ' not supported yet');
    }
}
