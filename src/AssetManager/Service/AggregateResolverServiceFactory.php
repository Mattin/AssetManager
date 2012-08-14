<?php

namespace AssetManager\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AssetManager\Resolver\AggregateResolver;
use AssetManager\Exception;

/**
 * Factory class for AssetManagerService
 *
 * @category   AssetManager
 * @package    AssetManager
 */
class AggregateResolverServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return AggregateResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config   = $serviceLocator->get('Config');
        $config   = $config['asset_manager'];
        $resolver = new AggregateResolver();

        if (empty($config['resolvers'])) {
            return $resolver;
        }

        foreach ($config['resolvers'] as $resolverService => $priority) {
            $resolverService = $serviceLocator->get($resolverService);
            $resolver->attach($resolverService, $priority);
        }

        return $resolver;
    }
}
