<?php

namespace App\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if ($this->isModel($e)) {
            return $this->isModelResponse($e);
        }

        if ($this->isHttp($e)) {
            return $this->isHttpResponse($e);
        }

        return parent::render($request, $e);
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function isModelResponse($e)
    {
        return response()->json([
            'error' => 'Not Found'
        ], Response::HTTP_NOT_FOUND);
    }

    protected function isHttpResponse($e)
    {
        return response()->json([
            'error' => 'Wrong Url'
        ], Response::HTTP_NOT_FOUND);
    }
}
