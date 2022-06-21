<?php
/**
 * Created by PhpStorm.
 * User: Noel Kayogoma
 * Email: robisignals@gmail.com
 * WhatsApp: ++255753074110
 * Date: 12/06/2022
 * Time: 11:59
 */

namespace App\Repositories;

use App\Models\Tenant;

class OwenerRepository extends BaseRepository
{
    protected $model;

    /**
     * GuestRepository constructor.
     * @param Tenant $model
     */
    function __construct(Tenant $model)
    {
        $this->model = $model;
    }

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
  

    function getViaEmail($email) {
        return $this->model->where('email', $email)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

}
