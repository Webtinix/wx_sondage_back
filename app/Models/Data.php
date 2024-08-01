<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Data extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
        'instance_id',
        'attribute_id',
        'class_id',
        'classe_id_src',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function me($lang_id, $instance = null, $form_empty = false)
    {
        $d = $this->attribute->me($lang_id, $this->instance);
        if ($form_empty == true) {
            # code...
            $d['values'] = [];
        }else {
            # code...
            $ds = Data::where(['attribute_id' => $this->attribute_id, 'instance_id' => $this->instance_id])->orderBy('created_at', 'desc')->get();
            foreach ($ds as $key => $value) {
                # code...
                $d['values'][] = $value->value;
            }
        }

        if (is_numeric($d['classe_src_id']) && $d['classe_src_id'] != $this->instance->classe()->first()->id) {
            $class_src = Classe::where(['id' => $d['classe_src_id']])->first();
            $d['instances_src'] = $class_src->getmyInstances($lang_id);
            $d['groupe_attribute_src'] =  $class_src->getmyAttributeGroups($lang_id,null);
        }else {
            # code...
            $d['groupe_attribute_src'] = [];
            $d['instances_src'] = [];
        }

        if ($this->attribute->is_dynamic_class_src == 1) {
            # code...
            $class_src = Classe::where(['id' => $this->classe_id_src])->first();
            $d['instances_src'] = $class_src->getmyInstances($lang_id);
        }
        return $d;
    }


    public function getDataValue(){
        try {
            $src = $this->attribute()->first()->classe_src_id;
            if (!empty($src) && is_numeric($src) && $src != "0") {
                $v = [$this->value];
                $v = (int) $this->convertJSONArrays($v);
                $instance =  Instance::where(['id' => $v])->first();
                return $instance->datas()->first()->value;
            }
            return $this->value;
        } catch (\Throwable $th) {
            return '';
        }
    }

    // public function managerAttributeList($attribute, array $values, $instance_id)  
    // {
    //     $child_instance = new Instance();
    //     $child_instance->class_id = $attribute->class_id;
    //     $child_instance->parent_id = $instance_id;
    //     $child_instance->is_dynamic_class_src = 0;
    //     $child_instance->save();
    //     foreach ($values as $key => $value) {
    //         # code...
    //         $this->managerAttributeSimpleData($attribute, $value, $child_instance->id);
    //     }
    // }

    public function convertJSONArrays($array) {
        foreach ($array as $key => $value) {
            if (is_string($value) && strpos($value, '[') === 0) {
                $array = json_decode($value);
            } elseif (is_array($value)) {
                $array = $this->convertJSONArrays($value);
            }
        }
        // dd($array);
        return $array[0];
    }
}
