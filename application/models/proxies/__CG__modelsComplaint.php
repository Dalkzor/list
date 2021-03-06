<?php

namespace DoctrineProxies\__CG__\models;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Complaint extends \models\Complaint implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'complaintType', 'complaintStatus', 'operator', 'client', 'office', 'description', 'result', 'reason', 'createDate', 'deleted', 'assocComplaintsOperators');
        }

        return array('__isInitialized__', 'id', 'complaintType', 'complaintStatus', 'operator', 'client', 'office', 'description', 'result', 'reason', 'createDate', 'deleted', 'assocComplaintsOperators');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Complaint $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getComplaintType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComplaintType', array());

        return parent::getComplaintType();
    }

    /**
     * {@inheritDoc}
     */
    public function setComplaintType($complaintType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComplaintType', array($complaintType));

        return parent::setComplaintType($complaintType);
    }

    /**
     * {@inheritDoc}
     */
    public function getComplaintStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComplaintStatus', array());

        return parent::getComplaintStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setComplaintStatus($complaintStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComplaintStatus', array($complaintStatus));

        return parent::setComplaintStatus($complaintStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getOperator()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOperator', array());

        return parent::getOperator();
    }

    /**
     * {@inheritDoc}
     */
    public function setOperator($operator)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOperator', array($operator));

        return parent::setOperator($operator);
    }

    /**
     * {@inheritDoc}
     */
    public function getClient()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClient', array());

        return parent::getClient();
    }

    /**
     * {@inheritDoc}
     */
    public function setClient($client)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setClient', array($client));

        return parent::setClient($client);
    }

    /**
     * {@inheritDoc}
     */
    public function getOffice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOffice', array());

        return parent::getOffice();
    }

    /**
     * {@inheritDoc}
     */
    public function setOffice($office)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOffice', array($office));

        return parent::setOffice($office);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getAssocComplaintsOperators()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAssocComplaintsOperators', array());

        return parent::getAssocComplaintsOperators();
    }

    /**
     * {@inheritDoc}
     */
    public function setAssocComplaintsOperators($assocComplaintsOperators)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAssocComplaintsOperators', array($assocComplaintsOperators));

        return parent::setAssocComplaintsOperators($assocComplaintsOperators);
    }

    /**
     * {@inheritDoc}
     */
    public function getResult()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getResult', array());

        return parent::getResult();
    }

    /**
     * {@inheritDoc}
     */
    public function setResult($result)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setResult', array($result));

        return parent::setResult($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getReason()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReason', array());

        return parent::getReason();
    }

    /**
     * {@inheritDoc}
     */
    public function setReason($reason)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReason', array($reason));

        return parent::setReason($reason);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateDate', array());

        return parent::getCreateDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateDate($createDate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateDate', array($createDate));

        return parent::setCreateDate($createDate);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeleted()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeleted', array());

        return parent::getDeleted();
    }

    /**
     * {@inheritDoc}
     */
    public function setDeleted($deleted)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeleted', array($deleted));

        return parent::setDeleted($deleted);
    }

    /**
     * {@inheritDoc}
     */
    public function clearComplaintsOperators()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'clearComplaintsOperators', array());

        return parent::clearComplaintsOperators();
    }

}
