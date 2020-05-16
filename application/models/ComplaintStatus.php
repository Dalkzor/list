<?php

namespace models;

/**
 * @Entity
 * @Table(name="complaint_status")
 */
class ComplaintStatus
{
    const KEY_ID = 'id';
    const KEY_TITLE = 'title';

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
     * @return array|null
     * @throws \Exception
     */
    public static function getComplaintStatus()
    {
        return get_instance()->doctrine->em->getRepository('models\ComplaintStatus')->findAll();
    }

    /**
     * @param $id
     * @return object
     * @throws \Exception
     */
    public static function getComplaintStatusId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\ComplaintStatus')->findOneBy([self::KEY_ID => $id]);
    }
}