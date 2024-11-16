<?php

namespace App\Repository;

use App\Models\Role;
use App\Repository\Interface\IRepository;
use Exception;

use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

class RoleRepository implements IRepository {

    /**
     * Default constructor of the repository
     */
    public function __construct(){}

    /**
     * Function to find all roles 
     */
    public function findAll(): array{
        $list = [];
        try {
            $rolesMysql = Role::on("mysql")->all();
            $list = $rolesMysql->toArray();
    
            if (empty($list)) {
                $imagesSqlite = Role::on("sqlite")->all();
                $list = $imagesSqlite->toArray();
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $list;
    }
    
    /**
     * Function to add an role 
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection("mysql")->save();
            $p->refresh();
            $result = $p;

            $pSqlite = new Role();
            $pSqlite->id = $p->id;
            $pSqlite->name = $p->name;

            $pSqlite->setConnection("sqlite")->save();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id an role
     */
    public function findById($id): object | null {
        $pToFind = null;
        DB::connection()->enableQueryLog();
        $pToFind = Role::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Role::on("mysql")->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Role::on("sqlite")->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name an role
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        DB::connection()->enableQueryLog();
        $pToFind = Role::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Role::on("mysql")->where("name", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Role::on("sqlite")->where("name", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update an role
     */
    public function update($p): bool {
        $updated = false;
    
        try {
            $pUpdate = Role::on("mysql")->find($p->id);
    
            if ($pUpdate) {
                $pUpdate->id = $p->id;
                $pUpdate->name = $p->name;
                $pUpdate->save();
                $updated = true;
            }
    
            $pUpdateSqlite = Role::on("sqlite")->find($p->id);
    
            if ($pUpdateSqlite) {
                $pUpdateSqlite->id = $p->id;
                $pUpdateSqlite->name = $p->name;
                $pUpdateSqlite->save();
                $updated = true;
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $updated;
    }

    /**
     * Function to delete an role
     */
    public function delete($id): bool{
        $deleted = false;

        try {
            $mySqlItem = Role::on("mysql")->find($id);
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }
    
            $sqliteItem = Role::on("sqlite")->find($id);
            if ($sqliteItem) {
                $sqliteItem->delete();
                $deleted = true;
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $deleted;
    }
}