<?php

namespace App\verification\models;

interface IVerification
{
    public function init(array $data) : void;

    public function createNew(array $subjectData, array $userInfo) : void;

    public function confirmVerification($code,$userInfo) : void;

    public function getId() : string;

    public function getSubject() : Subject;

    public function getConfirmed() : bool;

    public function getExpiresAt() : int;

    public function getCode() : int;

    public function getUserInfo() : array;

    public function getAttempts() : int;
}
