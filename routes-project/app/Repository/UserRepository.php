<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Abstract\RepositoryAbstract;
use App\Repository\Interface\IRepository;
use Exception;

/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

class UserRepository extends RepositoryAbstract implements IRepository{


    /**
     * Default constructor of the repository
     */
    public function __construct(){}


    /**
     * Function to find all users
     * @return array
     */
    public function findAll(): array{
        $list = [];
        try {

            $usersMysql = User::on($this->connectionMySql)->get();
            $list = $usersMysql->toArray();

        } catch (\Exception $e) {
            $usersSqlite = User::on($this->connectionSqlite)->get();
            $list = $usersSqlite->toArray();
        }

        return $list;
    }

    /**
     * Function to add an user
     * @param User $p
     * @return User|null
     */
    public function save($p): object | null{
        $result = null;

        try {
            $p->setConnection($this->connectionMySql)->save();
            $p->refresh();
            $result = $p;

            if(!app()->runningUnitTests()){
                $pSqlite = new User();
                $pSqlite->id = $p->id;
                $pSqlite->name = $p->name;
                $pSqlite->surname = $p->surname;
                $pSqlite->email = $p->email;
                $pSqlite->phone = $p->phone;
                $pSqlite->password = $p->password;
                $pSqlite->id_role = $p->id_role;    
                $pSqlite->setConnection($this->connectionSqlite)->save();
            }

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id an user
     * @param int $id
     * @return User|null
     */
    public function findById($id): object | null {
        $pToFind = null;

        try{
            $pToFind = User::on($this->connectionMySql)->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = User::on($this->connectionSqlite)->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by email an user
     * @param string $uniqueKey
     * @return User|null
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        $pToFind = User::find(1);

        try{
            $pToFind = User::on($this->connectionMySql)->where("email", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = User::on($this->connectionSqlite)->where("email", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update an user
     * @param User $p
     * @return bool true if update, false otherwise
     */
    public function update($p): bool {
        $updated = false;

        try {
            $pUpdate = User::on($this->connectionMySql)->where("id", $p->id)->first();
            if ($pUpdate) {
                $pUpdate->name = $p->name;
                $pUpdate->surname = $p->surname;
                $pUpdate->email = $p->email;
                $pUpdate->phone = $p->phone;
                $pUpdate->password = $p->password;
                $pUpdate->id_role = $p->id_role;
                $pUpdate->save();
                $updated = true;
            }


            if(!app()->runningUnitTests()){
                $pUpdateSqlite = User::on($this->connectionSqlite)->where("id", $p->id)->first();
                if ($pUpdateSqlite) {
                    $pUpdateSqlite->name = $p->name;
                    $pUpdateSqlite->surname = $p->surname;
                    $pUpdateSqlite->email = $p->email;
                    $pUpdateSqlite->phone = $p->phone;
                    $pUpdateSqlite->password = $p->password;
                    $pUpdateSqlite->id_role = $p->id_role;
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
     * Function to delete an user
     * @param int $id User's id to delete
     * @return bool True if the user was deleted, false otherwise 
     */
    public function delete($id): bool{
        $deleted = false;

        try {
            $mySqlItem = User::on($this->connectionMySql)->where("id", $id)->first();
            if ($mySqlItem != null) {
                $mySqlItem->delete();
                $deleted = true;
            }

            if(!app()->runningUnitTests()){
                $sqliteItem = User::on($this->connectionMySql)->where("id", $id)->first();
                if ($sqliteItem != null) {
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
