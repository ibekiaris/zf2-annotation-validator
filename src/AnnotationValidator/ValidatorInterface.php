<?php
namespace AnnotationValidator;

/**
 * Simple Validator Interface
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
interface ValidatorInterface
{
    public static function validate(Mapper $mapper, $currentEntity);
}
