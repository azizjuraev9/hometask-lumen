<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 4:27
 */

namespace App\verification\repositories;


use App\Models\Verification as TableModel;
use App\verification\models\Verification;

class VerificationRepository implements IVerificationRepository
{

    public function hasPendingVerification(array $subjectData): bool
    {
        return TableModel::where('subject->identity', $subjectData['identity'])
            ->where('subject->type', $subjectData['type'])
            ->where('confirmed', false)
            ->where('expiresAt', '>', time())->exists();
    }

    public function saveVerification(Verification $verification): bool
    {
        $model = new TableModel();
        $model->id = $verification->getId();
        $model->subject = json_encode($verification->getSubject());
        $model->confirmed = $verification->getConfirmed();
        $model->expiresAt = $verification->getExpiresAt();
        $model->code = $verification->getCode();
        $model->userInfo = json_encode($verification->getUserInfo());
        $model->attempts = $verification->getAttempts();
        return $model->save();
    }

    public function updateVerification(Verification $verification): bool
    {
        $model = TableModel::where('id',$verification->getId())->first();
        $model->id = $verification->getId();
        $model->subject = json_encode($verification->getSubject());
        $model->confirmed = $verification->getConfirmed();
        $model->expiresAt = $verification->getExpiresAt();
        $model->code = $verification->getCode();
        $model->userInfo = json_encode($verification->getUserInfo());
        $model->attempts = $verification->getAttempts();
        return $model->save();
    }

    public function getById(string $id) : Verification|null
    {
        $model = TableModel::where('id',$id)->first();
        if(!$model){
            return null;
        }

        $verification = new Verification();
        $verification->init([
            'id' => $model->id,
            'subjectData' => json_decode($model->subject,true),
            'confirmed' => $model->confirmed,
            'expiresAt' => $model->expiresAt,
            'code' => $model->code,
            'userInfo' =>  json_decode($model->userInfo,true),
            'attempts' =>  $model->attempts,
        ]);
        return $verification;
    }

}
