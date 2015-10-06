<?php
namespace AnnotationValidator;

use Webiny\Component\Annotations\AnnotationsTrait;

/**
 * Short description for file 
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class Mapper
{
    const ANNOTATION_ALIAS = 'VLD';

    use AnnotationsTrait;

    /**
     * @var \ReflectionClass
     */
    protected $entityReflectionClass;

    /**
     * @var string
     */
    protected $currentClass;

    /**
     * @var array
     */
    protected $validationMap = array();

    /**
     * @var \Zend\Cache\Storage\StorageInterface
     */
    public static $cacheAdapter;

    /**
     * Validation aliases declared in module configuration
     *
     * @var array
     */
    public static $aliases;

    public function __construct($entityClass)
    {
        $this->currentClass = $entityClass;
        $this->entityReflectionClass = new \ReflectionClass($entityClass);
    }

    /**
     * Return validation map.
     * Checks first if validation map
     * already exists in Cache
     *
     * @return array
     */
    public function getValidationMap()
    {
        $cacheAdapter = self::$cacheAdapter;
        $cacheKey = str_replace('\\', '', $this->currentClass) . 'AVS';

        // TODO Cache disable based on configuration or environment
        if (!$cacheAdapter->hasItem($cacheKey)) {
            $this->setPropertiesToValidate();
            $cacheAdapter->setItem($cacheKey, $this->validationMap);
       }

        return $cacheAdapter->getItem($cacheKey);
    }

    /**
     * Creates Validation Map
     *
     * @return Mapper
     */
    protected function setPropertiesToValidate()
    {
        $properties = $this->entityReflectionClass->getProperties();

        foreach ($properties as $property) {

            $validationAnnotation = $this->annotationsFromProperty($this->currentClass, $property->name)->get(self::ANNOTATION_ALIAS);

            if ($validationAnnotation) {

                if (is_a($validationAnnotation, 'Webiny\Component\Config\ConfigObject')) {
                    foreach ($validationAnnotation->toArray() as $validationAnnotationItem) {
                        $this->validationMap[$property->name][] = $this->manipulateValidationRule(json_decode($validationAnnotationItem, true));
                    }
                    return $this;
                }

                $this->validationMap[$property->name][] = $this->manipulateValidationRule(json_decode($validationAnnotation, true));
            }
        }

        return $this;
    }

    /**
     * Returns an array of type
     * [
     *  'validation_class' => '...',
     *  'validation_options' => '...'
     * ]
     *
     * @param $validationAnnotation
     * @return array
     */
    protected function manipulateValidationRule($validationAnnotation)
    {
        // TODO Check for same values in different entities (status)
        $aliases = self::$aliases;
        $alias = $validationAnnotation['type'];

        $configurationValidationOptions =
            isset($aliases[$alias]['validation_options']) ? $aliases[$alias]['validation_options'] : null;

        $validationClass = $aliases[$alias]['validation_class'];

        $validationRule['validation_class'] = $validationClass;
        $validationRule['validation_options'] = isset($validationAnnotation['options']) ? $validationAnnotation['options'] : $configurationValidationOptions;

        // Not Required for null value
        if (strpos($alias, 'NotRequired') !== false)
            $validationRule['validation_not_required'] = true;
        return $validationRule;
    }
}
