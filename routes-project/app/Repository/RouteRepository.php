<?php

namespace App\Repository;

use App\Models\Route;
use App\Repository\Interface\IRepository;
use Exception;

use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RouteRepository implements IRepository {

    /**
     * Default constructor of the repository
     */
    public function __construct(){}

    /**
     * Function to find all routes 
     */
    public function findAll(): array{
        $list = [];
        try {
            $routesMysql = Route::on("mysql")->all();
            $list = $routesMysql->toArray();
    
            if (empty($list)) {
                $imagesSqlite = Route::on("sqlite")->all();
                $list = $imagesSqlite->toArray();
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $list;
    }
    
    /**
     * Function to add an route 
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection("mysql")->save();
            $p->refresh();
            $result = $p;

            $pSqlite = new Route();
            $pSqlite->id = $p->id;
            $pSqlite->title = $p->title;
            $pSqlite->location = $p->location;
            $pSqlite->distance = $p->distance;
            $pSqlite->date_route = $p->date_route;
            $pSqlite->difficulty = $p->difficulty;
            $pSqlite->pets_allowed = $p->pets_allowed;
            $pSqlite->vehicle_needed = $p->vehicle_needed;
            $pSqlite->description = $p->description;
            $pSqlite->user_id = $p->user_id;

            $pSqlite->setConnection("sqlite")->save();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id a route
     */
    public function findById($id): object | null {
        $pToFind = null;
        DB::setConnection()->enableQueryLog();
        $pToFind = Route::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Route::on("mysql")->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Route::on("sqlite")->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name a route
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        DB::setConnection()->enableQueryLog();
        $pToFind = Route::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Route::on("mysql")->where("title", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Route::on("sqlite")->where("title", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update a route
     */
    public function update($p): bool {
        $updated = false;
    
        try {
            $pUpdate = Route::on("mysql")->find($p->id);
    
            if ($pUpdate) {
                $pUpdate->id = $p->id;
                $pUpdate->title = $p->title;
                $pUpdate->location = $p->location;
                $pUpdate->distance = $p->distance;
                $pUpdate->date_route = $p->date_route;
                $pUpdate->difficulty = $p->difficulty;
                $pUpdate->pets_allowed = $p->pets_allowed;
                $pUpdate->vehicle_needed = $p->vehicle_needed;
                $pUpdate->description = $p->description;
                $pUpdate->user_id = $p->user_id;
                $pUpdate->save();
                $updated = true;
            }
    
            $pUpdateSqlite = Route::on("sqlite")->find($p->id);
    
            if ($pUpdateSqlite) {
                $pUpdateSqlite->id = $p->id;
                $pUpdateSqlite->title = $p->title;
                $pUpdateSqlite->location = $p->location;
                $pUpdateSqlite->distance = $p->distance;
                $pUpdateSqlite->date_route = $p->date_route;
                $pUpdateSqlite->difficulty = $p->difficulty;
                $pUpdateSqlite->pets_allowed = $p->pets_allowed;
                $pUpdateSqlite->vehicle_needed = $p->vehicle_needed;
                $pUpdateSqlite->description = $p->description;
                $pUpdateSqlite->user_id = $p->user_id;
                $pUpdateSqlite->save();
                $updated = true;
            }
    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return $updated;
    }

    /**
     * Function to delete a route
     */
    public function delete($id): bool{
        $deleted = false;
        try {
            $mySqlItem = Route::on("mysql")->find($id);
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }
    
            $sqliteItem = Route::on("sqlite")->find($id);
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