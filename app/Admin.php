<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $connection = 'mysql';
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $hidden = ['password'];
    public $timestamps = false;

    /**
     * Get the role record associated with the admin.
     */
    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
}