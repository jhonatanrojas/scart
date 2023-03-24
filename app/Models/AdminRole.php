<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminRole extends Model
{
    protected $fillable = ['name', 'slug'];
    public $table       = SC_DB_PREFIX.'admin_role';

    public function administrators()
    {
        return $this->belongsToMany(\SCart\Core\Admin\Models\AdminUser::class, SC_DB_PREFIX.'admin_role_user', 'role_id', 'user_id');
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(\SCart\Core\Admin\Models\AdminPermission::class, SC_DB_PREFIX.'admin_role_permission', 'role_id', 'permission_id');
    }

    /**
     * A role belongs to many status.
     *
     * @return BelongsToMany
     */
    public function status()
    {
        return $this->belongsToMany(SC_shop_order_status::class, SC_DB_PREFIX.'rol_estatus_pedido', 'admin_role_id', 'shop_order_status_id');
    }

    

    /**
     * A role belongs to many menus.
     *
     * @return BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(\SCart\Core\Admin\Models\AdminMenu::class, SC_DB_PREFIX.'admin_role_menu', 'role_id', 'menu_id');
    }

    /**
     * Check user has permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function can(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Check user has no permission.
     *
     * @param $permission
     *
     * @return bool
     */
    public function cannot(string $permission): bool
    {
        return !$this->can($permission);
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->administrators()->detach();
            $model->menus()->detach();
            $model->permissions()->detach();
            $model->status()->detach();
        });
    }

    /**
     * Update info customer
     * @param  [array] $dataUpdate
     * @param  [int] $id
     */
    public static function updateInfo($dataUpdate, $id)
    {
        $dataUpdate = sc_clean($dataUpdate);
        $obj        = self::find($id);
        return $obj->update($dataUpdate);
    }

    /**
     * Create new role
     * @return [type] [description]
     */
    public static function createRole($dataCreate)
    {
        $dataCreate = sc_clean($dataCreate);
        return self::create($dataCreate);
    }
}
