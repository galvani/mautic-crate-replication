<?php


namespace MauticPlugin\CrateReplicationBundle\Config;


use Mautic\CacheBundle\Cache\Adapter\RedisTagAwareAdapter;
use Mautic\CacheBundle\Cache\CacheProvider;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

class Settings
{
    /**
     * @var RedisTagAwareAdapter
     */
    private $cache;
    /**
     * @var CoreParametersHelper
     */
    private $parametersHelper;

    /**
     * Settings constructor.
     *
     * @param CoreParametersHelper $parametersHelper
     */
    public function __construct(CoreParametersHelper $parametersHelper)
    {
//        $redisConfig->getParameter('redis')
        //mautic.helper.core_parameters
        $this->parametersHelper = $parametersHelper;
    }

    public function getCacheNamespace(): string {
        return 'integration.crate';
    }
    public function getReplicationQueueCachePath():string {
        return 'replication.inbox';
    }

    public function getSchemaName() {
        $crateParameters = $this->parametersHelper->getParameter('crate');
        var_dump(explode('/',$crateParameters));
        die();
    }

    public function getCache(): RedisTagAwareAdapter {
        if (null===$this->cache) {
                $this->cache = new RedisTagAwareAdapter(
                    $this->parametersHelper->getParameter('redis'),
                    $this->getCacheNamespace(),
                    0   //  Eternity
                );
        }
        return $this->cache;
    }

    public function getMessenger() {

    }
}