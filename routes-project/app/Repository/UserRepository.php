<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interface\IRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

class UserRepository implements IRepository {

    /**
     * Default constructor of the repository
     */
    public function __construct(){}

    /**
     * Function to find all users 
     */
    public function findAll(): array{
        $list = [];
        try {
            $usersMysql = User::on("mysql")->all();
            $list = $usersMysql->toArray();
    
            if (empty($list)) {
                $usersSqlite = User::on("sqlite")->all();
                $list = $usersSqlite->toArray();
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $list;
    }
    
    /**
     * Function to add an user 
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection("mysql")->save();
            $p->refresh();
            $result = $p;

            $pSqlite = new User();
            $pSqlite->id = $p->id;
            $pSqlite->name = $p->name;
            $pSqlite->surname = $p->surname;
            $pSqlite->email = $p->email;
            $pSqlite->phone = $p->phone;
            $pSqlite->password = $p->password;
            $pSqlite->id_image = $p->id_image;
            $pSqlite->id_role = $p->id_role;
            $pSqlite->setConnection("sqlite")->save();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id an user
     */
    public function findById($id): object | null {
        $pToFind = null;
        DB::connection()->enableQueryLog();
        $pToFind = User::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = User::on("mysql")->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = User::on("sqlite")->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name an user
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        DB::connection()->enableQueryLog();
        $pToFind = User::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = User::on("mysql")->where("email", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = User::on("sqlite")->where("email", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update an user
     */
    public function update($p): bool {
        $updated = false;
    
        try {
            $pUpdate = User::on("mysql")->find($p->id);
    
            if ($pUpdate) {
                $pUpdate->name = $p->name;
                $pUpdate->surname = $p->surname;
                $pUpdate->email = $p->email;
                $pUpdate->phone = $p->phone;
                $pUpdate->password = $p->password;
                $pUpdate->id_image = $p->id_image;
                $pUpdate->id_role = $p->id_role;
    
                $pUpdate->save();
                $updated = true;
            }
    
            $pUpdateSqlite = User::on("sqlite")->find($p->id);
    
            if ($pUpdateSqlite) {
                $pUpdateSqlite->name = $p->name;
                $pUpdateSqlite->surname = $p->surname;
                $pUpdateSqlite->email = $p->email;
                $pUpdateSqlite->phone = $p->phone;
                $pUpdateSqlite->password = $p->password;
                $pUpdateSqlite->id_image = $p->id_image;
                $pUpdateSqlite->id_role = $p->id_role;
    
                $pUpdateSqlite->save();
                $updated = true;
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $updated;
    }

    /**
     * Function to delete an user
     */
    public function delete($id): bool{
        $deleted = false;

        try {
            $mySqlItem = User::on("mysql")->find($id);
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }
    
            $sqliteItem = User::on("sqlite")->find($id);
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