<?php

namespace ContainerMEVdgtk;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder9fa05 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerd4559 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties6a33c = [
        
    ];

    public function getConnection()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getConnection', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getMetadataFactory', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getExpressionBuilder', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'beginTransaction', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getCache', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getCache();
    }

    public function transactional($func)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'transactional', array('func' => $func), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'wrapInTransaction', array('func' => $func), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'commit', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->commit();
    }

    public function rollback()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'rollback', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getClassMetadata', array('className' => $className), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'createQuery', array('dql' => $dql), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'createNamedQuery', array('name' => $name), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'createQueryBuilder', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'flush', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'clear', array('entityName' => $entityName), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->clear($entityName);
    }

    public function close()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'close', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->close();
    }

    public function persist($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'persist', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'remove', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'refresh', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'detach', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'merge', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getRepository', array('entityName' => $entityName), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'contains', array('entity' => $entity), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getEventManager', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getConfiguration', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'isOpen', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getUnitOfWork', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getProxyFactory', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'initializeObject', array('obj' => $obj), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'getFilters', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'isFiltersStateClean', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'hasFilters', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return $this->valueHolder9fa05->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerd4559 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder9fa05) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder9fa05 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder9fa05->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__get', ['name' => $name], $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        if (isset(self::$publicProperties6a33c[$name])) {
            return $this->valueHolder9fa05->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9fa05;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder9fa05;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9fa05;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder9fa05;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__isset', array('name' => $name), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9fa05;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder9fa05;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__unset', array('name' => $name), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9fa05;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder9fa05;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__clone', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        $this->valueHolder9fa05 = clone $this->valueHolder9fa05;
    }

    public function __sleep()
    {
        $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, '__sleep', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;

        return array('valueHolder9fa05');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerd4559 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerd4559;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerd4559 && ($this->initializerd4559->__invoke($valueHolder9fa05, $this, 'initializeProxy', array(), $this->initializerd4559) || 1) && $this->valueHolder9fa05 = $valueHolder9fa05;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder9fa05;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder9fa05;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
