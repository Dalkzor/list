<?php

namespace models;

/**
 * @Entity
 * @Table(name="office")
 */
class Office
{
    const KEY_ID = 'id';
    const KEY_NAME = 'name';
    const KEY_DELETED = 'deleted';
    const KEY_OFFICE = 'office';
    const KEY_OFFICE_NAME = 'office_name';

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string|null
     * @Column(type="string", name="name", length=255, unique=false, nullable=true)
     */
    protected $name;

    /**
     * @var bool
     * @Column(type="boolean", name="deleted", nullable=false)
     */
    protected $deleted = FALSE;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function getDeleted() {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }


    /**
     * @return array|null
     * @throws \Exception
     */
    public static function getOffices()
    {
        return get_instance()->doctrine->em->getRepository('models\Office')->findAll();
    }

    /**
     * @param $id
     * @return object
     * @throws \Exception
     */
    public static function getOfficeId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Office')->findOneBy([self::KEY_ID => $id]);
    }
}