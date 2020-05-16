<?php

namespace models;

/**
 * @Entity
 * @Table(name="complaint_type")
 */
class ComplaintType
{
    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const KEY_DELETED = 'deleted';

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string|null
     * @Column(type="string", name="title", length=255, unique=false, nullable=true)
     */
    protected $title;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public static function getComplaintTypes()
    {
        return get_instance()->doctrine->em->getRepository('models\ComplaintType')->findAll();
    }

    /**
     * @param $id
     * @return object
     * @throws \Exception
     */
    public static function getComplaintTypeId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\ComplaintType')->findOneBy([self::KEY_ID => $id]);
    }
}