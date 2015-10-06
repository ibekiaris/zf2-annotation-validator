<?php
namespace AnnotationValidator;

use Doctrine\ORM\Mapping as ORM;

/**
 * This is a Validation Class
 * that uses properties annotations
 * in order to validate them
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
trait DoctrineValidatorTrait
{
    /**
     * @throws ValidatorException
     * @ORM\PreFlush
     */
    public function validate()
    {
        $mapper = new Mapper(__CLASS__);
        $validationErrors = ZendValidator::validate($mapper, $this);

        if (count($validationErrors)) {
            throw new ValidatorException($validationErrors);
        }
    }

    public function __get($field)
    {
        return $this->$field;
    }
}