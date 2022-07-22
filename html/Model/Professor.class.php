<?php

namespace App\Model;

use App\Core\QueryBuilder;
use App\Model\User;

class Professor extends User {

    private int $cv;
    private int $motivation;

    /**
     * @return int
     */
    public function getCv(): int
    {
        return $this->cv;
    }

    /**
     * @param int $cv
     */
    public function setCv(int $cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return int
     */
    public function getMotivation(): int
    {
        return $this->motivation;
    }


    public function motivation(): File
    {

    }

    public function getWithMotivationAndCV()
    {
        $query = new QueryBuilder();
        return  $query->select('')
            ->from('user')
            ->innerJoin('file', DBPREFIXE.'user.motivation ='.DBPREFIXE.'file.id')
            ->where('motivation = :motivation')
            ->setParams([
                'motivation' => $this->motivation,
            ])
            ->fetchAllByClass(__CLASS__);
    }

    /**
     * @param int $motivation
     */
    public function setMotivation(int $motivation): void
    {
        $this->motivation = $motivation;
    }


}