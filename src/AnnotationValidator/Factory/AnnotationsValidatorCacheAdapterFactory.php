<?php
namespace AnnotationValidator\Factory;

use Zend\Cache\StorageFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * This is a Factory that creates
 * as Zend service manager service
 * a cache adapter as defined into
 * module's configuration file
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class AnnotationsValidatorCacheAdapterFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $cacheAdapterConfiguration = $config['validation_cache_adapter'];
        $cache = StorageFactory::factory($cacheAdapterConfiguration);

        return $cache;
    }
}
