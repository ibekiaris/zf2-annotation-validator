<?php
namespace AnnotationValidator;

/**
 * Validate trait's class properties
 * using Zend Validator Classes
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class ZendValidator implements ValidatorInterface
{
    public static function validate(Mapper $mapper, $currentEntity)
    {
        $validationMap = $mapper->getValidationMap();
        return self::validateCurrentEntity($validationMap, $currentEntity);
    }

    protected static function validateCurrentEntity($validationMap, $currentEntity)
    {
        $validationErrors = array();

        foreach ($validationMap as $fieldName => $fieldValidationArray) {
            $currentFieldValue = $currentEntity->{$fieldName};

            foreach ($fieldValidationArray as $key => $validationRule) {

                $validationClass = $validationRule['validation_class'];
                $validationOptions = $validationRule['validation_options'];

                $validationNotRequired = isset($validationRule['validation_not_required']);

                $acceptNull = empty($currentFieldValue) && $validationNotRequired;
                $validator = new $validationClass($validationOptions);

                /**
                 * There is no need to validate not required null values
                 */
                if (!$validator->isValid($currentFieldValue) && !$acceptNull) {
                    $validationErrors[$fieldName][$key]['error_messages'] = $validator->getMessages();
                }
            }
        }

        return $validationErrors;
    }
}
