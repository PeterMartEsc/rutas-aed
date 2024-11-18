<?php

namespace App\Repository;

use App\Models\Role;
use App\Repository\Abstract\RepositoryAbstract;
use App\Repository\Interface\IRepository;
use Exception;

use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

class RoleRepository extends RepositoryAbstract implements IRepository {

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
            $rolesMysql = Role::on($this->connectionMySql)->get();
            $list = $rolesMysql->toArray();

        } catch (\Exception $e) {
            $rolesSqlite = Role::on($this->connectionSqlite)->get();
            $list = $rolesSqlite->toArray();
        }

        return $list;
    }

    /**
     * Function to add an role
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection($this->connectionMySql)->save();
            $p->refresh();
            $result = $p;

            if(!app()->runningUnitTests()){
                $pSqlite = new Role();
                $pSqlite->id = $p->id;
                $pSqlite->name = $p->name;
                $pSqlite->setConnection($this->connectionSqlite)->save();
            }

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
        DB::setConnection()->enableQueryLog();
        $pToFind = Role::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Role::on($this->connectionMySql)->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Role::on($this->connectionSqlite)->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name an role
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        DB::setConnection()->enableQueryLog();
        $pToFind = Role::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Role::on($this->connectionMySql)->where("name", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Role::on($this->connectionSqlite)->where("name", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update an role
     */
    public function update($p): bool {
        $updated = false;

        try {
            $pUpdate = Role::on($this->connectionMySql)->find($p->id);

            if ($pUpdate) {
                $pUpdate->id = $p->id;
                $pUpdate->name = $p->name;
                $pUpdate->save();
                $updated = true;
            }

            if(!app()->runningUnitTests()){
                $pUpdateSqlite = Role::on($this->connectionSqlite)->find($p->id);
                if ($pUpdateSqlite) {
                    $pUpdateSqlite->id = $p->id;
                    $pUpdateSqlite->name = $p->name;
                    $pUpdateSqlite->save();
                    $updated = true;
                }
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
            $mySqlItem = Role::on($this->connectionMySql)->find($id)->first();
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }

            if(!app()->runningUnitTests()){
                $sqliteItem = Role::on($this->connectionSqlite)->find($id)->first();
                if ($sqliteItem) {
                    $sqliteItem->delete();
                    $deleted = true;
                }
            }

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $deleted;
    }
}
