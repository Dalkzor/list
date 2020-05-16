<?php

namespace models;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @Entity
 * @Table(name="operator")
 */
class Operator
{
    const KEY_ID = 'id';
    const KEY_ROLE_ID = 'role_id';
    const KEY_OFFICE_ID = 'office_id';
    const KEY_LOGIN = 'login';
    const KEY_PASSWORD = 'password';
    const KEY_PASSWORD_CHECK = 'password_check';
    const KEY_LAST_NAME = 'last_name';
    const KEY_FIRST_NAME = 'first_name';
    const KEY_MIDDLE_NAME = 'middle_name';
    const KEY_CREATE_DATE = "create_date";

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var Role|int
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     **/
    protected $role;

    /**
     * @var Office|int
     * @ManyToOne(targetEntity="Office")
     * @JoinColumn(name="office_id", referencedColumnName="id", nullable=true)
     */
    protected $office;

    /**
     * @var string
     * @Column(type="string", name="login", length=100, nullable=false)
     */
    protected $login;

    /**
     * @var string
     * @Column(type="string", name="password", length=60, nullable=false)
     */
    protected $password;

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
     * @OneToMany(targetEntity="AssocComplaintsOperators", mappedBy="operator")
     **/
    protected $assocCompaniesPersons;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Office|int
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @param Office|int $office
     */
    public function setOffice($office)
    {
        $this->office = $office;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * @return \Doctrine\Common\Collections\ArrayCollection|AssocComplaintsOperators[]
     */
    public function getAssocComplaintsOperators()
    {
        return $this->assocCompaniesPersons;
    }

    /**
     * @param $assocCompaniesPersons
     */
    public function setAssocComplaintsOperators($assocCompaniesPersons)
    {
        $this->assocCompaniesPersons[] = $assocCompaniesPersons;
    }


    /**
     * @return array|null
     * @throws \Exception
     */
    public static function getOperators()
    {
         return get_instance()->doctrine->em->getRepository('models\Operator')->findAll();
    }

    /**
     * @param int $id
     * @return object
     * @throws \Exception
     */
    public static function getOperatorId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Operator')->findOneBy([self::KEY_ID => $id]);
    }

    /**
     * @param $id
     * @param $login
     * @return array
     */
    public static function checkOperatorLogin($id, $login)
    {
        $ci = &get_instance()->doctrine->em;
        $qb = $ci->createQueryBuilder();
        $qb->select('o')
            ->from('models\Operator', 'o')
            ->where('o.id != :id')
            ->andWhere('o.login = :login')
            ->setParameter('id', $id)
            ->setParameter('login', $login);
        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $login
     * @param int $password
     * @return object|bool
     */
    public static function operatorLogin($login, $password){
        $res = get_instance()->doctrine->em->getRepository('models\Operator')->findOneBy(
            [self::KEY_LOGIN => $login]
        );

        if (!password_verify($password, $res ? $res->getPassword() : null)) {
            return false;
        }

        return $res;
    }

    /**
     * Saving Operator
     * @param $params
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function addOperatorAndReturnResult($params)
    {
        $ci = &get_instance()->doctrine->em;
        $addOperator = new Operator();
        $addOperator->setRole(Role::getRoleId($params[self::KEY_ROLE_ID]));
        $addOperator->setOffice(Office::getOfficeId($params[self::KEY_OFFICE_ID]));
        $addOperator->setLogin($params[self::KEY_LOGIN]);
        $addOperator->setPassword(password_hash($params[self::KEY_PASSWORD], PASSWORD_BCRYPT,['COST'=>12]));
        $addOperator->setLastName($params[self::KEY_LAST_NAME]);
        $addOperator->setFirstName($params[self::KEY_FIRST_NAME]);
        $addOperator->setMiddleName($params[self::KEY_MIDDLE_NAME]);
        $addOperator->setCreateDate(new \DateTime());
        $ci->persist($addOperator);
        $ci->flush();

        // Отдаём оператора которого записал в базу
        return self::toArray($addOperator);
    }


    /**
     * Edit Operator
     * @param $params
     * @return object
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function editOperatorAndReturnResult($params)
    {
        $ci = &get_instance()->doctrine->em;
        $editOperator = self::getOperatorId($params[self::KEY_ID]);
        $editOperator->setRole(Role::getRoleId($params[self::KEY_ROLE_ID]));
        $editOperator->setOffice(Office::getOfficeId($params[self::KEY_OFFICE_ID]));
        $editOperator->setLogin($params[self::KEY_LOGIN]);
        if ($params[self::KEY_PASSWORD])
            $editOperator->setPassword(password_hash($params[self::KEY_PASSWORD], PASSWORD_BCRYPT,['COST'=>12]));
        $editOperator->setLastName($params[self::KEY_LAST_NAME]);
        $editOperator->setFirstName($params[self::KEY_FIRST_NAME]);
        $editOperator->setMiddleName($params[self::KEY_MIDDLE_NAME]);
        $ci->persist($editOperator);
        $ci->flush();

        // Отдаём оператора которого отредактировали в базе
        return self::toArray($editOperator);
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
            Role::KEY_TITLE => $params->role->getTitle(),
            self::KEY_LOGIN => $params->login,
            self::KEY_LAST_NAME => $params->lastName,
            self::KEY_FIRST_NAME => $params->firstName,
            self::KEY_MIDDLE_NAME => $params->middleName,
            Office::KEY_OFFICE => $params->office ? $params->office->getName() : null,
            self::KEY_CREATE_DATE => $params->getCreateDate()->format('Y-m-d H:i'),
        );
    }

}