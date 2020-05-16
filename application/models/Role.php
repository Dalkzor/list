<?php

namespace models;

/**
 * @Entity
 * @Table(name="role")
 */
class Role
{
    const KEY_ID = 'id';
    const KEY_TITLE = 'title';
    const ID_BAN = 1;
    const ID_GUEST = 2;
    const ID_OPERATOR = 3;
    const ID_SENIOR_OPERATOR = 4;
    const ID_COMPLAINTS_DEPARTMENT = 5;
    const ID_WORK_WITH_REPORTS = 6;
    const ID_ADMIN = 7;

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", name="title", length=70, nullable=false)
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
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * @return array|null
     * @throws \Exception
     */
    public static function getRoles()
    {
        return get_instance()->doctrine->em->getRepository('models\Role')->findAll();
    }

    /**
     * @param int $id
     * @return object
     * @throws \Exception
     */
    public static function getRoleId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Role')->findOneBy([self::KEY_ID => $id]);
    }

}