<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Sentry\Laravel\Facade as Sentry;

abstract class Controller
{
    protected function beginTransaction()
    {
        DB::beginTransaction();
    }

    protected function commitTransaction()
    {
        DB::commit();
    }

    protected function rollbackTransaction()
    {
        DB::rollBack();
    }

    protected function logException(\Throwable $e)
    {
        Sentry::captureException($e);
    }
}
