<?php
namespace models;

/**
 * @Entity
 * @Table(name="migration", indexes={ @Index(columns={"`key`"}) })
 */
Class Migration {

    /**
     * @Id
     * @Column(type="string", name="`key`", length=255, unique=true, nullable=false)
     */
    protected $key;

    /**
     * @Column(type="string", name="`value`", length=255, nullable=false)
     */
    protected $value;

    /**
     * @Column(type="string", name="`type`", length=255, nullable=false)
     */
    protected $type;


    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function save()
    {
        $ci = & get_instance();
        $ci->doctrine->em->persist($this);
        $ci->doctrine->em->flush();
    }
}