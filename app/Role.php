<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mysql';
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    /**
     * Get Permissions of role
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission')
            ->withPivot('is_read', 'is_inserted', 'is_updated', 'is_deleted');
    }
}