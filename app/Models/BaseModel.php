<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use OwenIt\Auditing\Auditable;
// use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Ramsey\Uuid\Uuid;

class BaseModel extends Model  
{
    // use SoftDeletes;
    // protected $guarded = ['uuid'];

    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) $model->generateNewId();
        });


    }

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */

    /**
     * @return \Ramsey\Uuid\UuidInterface
     * @throws \Exception
     */
    public function generateNewId()
    {
        return Uuid::uuid4();
    }

    /**
     * @param array $options
     * @return bool|void
     * @throws \Exception
     */
    public function save (array $options = array())
    {
        try{
            parent::save($options);
        }catch(\Exception $e){
            // check if the exception is caused by double id
            if(preg_match('/Integrity constraint violation: 1062 Duplicate entry \S+ for key \'PRIMARY\'/', $e->getMessage(), $matches)){
                $this->uuid = (string)$this->generateNewId();
                $this->save();
            }
        }
    }
    
}
