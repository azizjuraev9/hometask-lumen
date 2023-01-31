<?php
/**
 * Created by PhpStorm.
 * User: Aziz Juraev
 * Date: 31.01.2023
 * Time: 9:27
 */

namespace App\Http\Controllers;


use App\verification\exceptions\VerificationException;
use App\verification\services\IVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{

    public function __construct(
        public IVerificationService $verificationService
    )
    {
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject.identity' => 'required|string',
            'subject.type' => 'required|string',
        ]);

        if ($validator->fails() || !$request->isJson()) {
            return response('', 400);
        }

        try {
            return response()->json([
                'id' => $this->verificationService->createVerification($request->get('subject'), [
                    'IP' => $request->getClientIp(),
                    'agent' => $request->userAgent(),
                ])
            ],201);
        } catch (VerificationException $e) {
            return response('', $e->getCode());
        }
    }

    public function confirm(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|integer',
        ]);

        if ($validator->fails() || !$request->isJson()) {
            return response('', 400);
        }

        try {
            $this->verificationService->confirmVerification($id, $request->get('code'),[
                'IP' => $request->getClientIp(),
                'agent' => $request->userAgent(),
            ]);
            return response('', 204);
        } catch (VerificationException $e) {
            return response('', $e->getCode());
        }
    }
}
