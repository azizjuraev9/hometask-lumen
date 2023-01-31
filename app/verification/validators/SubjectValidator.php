<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 6:24
 */

namespace App\verification\validators;


use App\verification\exceptions\InvalidSubjectException;
use App\verification\models\Subject;
use Illuminate\Support\Facades\Validator;

class SubjectValidator
{

    public function validateSubject(Subject $subject): void
    {
        $rule = '';
        if ($subject->type === 'email_confirmation') {
            $rule = 'required|email';
        } elseif ($subject->type === 'mobile_confirmation') {
            $rule = 'required|regex:/^([0-9\+]*)$/|min:10';
        } else {
            throw new InvalidSubjectException();
        }

        $validator = Validator::make((array)$subject, [
            'identity' => $rule,
        ]);

        if ($validator->fails()) {
            throw new InvalidSubjectException();
        }
    }

}
