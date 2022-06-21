<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Email: robisignals@gmail.com
 * WhatsApp: +254724475357
 * Date: 22/05/2020
 * Time: 17:53
 */

namespace App\Repositories;

use App\Rental\Repositories\Contracts\ExpenseTypeInterface;
use App\Models\ExpenseType;

class ExpenseTypeRepository extends BaseRepository implements ExpenseTypeInterface
{
    protected $model;

    /**
     * GuestRepository constructor.
     * @param PaymentMethod $model
     */
    function __construct(ExpenseType $model)
    {
        $this->model = $model;
    }

}
