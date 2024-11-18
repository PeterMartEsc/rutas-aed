<?php

namespace App\Repository;

use App\Models\Image;
use App\Repository\Abstract\RepositoryAbstract;
use App\Repository\Interface\IRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */

class ImageRepository extends RepositoryAbstract implements IRepository {

    /**
     * Default constructor of the repository
     */
    public function __construct(){}

    /**
     * Function to find all images
     */
    public function findAll(): array{
        $list = [];
        try {
            $imagesMysql = Image::on($this->connectionMySql)->get();
            $list = $imagesMysql->toArray();

        } catch (\Exception $e) {
            $imagesSqlite = Image::on($this->connectionSqlite)->get();
            $list = $imagesSqlite->toArray();
        }

        return $list;
    }

    /**
     * Function to add an image
     */
    public function save($p): object | null{
        $result = null;
        try {
            $p->setConnection($this->connectionMySql)->save();
            $p->refresh();
            $result = $p;

            if(!app()->runningUnitTests()){
                $pSqlite = new Image();
                $pSqlite->id = $p->id;
                $pSqlite->image = $p->image;
                $pSqlite->type_image = $p->type_image;
                $pSqlite->setConnection($this->connectionSqlite)->save();
            }

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    /**
     * Function to find by Id an image
     */
    public function findById($id): object | null {
        $pToFind = null;
        DB::setConnection()->enableQueryLog();
        $pToFind = Image::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Image::on($this->connectionMySql)->where("id", $id)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Image::on($this->connectionSqlite)->where("id", $id)->first();
        }

        return $pToFind;
    }

    /**
     * Function to find by name an image
     */
    public function findByUniqueKey($uniqueKey): object | null {
        $pToFind = null;
        DB::setConnection()->enableQueryLog();
        $pToFind = Image::find(1);
        $lastQuery = DB::getQueryLog();
        //dd($lastQuery);

        try{
            $pToFind = Image::on($this->connectionMySql)->where("image", $uniqueKey)->first();
        }catch(Exception $e){
            echo $e->getMessage();
            $pToFind = Image::on($this->connectionSqlite)->where("image", $uniqueKey)->first();
        }

        return $pToFind;
    }

    /**
     * Function to to update an image
     */
    public function update($p): bool {
        $updated = false;

        try {
            $pUpdate = Image::on($this->connectionMySql)->find($p->id);

            if ($pUpdate) {
                $pUpdate->id = $p->id;
                $pUpdate->image = $p->image;
                $pUpdate->type_image = $p->type_image;
                $pUpdate->save();
                $updated = true;
            }

            if(!app()->runningUnitTests()){

                $pUpdateSqlite = Image::on($this->connectionSqlite)->find($p->id);
                if ($pUpdateSqlite) {
                    $pUpdateSqlite->id = $p->id;
                    $pUpdateSqlite->image = $p->image;
                    $pUpdateSqlite->type_image = $p->type_image;
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
     * Function to delete an image
     */
    public function delete($id): bool{
        $deleted = false;

        try {
            $mySqlItem = Image::on($this->connectionMySql)->find($id)->first();
            if ($mySqlItem) {
                $mySqlItem->delete();
                $deleted = true;
            }

            if(!app()->runningUnitTests()){
                $sqliteItem = Image::on($this->connectionSqlite)->find($id)->first();
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
