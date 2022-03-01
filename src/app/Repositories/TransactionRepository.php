<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    /**
     * トランザクション
     *
     * @param \Closure $func
     * @return mixed
     */
    public static function transaction(\Closure $func)
    {
        return DB::transaction($func);
    }

    /**
     * begin
     */
    public static function begin(): void
    {
        DB::beginTransaction();
    }

    /**
     * commit
     */
    public static function commit(): void
    {
        DB::commit();
    }

    /**
     * rollback
     */
    public static function rollback(): void
    {
        DB::rollBack();
    }
}
