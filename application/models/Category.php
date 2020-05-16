<?php

namespace models;

/**
 * @Entity
 * @Table(name="category")
 */
class Category
{
    const KEY_ID = 'id';
    const KEY_SORT = 'sort';
    const KEY_URl = 'url';
    const KEY_TITLE = 'title';
    const KEY_ICONS = 'icons';
    const KEY_ROLE = 'role';
    const KEY_DELETED = 'deleted';

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var int
     * @Column(type="integer", name="sort", nullable=false)
     */
    protected $sort;

    /**
     * @var string
     * @Column(type="string", name="url", length=200, nullable=false)
     */
    protected $url;

    /**
     * @var string
     * @Column(type="string", name="title", length=200, nullable=false)
     */
    protected $title;

    /**
     * @var string
     * @Column(type="string", name="icons", length=100, nullable=false)
     */
    protected $icons;

    /**
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     **/
    protected $role;

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
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return string
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * @param string $icons
     */
    public function setIcons($icons)
    {
        $this->icons = $icons;
    }

    /**
     * @return Role|int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
    public static function getCategorys()
    {
        return get_instance()->doctrine->em->getRepository('models\Category')->findAll();
    }

    /**
     * @param $id
     * @return object
     * @throws \Exception
     */
    public static function getCategoryId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Category')->findOneBy([Category::KEY_ID => $id]);
    }

    /**
     * @return self|null
     * @throws \Exception
     */
    public static function getActiveCategories()
    {
        $ci =& get_instance();
        $qb = $ci->doctrine->em->createQueryBuilder();
        $qb->select('c', 'r')
            ->from('models\Category', 'c')
            ->leftJoin('c.role', 'r')
            ->where('c.deleted = :deleted')
            ->orderBy('c.sort')
            ->setParameter(Category::KEY_DELETED, 0);
        return $qb->getQuery()->getResult();
    }

}