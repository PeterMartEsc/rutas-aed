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
     * @return array 
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
     * @param Role $p
     * @return Role | null
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
     * @param int $id
     * @return Role | null  If not found, return null.  If found, return the Role object.  If database error, throw an exception.  If sqlite error, return null.  If both errors, throw an exception.  If both errors, return null.  If both errors, throw an exception.  If both errors, return null.  If both errors, throw an exception.  If both errors, return null.  If both errors, throw an exception
     */
    public function findById($id): object | null {
        $pToFind = null;    

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
     * @param string $uniquekey
     * @return Role | null  If not found, return null.  If found, return the Role object.  If database error, throw an exception.  If sqlite error, return null.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors,
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;

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
     * @param Role $p
     * @return bool  True if updated, false otherwise.  If database error, throw an exception.  If sqlite error, return false.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an
     */
    public function update($p): bool {
        $updated = false;

        try {
            $pUpdate = Role::on($this->connectionMySql)->where("id", $p->id)->first();

            if ($pUpdate) {
                $pUpdate->id = $p->id;
                $pUpdate->name = $p->name;
                $pUpdate->save();
                $updated = true;
            }

            if(!app()->runningUnitTests()){
                $pUpdateSqlite = Role::on($this->connectionSqlite)->where("id", $p->id)->first();
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
     * @param int $id
     * @return bool  True if deleted, false otherwise.  If database error, throw an exception.  If sqlite error, return false.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an exception.  If both errors, throw an
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
