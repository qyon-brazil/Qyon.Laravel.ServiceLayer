<?php

/**
 * DatabaseTrait
 * php version 7.4.16
 *
 * @category Trait
 * @package  Qyon\ServiceLayer\Trait
 */

namespace Qyon\ServiceLayer\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

trait DatabaseTrait
{
    /**
     * columnExists function
     *
     * @param [type] $tableName
     * @param [type] $columnName
     *
     * @return void
     */
    protected function columnExists($tableName, $columnName)
    {

        $res = DB::table("information_schema.columns")
            ->select('column_name')
            ->whereRaw('concat(table_schema,\'.\',table_name) = \'' . $tableName . '\'')
            ->where('column_name', $columnName)
            ->first();

        return ($res && !empty($res->column_name));
    }

    /**
     * tableExists function
     *
     * @param [type] $tableName
     *
     * @return void
     */
    protected function tableExists($tableName)
    {
        $res = DB::table("information_schema.tables")
            ->select('table_name')
            ->whereRaw('concat(table_schema,\'.\',table_name) = \'' . $tableName . '\'')
            ->first();
        return ($res && !empty($res->table_name));
    }

    /**
     * statement function
     *
     * @param [type] $sql
     * @param boolean $ignoreError
     *
     * @return void
     */
    protected function statement($sql, $ignoreError = true)
    {
        if ($ignoreError) {
            try {
                DB::statement($sql);
            } catch (Exception $e) {
            }
        } else {
            DB::statement($sql);
        }
    }

    /**
     * GetColumnListing function
     *
     * @param string $tableName Nome da tabela que vai ser buscada.
     * @param string|null $database 
     *
     * @return array
     */
    protected function getColumnListing(string $tableName, ?string $database = null): array
    {
        $database = is_null($database) ?? Config::get("database.default");

        $callback = DB::connection($database)
            ->table("information_schema.columns")
            ->select('column_name')
            ->whereRaw("concat(table_schema,'.',table_name) = '{$tableName}' ")
            ->get();
        foreach ($callback as $row) {
            $columns[] = $row->column_name;
        }

        return $columns;
    }
}
