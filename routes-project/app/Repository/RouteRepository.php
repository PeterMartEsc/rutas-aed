<?php

namespace App\Repository;

use App\Models\Route;
use App\Models\User;
use App\Repository\Abstract\RepositoryAbstract;
use App\Repository\Interface\IRepository;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RouteRepository extends RepositoryAbstract implements IRepository {

    /**
     * Default constructor of the repository
     */
    public function __construct(){}

    /**
     * Function to find all routes
     * @return array
     */
    public function findAll(): array{
        $list = [];
        try {
            $routesMysql = Route::on($this->connectionMySql)->get();
            $list = $routesMysql->toArray();

        } catch (\Exception $e) {
            $routesSqlite = Route::on($this->connectionSqlite)->get();
            $list = $routesSqlite->toArray();
        }

        return $list;
    }

    /**
     * Function to add an route
     * @param p: Route entity
     * @return object|null
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection($this->connectionMySql)->save();
            $p->refresh();
            $result = $p;


            if(!app()->runningUnitTests()){
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
                $pSqlite->setConnection($this->connectionSqlite)->save();
            }

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id a route
    * @param id
     * @return object|null
     */
    public function findById($id): object | null {
        $pToFind = null;

        try{
            $pToFind = Route::on($this->connectionMySql)->where("id", $id)->first();
        }catch(Exception $e){
            $pToFind = Route::on($this->connectionSqlite)->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name a route
    * @param id
     * @return object|null
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;

        try{
            $pToFind = Route::on($this->connectionMySql)->where("title", $uniqueKey)->first();
        }catch(Exception $e){
            $pToFind = Route::on($this->connectionSqlite)->where("title", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update a route
     * 
     */
    public function update($p): bool {
        $updated = false;

        try {
            $pUpdate = Route::on($this->connectionMySql)->where("id", $p->id)->first();

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


            if(!app()->runningUnitTests()){
                $pUpdateSqlite = Route::on($this->connectionSqlite)->where("id", $p->id)->first();
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
            }

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $updated;
    }

    /**
     * Function to delete a route
     * @param id
     * @return boolean true if route deleyed, false otherwise
     */
    public function delete($id): bool{
        $deleted = false;
        try {
            $mySqlItem = Route::on($this->connectionMySql)->where("id", $id)->first();
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }


            if(!app()->runningUnitTests()){
                $sqliteItem =Route::on($this->connectionSqlite)->where("id", $id)->first();
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


    /**
     * Function find all routes created by a user
    * @param userId to get routes crated
     */
    public function findRoutesCreatedByUserId($userId): array{
        $list = [];

        try {
            $routesMysql = Route::on($this->connectionMySql)->get()->where("user_id", $userId);
            $list = $routesMysql->toArray();

        } catch (\Exception $e) {
            $routesSqlite = Route::on($this->connectionSqlite)->get()->where("user_id", $userId);
            $list = $routesSqlite->toArray();
        }
        return $list;
    }

    /**
     * Function to find all routes that a user has signed for ordered by date
     * @param userId to get its routes
     */
    public function getRoutesOrderedByDate($userId): array{
        $list = [];

        try {
            $routesMysql = Route::on($this->connectionMySql)
                ->join('users_routes', 'users_routes.route_id', '=', 'routes.id')
                ->where('users_routes.user_id', '=', $userId)
                ->orderBy('routes.date_route', 'asc')
                ->get(['routes.*']);

            $list = $routesMysql->toArray();

        } catch (\Exception $e) {
            $routesSqlite = Route::on($this->connectionSqlite)
                ->join('users_routes', 'users_routes.route_id', '=', 'routes.id')
                ->where('users_routes.user_id', '=', $userId)
                ->orderBy('routes.date_route', 'asc')
                ->get(['routes.*']);

            $list = $routesSqlite->toArray();
        }


        return $list;
    }

    /**
     * Function to find the nearest route of an user
     * @param string $userId
     * @return array|null
     */
    public function getNearestDateRouteByUser($userId): ?array{
        $route = null;

        try {
            $route = Route::on($this->connectionMySql)
                ->join('users_routes', 'users_routes.route_id', '=', 'routes.id')
                ->where('users_routes.user_id', '=', $userId)
                ->orderBy('routes.date_route', 'asc')
                ->first(['routes.*']);

        } catch (\Exception $e) {
            $route = Route::on($this->connectionSqlite)
                ->join('users_routes', 'users_routes.route_id', '=', 'routes.id')
                ->where('users_routes.user_id', '=', $userId)
                ->orderBy('routes.date_route', 'asc')
                ->first(['routes.*']);
        }

        return $route ? $route->toArray() : null ;
    }

    /**
     * Function to find the nearest route globally
     * @return array|null
     */
    public function getNearestDateRouteGlobally(): ?array{
        $route = null;

        try {
            $route = Route::on($this->connectionMySql)
                ->orderBy('routes.date_route', 'asc')
                ->first(['routes.*']);

        } catch (\Exception $e) {
            $route = Route::on($this->connectionSqlite)
                ->orderBy('routes.date_route', 'asc')
                ->first(['routes.*']);
        }

        return $route ? $route->toArray() : null ;
    }

    /**
     * Function to sign in a route
     * @param userid, routeid, to sign in
     * @return array|null
     */
    public function signForRoute($userId, $routeId) : bool {
        try {
            $route = $this->findById($routeId);

            $route->users()->attach($userId);
            if(!app()->runningUnitTests()){
                if (!$route->users()->where('user_id', $userId)->exists()) {
                    $route->users()->attach($userId);
                    return true;
                }
            }

    
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    
        return false;
    }


    /**
     * Function to sign out a route
     * @param userid, routeid, to sign in
     * @return array|null
     */
    public function signoutForRoute($userId, $routeId) : bool {

        try {
            $route = $this->findById($routeId);

            if (!$route) {
                return false;
            }

            if(!app()->runningUnitTests()){
                if ($route->users()->where('user_id', $userId)->exists()) {
                    $route->users()->detach($userId);
                    return true;
                }
            }


        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Function to check if a route is from a user
     * @param userid routeid
     * @return array|null
     */
    public function checkIfRouteIsMine($userId, $routeId) : Route | null{
        $route = null;
        try {
            $route = Route::on($this->connectionMySql)
                ->where('user_id', '=', $userId)
                ->where('id', '=', $routeId)
                ->first();
        } catch (\Exception $e) {
            $route = Route::on($this->connectionMySql)
            ->where('user_id', '=', $userId)
            ->where('id', '=', $routeId)
            ->first();
        }

        return $route;
    }

    /**
     * Function to filter the routes
     * @param filter to check
     * @return array
     */

    public function filterRoutes($filter){
        $list = [];
        try {
            $routesMysql = Route::on($this->connectionMySql)
            ->where('title', 'regexp', "^$filter")->get();
            $list = $routesMysql->toArray();

        } catch (\Exception $e) {
            $routesSqlite = Route::on($this->connectionSqlite)
            ->where('title', 'regexp', "^$filter")->get();
            $list = $routesSqlite->toArray();
        }

        return $list;
    }
    /**
     * Function to check if a route has users signed in
     * @param routeId to check
     * @return bool true if route has users, false otherwise
     */
    public function checkIfRouteHasUsersSigned($routeId): bool{
        try {
            $routeExists = DB::connection($this->connectionMySql)->
            table('users_routes')->where('route_id', $routeId)->exists();
        
            if ($routeExists) {
                return true; 
            } else {
                return false;
            }
        
        } catch (\Exception $e) {
            $routeExists = DB::connection($this->connectionSqlite)->
            table('users_routes')->where('route_id', $routeId)->exists();
        
            if ($routeExists) {
                return true; 
            } else {
                return false;
            }
        }
        
        return false;

    }
}

