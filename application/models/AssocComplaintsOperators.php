<?php

namespace models;

/**
 * Mapping on common table with models\Complaint::operator.
 * Use this entity for creating new relation between Complaint and Operator as operator.
 *
 * @Entity
 * @Table(name="complaints_operators")
 */
class AssocComplaintsOperators
{
    const KEY_COMPLAINT_ID = 'complaint_id';
    const KEY_OPERATOR_ID = 'operator_id';
    const KEY_DELETED = 'deleted';

    /**
     * @Id
     * @ManyToOne(targetEntity="Complaint")
     * @JoinColumn(name="complaint_id", referencedColumnName="id")
     **/
    protected $complaint;

    /**
     * @Id
     * @ManyToOne(targetEntity="Operator")
     * @JoinColumn(name="operator_id", referencedColumnName="id")
     */
    protected $operator;

    /**
     * @var bool
     * @Column(type="boolean", name="deleted", nullable=false)
     */
    protected $deleted = FALSE;


    /**
     * @return Complaint
     */
    public function getComplaint()
    {
        return $this->complaint;
    }

    /**
     * @param Complaint $complaint
     */
    public function setComplaint($complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * @return Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param Operator $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
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
     * @param array $param
     * @return object
     * @throws \Exception
     */
    public static function getAssocComplaintsOperators($param)
    {
        return get_instance()->doctrine->em->getRepository('models\AssocComplaintsOperators')->findOneBy([
            Complaint::KEY_COMPLAINT => $param[AssocComplaintsOperators::KEY_COMPLAINT_ID],
            Complaint::KEY_OPERATOR => $param[AssocComplaintsOperators::KEY_OPERATOR_ID],
        ]);
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getResponsible ($id) {
        return get_instance()->doctrine->em->getRepository('models\AssocComplaintsOperators')->findBy([
            Complaint::KEY_COMPLAINT => $id,
            self::KEY_DELETED => false,
        ]);
    }

}