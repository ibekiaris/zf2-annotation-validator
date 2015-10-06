<?php
namespace AnnotationValidatorTest;
use AnnotationValidator\Mapper;

/**
 * Annotation Validation
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class MapperTest extends \PHPUnit_Framework_TestCase
{
    protected $mapper;

    public function setUp()
    {
        $this->mapper = new Mapper('\AnnotationValidatorTest\Samples\SampleEntity');
    }

    public function testGetValidationMap()
    {

    }
}
