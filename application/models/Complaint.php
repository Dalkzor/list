<?php


namespace models;

use models;

/**
 * @Entity
 * @Table(name="complaint")
 */
class Complaint
{
    const KEY_ID = 'id';
    const KEY_COMPLAINT_TYPE_ID = 'complaint_type_id';
    const KEY_COMPLAINT_TYPE = 'complaint_type';
    const KEY_COMPLAINT_STATUS_ID = 'complaint_status_id';
    const KEY_COMPLAINT_STATUS = 'complaint_status';
    const KEY_OPERATOR_ID = 'operator_id';
    const KEY_OPERATOR = 'operator';
    const KEY_CLIENT_ID = 'client_id';
    const KEY_CLIENT = 'client';
    const KEY_OFFICE_ID = 'office_id';
    const KEY_DESCRIPTION = 'description';
    const KEY_RESULT = 'result';
    const KEY_REASON = 'reason';
    const KEY_CREATE_DATE = "create_date";
    const KEY_DELETED = 'deleted';
    const KEY_RESPONSIBLE = 'responsible';
    const KEY_COMPLAINT = 'complaint';

    /**
     * @var int
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var ComplaintType|int
     * @ManyToOne(targetEntity="ComplaintType")
     * @JoinColumn(name="complaint_type_id", referencedColumnName="id", nullable=false)
     **/
    protected $complaintType;

    /**
     * @var ComplaintStatus|int
     * @ManyToOne(targetEntity="ComplaintStatus")
     * @JoinColumn(name="complaint_status_id", referencedColumnName="id", nullable=true)
     */
    protected $complaintStatus;

    /**
     * @var Operator|int
     * @ManyToOne(targetEntity="Operator")
     * @JoinColumn(name="operator_id", referencedColumnName="id", nullable=false)
     **/
    protected $operator;

    /**
     * @var Client|int
     * @ManyToOne(targetEntity="Client")
     * @JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     **/
    protected $client;

    /**
     * @var Office|int
     * @ManyToOne(targetEntity="Office")
     * @JoinColumn(name="office_id", referencedColumnName="id", nullable=false)
     */
    protected $office;

    /**
     * @var string|null
     * @Column(type="text", name="description", unique=false, nullable=false)
     */
    protected $description;

    /**
     * @var string|null
     * @Column(type="text", name="result", unique=false, nullable=true)
     */
    protected $result;

    /**
     * @var string|null
     * @Column(type="text", name="reason", unique=false, nullable=true)
     */
    protected $reason;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="create_date", nullable=false)
     */
    protected $createDate;

    /**
     * @var bool
     * @Column(type="boolean", name="deleted", nullable=false)
     */
    protected $deleted = FALSE;

    /**
     * @OneToMany(targetEntity="AssocComplaintsOperators", mappedBy="complaint")
     **/
    protected $assocComplaintsOperators;


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
    public function getComplaintType()
    {
        return $this->complaintType;
    }

    /**
     * @param $complaintType
     */
    public function setComplaintType($complaintType)
    {
        $this->complaintType = $complaintType;
    }

    /**
     * @return ComplaintStatus|int
     */
    public function getComplaintStatus()
    {
        return $this->complaintStatus;
    }

    /**
     * @param $complaintStatus
     */
    public function setComplaintStatus ($complaintStatus)
    {
        $this->complaintStatus = $complaintStatus;
    }

    /**
     * @return int
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return int
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return int
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @param $office
     */
    public function setOffice($office)
    {
        $this->office = $office;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|AssocComplaintsOperators[]
     */
    public function getAssocComplaintsOperators()
    {
        return $this->assocComplaintsOperators;
    }

    /**
     * @param $assocComplaintsOperators
     */
    public function setAssocComplaintsOperators($assocComplaintsOperators)
    {
        $this->assocComplaintsOperators[] = $assocComplaintsOperators;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param $reason
     */
    public function setReason ($reason)
    {
        $this->reason = $reason;
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
    public function getDeleted()
    {
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
    public static function getComplaints()
    {
        return get_instance()->doctrine->em->getRepository('models\Complaint')->findAll();
    }

    /**
     * @param int $id
     * @return object
     * @throws \Exception
     */
    public static function getComplaintId($id)
    {
        return get_instance()->doctrine->em->getRepository('models\Complaint')->findOneBy([self::KEY_ID => $id]);
    }

    /**
     * deleted all AssocComplaintsOperators from this entity
     */
    public function clearComplaintsOperators()
    {
        $ci = &get_instance();
        foreach (AssocComplaintsOperators::getResponsible($this->getId()) as $complaintsOperators) {
            $complaintsOperators->setDeleted(true);
            $ci->doctrine->em->persist($complaintsOperators);
            $ci->doctrine->em->flush();
        }
    }

    /**
     * add new AssocComplaintsOperators from this entity
     * @param int $operatorId
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setComplaintsOperators($operatorId)
    {
        $ci = &get_instance();
        $assocComplaintOperator = new AssocComplaintsOperators();
        $assocComplaintOperator->setComplaint($this);
        $assocComplaintOperator->setOperator(Operator::getOperatorId($operatorId));
        $ci->doctrine->em->persist($assocComplaintOperator);
        $ci->doctrine->em->flush();
    }

    /*
     * @return mixed
     * @throws \Exception
     */
    /*public static function getComplaintsForTheCurrentDay()
    {
        $ci = &get_instance();
        $qb = $ci->doctrine->em->createQueryBuilder();
        $qb->select('c', 'aco')
            ->from('models\Complaint', 'c')
            ->leftJoin('c.assocComplaintsOperators', 'aco')
            ->where('c.deleted = :deleted')
            ->andWhere($qb->expr()->between('c.createDate',':date_from',':date_to'))
            ->orWhere('c.result = :result')
            ->andWhere('aco.deleted = :deleted')
            ->orWhere('aco.complaint IS NULL AND c.result = :result')
            ->setParameter('date_from', new \DateTime(date('Y-m-d 00:00:00')))
            ->setParameter('date_to', new \DateTime(date('Y-m-d 23:59:59')))
            ->setParameter(self::KEY_RESULT, '')
            ->setParameter(self::KEY_DELETED, 0)
            ->orderBy('c.createDate', 'DESC');
        //return $qb->getQuery()->getSQL();
        return $qb->getQuery()->getResult();
    }*/

    /**
     * @param $params
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public static function addComplaintAndReturnResult($params)
    {
        $ci = &get_instance();
        $addComplaint = new Complaint();
        $addComplaint->setComplaintType(ComplaintType::getComplaintTypeId($params[self::KEY_COMPLAINT_TYPE_ID]));
        $addComplaint->setComplaintStatus(ComplaintStatus::getComplaintStatusId($params[self::KEY_COMPLAINT_STATUS_ID]));
        $addComplaint->setOperator(Operator::getOperatorId($ci->session->userdata(Operator::KEY_ID)));
        $addComplaint->setClient(Client::getClientId($params[self::KEY_CLIENT_ID]));
        $addComplaint->setOffice(Office::getOfficeId($params[self::KEY_OFFICE_ID]));
        $addComplaint->setDescription($params[self::KEY_DESCRIPTION]);
        $addComplaint->setResult($params[self::KEY_RESULT]);
        $addComplaint->setReason($params[self::KEY_REASON]);
        $addComplaint->setCreateDate(new \DateTime());
        $ci->doctrine->em->persist($addComplaint);
        $ci->doctrine->em->flush();

        foreach ($params['operators'] as $operatorId) {
            $addComplaint->setComplaintsOperators($operatorId);
        }

        // Получаем жалобу которую записали в базу
        return self::getFullComplaint($addComplaint->id);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public static function editComplaintAndReturnResult($params)
    {
        $ci = &get_instance();
        $editComplaint = self::getComplaintId($params[self::KEY_ID]);
        $editComplaint->setComplaintType(ComplaintType::getComplaintTypeId($params[self::KEY_COMPLAINT_TYPE_ID]));
        $editComplaint->setComplaintStatus(ComplaintStatus::getComplaintStatusId($params[self::KEY_COMPLAINT_STATUS_ID]));
        $editComplaint->setClient(Client::getClientId($params[self::KEY_CLIENT_ID]));
        $editComplaint->setOffice(Office::getOfficeId($params[self::KEY_OFFICE_ID]));
        $editComplaint->setDescription($params[self::KEY_DESCRIPTION]);
        $editComplaint->setResult($params[self::KEY_RESULT]);
        $editComplaint->setReason($params[self::KEY_REASON]);
        $ci->doctrine->em->persist($editComplaint);
        $ci->doctrine->em->flush();

        $editComplaint->clearComplaintsOperators();

        foreach ($params['operators'] as $operatorId) {
            $editAssocComplaintOperator = AssocComplaintsOperators::getAssocComplaintsOperators(array(
                AssocComplaintsOperators::KEY_COMPLAINT_ID => $editComplaint->getId(),
                AssocComplaintsOperators::KEY_OPERATOR_ID => $operatorId,
            ));
            if (isset($editAssocComplaintOperator)) {
                $editAssocComplaintOperator->setDeleted(false);
                $ci->doctrine->em->persist($editAssocComplaintOperator);
                $ci->doctrine->em->flush();
            } else {
                $editComplaint->setComplaintsOperators($operatorId);
            }
        }

        // Получаем жалобу которую записали в базу
        return self::getFullComplaint($params[self::KEY_ID]);
    }

    /**
     * @param int $id
     * @param array $params
     * @return object|mixed
     * @throws \Exception
     */
    public static function getFullComplaint($id = null, $params = null)
    {
        $ci = &get_instance();
        $qb = $ci->doctrine->em->createQueryBuilder();
        $qb->select('c', 'aco')
            ->from('models\Complaint', 'c')
            ->leftJoin('c.assocComplaintsOperators', 'aco')
            ->where('c.deleted = :deleted');
        if (isset($params['date-from']) && isset($params['date-to']) || (!isset($id) && !isset($params))) {
            $qb->andWhere($qb->expr()->between('c.createDate',':date_from',':date_to'))
               ->setParameter('date_from', new \DateTime($params['date-from'] ? $params['date-from'] : date('Y-m-d 00:00:00')))
               ->setParameter('date_to', new \DateTime($params['date-to'] ? $params['date-to'] : date('Y-m-d 23:59:59')));
        }
        if (!isset($params) && !isset($id)) {
            $qb->orWhere('c.result = :result');
        }
        $qb->andWhere('aco.deleted = :deleted');
        if (!isset($params) && !isset($id)) {
            $qb->orWhere('aco.complaint IS NULL AND c.result = :result')
               ->setParameter(self::KEY_RESULT, '');
        }
        if (isset($id)) {
            $qb->andWhere('c.id = :id')
               ->setParameter('id', $id);
        }
        if (isset($params['office'])) {
            $qb->andWhere('c.office = :office')
               ->setParameter('office', Office::getOfficeId($params['office']));
        }
        if (isset($params['client'])) {
            $qb->andWhere('c.client = :client')
               ->setParameter('client', Client::getClientId($params['client']));
        }
        if (isset($params['complaint-type'])) {
            $qb->andWhere('c.complaintType = :complaint_type')
               ->setParameter('complaint_type', ComplaintType::getComplaintTypeId($params['complaint-type']));
        }
        if (isset($params['complaint-status'])) {
            $qb->andWhere('c.complaintStatus = :complaint_status')
               ->setParameter('complaint_status', ComplaintStatus::getComplaintStatusId($params['complaint-status']));
        }
        if (isset($params['operator'])) {
            $qb->andWhere('c.operator = :operator')
               ->setParameter('operator', Operator::getOperatorId($params['operator']));
        }
        $qb->orderBy('c.createDate', 'DESC')
           ->setParameter(self::KEY_DELETED, false);
        return $qb->getQuery()->getResult();

        /*$pdo = get_instance()->doctrine->em->getConnection();
        $sql = "SELECT
                    c.id
                    ,ct.title AS complaint_type
                    ,cs.title AS complaint_status
                    ,(CONCAT(IFNULL(o.`last_name`,''),' ',IFNULL(o.`first_name`,''),' ',IFNULL(o.`middle_name`,''))) AS operator
                    ,(CONCAT(IFNULL(cl.`last_name`,''),' ',IFNULL(cl.`first_name`,''),' ',IFNULL(cl.`middle_name`,''))) AS client
                    ,cl.phone
                    ,of.`name` AS office
                    ,c.office_id
                    ,c.description
                    ,c.result
                    ,c.reason
                    ,DATE_FORMAT(c.create_date, '%Y-%m-%d %H:%i') AS create_date
                    ,(SELECT
                        GROUP_CONCAT(
                            CONCAT(IFNULL(o.last_name,''),' ',IFNULL(o.first_name,''),' ',IFNULL(o.middle_name,''))
                        )
                    FROM complaints_operators co
                    LEFT JOIN operator o ON  o.id = co.operator_id
                    WHERE co.complaint_id = c.id
                    AND co.deleted = 0
                    ) AS responsible
                FROM `complaint` c
                LEFT JOIN complaint_type ct ON ct.id = c.complaint_type_id
                LEFT JOIN complaint_status cs ON cs.id = c.complaint_status_id
                LEFT JOIN operator o ON o.id = c.operator_id
                LEFT JOIN client cl ON cl.id = c.client_id
                LEFT JOIN office of ON of.id = c.office_id
                WHERE
                    c.deleted = 0";

        $paramsQuery = [];
        if (isset($id)) {
            $sql .= " AND c.id = :id";
            $paramsQuery[':id'] = $id;
        }
        if (isset($params['date-from']) && isset($params['date-to'])) {
            $sql .= " AND c.create_date BETWEEN :date_from AND :date_to";
            $paramsQuery[':date_from'] = $params['date-from'];
            $paramsQuery[':date_to'] = $params['date-to'];
        }
        if (isset($params['office'])) {
            $sql .= " AND c.office_id = :office";
            $paramsQuery[':office'] = $params['office'];
        }
        if (isset($params['client'])) {
            $sql .= " AND c.client_id = :client";
            $paramsQuery[':client'] = $params['client'];
        }
        if (isset($params['complaint-type'])) {
            $sql .= " AND c.complaint_type_id = :complaint_type";
            $paramsQuery[':complaint_type'] = $params['complaint-type'];
        }
        if (isset($params['complaint-status'])) {
            $sql .= " AND c.complaint_status_id = :complaint_status";
            $paramsQuery[':complaint_status'] = $params['complaint-status'];
        }
        if (isset($params['operator'])) {
            $sql .= " AND c.operator_id = :operator";
            $paramsQuery[':operator'] = $params['operator'];
        }
        if (!isset($params) && !isset($id)) {
            $sql .= " AND c.result = ''";
        }

        $complaint = $pdo->prepare($sql);
        foreach ($paramsQuery as $k => $v) {
            $complaint->bindValue($k, $v);
        }
        $complaint->execute();
        return $complaint->fetchAll();
        //return isset($params) ? $complaint->fetchAll() : $complaint->fetch();
        */
    }

    /**
     * @param $params
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public static function deletedComplaint($params)
    {
        $ci = &get_instance();
        $deletedComplaint = self::getComplaintId($params[self::KEY_ID]);
        $deletedComplaint->setDeleted(true);
        $ci->doctrine->em->persist($deletedComplaint);
        $ci->doctrine->em->flush();

        if (self::getComplaintId($params[self::KEY_ID])->getDeleted()) {
            return \InfoCode::SUCCESS_DELETED;
        } else {
            return \InfoCode::FAILED_DELETED;
        }
    }


    /**
     * @param object $params
     * @return array|mixed
     */
    public static function toArray($params)
    {
        // Переводим объект в массив
        $res = array();
        foreach ($params as $key => $complaint){
            $res[$key][self::KEY_ID] = $complaint->getId();
            $res[$key][self::KEY_CREATE_DATE] = $complaint->getCreateDate()->format('Y-m-d H:i');
            $res[$key][self::KEY_OPERATOR] = trim($complaint->getOperator()->getLastName().' '.
                $complaint->getOperator()->getFirstName().' '.
                $complaint->getOperator()->getMiddleName()
            );
            $res[$key][self::KEY_CLIENT] = trim(
                $complaint->getClient()->getLastName().' '.
                $complaint->getClient()->getFirstName().' '.
                $complaint->getClient()->getLastName()
            );
            $res[$key][Client::KEY_PHONE] = $complaint->getClient()->getPhone();
            $res[$key][self::KEY_OFFICE_ID] = $complaint->getOffice()->getId();
            $res[$key][Office::KEY_OFFICE] = $complaint->getOffice()->getName();
            $res[$key][self::KEY_DESCRIPTION] = $complaint->getDescription();
            $res[$key][self::KEY_COMPLAINT_TYPE] = $complaint->getComplaintType()->getTitle();
            $res[$key][self::KEY_COMPLAINT_STATUS] = ($complaint->getComplaintStatus()) ? $complaint->getComplaintStatus()->getTitle() : '';
            $res[$key][self::KEY_RESULT] = $complaint->getResult();
            $res[$key][self::KEY_REASON] = $complaint->getReason();
            foreach ($complaint->getAssocComplaintsOperators() as $k => $responsible) {
                $res[$key][self::KEY_RESPONSIBLE][$k] = $responsible->getOperator()->getLastName() .' '.
                    $responsible->getOperator()->getFirstName() .' '.
                    $responsible->getOperator()->getMiddleName();
            }
        }
        return $res;
    }

}