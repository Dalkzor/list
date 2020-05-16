<?php

namespace models;

/**
 * @Entity
 * @Table(name="client")
 */
class Client
{
    const KEY_ID = 'id';
    const KEY_PHONE = 'phone';
    const KEY_LAST_NAME = 'last_name';
    const KEY_FIRST_NAME = 'first_name';
    const KEY_MIDDLE_NAME = 'middle_name';
    const KEY_CREATE_DATE = "create_date";
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
     * @Column(type="string", name="phone", length=15, unique=true, nullable=true)
     */
    protected $phone;

    /**
     * @var string|null
     * @Column(type="string", name="last_name", length=60, unique=false, nullable=true)
     */
    protected $lastName;

    /**
     * @var string|null
     * @Column(type="string", name="first_name", length=60, unique=false, nullable=true)
     */
    protected $firstName;

    /**
     * @var string|null
     * @Column(type="string", name="middle_name", length=60, unique=false, nullable=true)
     */
    protected $middleName;

    /**
     * @Column(type="datetime", name="create_date", nullable=false)
     */
    protected $createDate;

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
     * @return string|null
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName() {
        return $this->middleName;
    }

    /**
     * @param string|null $middleName
     */
    public function setMiddleName($middleName) {
        $this->middleName = $middleName;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
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
    public static function getClients()
    {
        return get_instance()->doctrine->em->getRepository('models\Client')->findAll();
    }

    /**
     * @param int $id
     * @return object
     * @throws \Exception
     */
    public static function getClientId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Client')->findOneBy([self::KEY_ID => $id]);
    }


    /**
     * @param $id
     * @param $phone
     * @return array
     */
    public static function checkEditPhone($id, $phone)
    {
        $ci = &get_instance()->doctrine->em;
        $qb = $ci->createQueryBuilder();
        $qb->select('c')
            ->from('models\Client', 'c')
            ->where('c.id != :id')
            ->andWhere('c.phone = :phone')
            ->setParameter('id', $id)
            ->setParameter('phone', $phone);
        return $qb->getQuery()->getResult();
    }


    /**
     * Saving Client
     * @param $params
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function addClientAndReturnResult($params)
    {
        $ci = &get_instance()->doctrine->em;
        $addClient = new Client();
        $addClient->setPhone($params[self::KEY_PHONE]);
        $addClient->setLastName($params[self::KEY_LAST_NAME]);
        $addClient->setFirstName($params[self::KEY_FIRST_NAME]);
        $addClient->setMiddleName($params[self::KEY_MIDDLE_NAME]);
        $addClient->setCreateDate(new \DateTime());
        $ci->persist($addClient);
        $ci->flush();

        // Отдаём клиента которого записал в базу
        return self::toArray($addClient);
    }


    /**
     * Edit Client
     * @param $params
     * @return object
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function editClientAndReturnResult($params)
    {
        $ci = &get_instance()->doctrine->em;
        $editClient = self::getClientId($params[self::KEY_ID]);
        $editClient->setPhone($params[self::KEY_PHONE]);
        $editClient->setLastName($params[self::KEY_LAST_NAME]);
        $editClient->setFirstName($params[self::KEY_FIRST_NAME]);
        $editClient->setMiddleName($params[self::KEY_MIDDLE_NAME]);
        $ci->persist($editClient);
        $ci->flush();

        // Отдаём клиента которого отредактировали в базе
        return self::toArray($editClient);
    }


    /**
     * @param object $params
     * @return array|mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function toArray($params)
    {
        // Переводим объект в массив
        return array(
            self::KEY_ID => $params->id,
            self::KEY_PHONE => $params->phone,
            self::KEY_LAST_NAME => $params->lastName,
            self::KEY_FIRST_NAME => $params->firstName,
            self::KEY_MIDDLE_NAME => $params->middleName,
            self::KEY_CREATE_DATE => $params->getCreateDate()->format('Y-m-d H:i'),
        );
    }

}
