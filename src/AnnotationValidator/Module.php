<?php
namespace AnnotationValidator;

use Doctrine\Common\Annotations\AnnotationReader;
use Zend\EventManager\Event;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Short description for file 
 *
 * @category   CategoryName
 * @package    validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, InitProviderInterface
{
    public function onBootstrap(Event $e)
    {
        $application = $e->getApplication();
        $serviceManager    = $application->getServiceManager();
        $this->setCacheAdapterToMapper($serviceManager);
    }

    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $moduleManager
     * @return void
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        $events = $moduleManager->getEventManager();
        $events->attach('loadModules.post', array($this, 'disableValidatorAnnotationForDoctrine'));
    }

    public function disableValidatorAnnotationForDoctrine(Event $e)
    {
        if (class_exists('Doctrine\Common\Annotations\AnnotationReader')) {
            $moduleManager = $e->getTarget();
            $config = $moduleManager->getModule('AnnotationValidator')->getConfig();
            AnnotationReader::addGlobalIgnoredName($config['validator_annotation']);
        }
    }

    protected function setCacheAdapterToMapper(ServiceManager $serviceManager)
    {
        Mapper::$cacheAdapter = $serviceManager->get('ValidatorCacheAdapter');
        Mapper::$aliases = $serviceManager->get('Config')['validation_classes_aliases'];
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array (
            'Zend\Loader\StandardAutoloader' => array (
                'namespaces' => array (
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                )
            )
        );
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
