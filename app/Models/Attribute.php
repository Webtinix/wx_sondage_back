<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Attribute extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tech_name',
        'position',
        'attr',
        'attr_label',
        'render_in',
        'module_in',
        'render_out',
        'module_out',
        'is_lang',
        'actif',
        'visible',
        'list_visible',
        'required',
        'disabled',
        'classe_id',
        'groupe_attribute_id',
        'classe_src_id',
        'component_id',
        'component_id_multi',
        'component_id_unique',
        'lib'
    ];

    public function datas(): HasMany
    {
        return $this->hasMany(Data::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function groupeAttribute(): BelongsTo
    {
        return $this->belongsTo(GroupeAttribute::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function attributeLangs(): HasMany
    {
        return $this->hasMany(AttributeLang::class);
    }

    public function me($lang_id, $instance = null, $form = null)
    {   
        $attribute_lang = AttributeLang::where(['attribute_id' => $this->id, 'lang_id' => $lang_id])->first();
        $result_tab = [
            'id' => $this->id,
            'tech_name' => $this->tech_name,
            'position' => $this->position,
            'attr' => $this->attr,
            'attr_label' => $this->attr_label,
            'render_in' => $this->render_in,
            'module_in' => $this->module_in,
            'render_out' => $this->render_out,
            'module_out' => $this->module_out,
            'is_lang' => $this->is_lang,
            'actif' => $this->actif,
            'visible' => $this->visible,
            'list_visible' => $this->list_visible,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'classe_id' => $this->classe_id,
            'groupe_attribute_id' => $this->groupe_attribute_id,
            'classe_src_id' => $this->classe_src_id,
            'component_id' => $this->component_id,
            'groupe_attribute_src' => $this->groupe_attribute_id,
            'lib' => $this->lib,
            'component_multi' => $this->component_id_multi,
            'component_unique' => $this->component_id_unique,
            'values' => [],
        ];
        if (is_numeric($this->classe_src_id)) {
            # code...
            $classe = Classe::where(['id' => $this->classe_src_id])->first();
            $result_tab['groupe_attribute_src'] = $classe->getmyAttributeGroups($lang_id,null);
            $result_tab['classe_src'] = $classe->getmyInstances($lang_id);
        }
        if (is_numeric($this->component_id)) {
            $result_tab['component_id'] = Component::where(['id' => $this->component_id])->first();
            $result_tab['component_multi'] =  $result_tab['component_id']->lib;
            $result_tab['component_unique'] =  $result_tab['component_id']->lib;
            $result_tab['component_id'] =  $result_tab['component_id']->lib;
        }

        return $result_tab;
    }

    // public function managerAttributeSimpleData($value, $instance_id, $data = null)	 
    // {   
    //     if ($data == null) {
    //         # code...
    //         $data = new Data();
    //     }else{
    //         # code...
    //         $data = Data::where(['instance_id' => $instance_id, 'attribute_id' => $this->id])->first();
    //     }
    //     if (!is_array($value)) {
    //         # code...
    //         $value = [$value];
    //     }
    //         # code...
    //     foreach ($value as $key => $val) {
    //         # code...
    //         $data->value = $val;
    //         $data->instance_id = $instance_id;
    //         $data->attribute_id = $this->id;
    //         $data->class_id = $this->classe_id;
    //         $data->save();
    //         $data_lang = null;
    //         if ($this->is_lang == 1) {
    //             if ($data == null) {
    //                 $data_lang = new DataLang();
    //             }else {
    //                 # code...
    //                 $data_lang = DataLang::where(['data_id' => $data->id, 'lang_id' => $this->attributeLangs()->first()->lang_id])->first();
    //             }
    //             $data_lang->value   = $val;
    //             $data_lang->lang_id = $this->attributeLangs()->first()->lang_id;
    //             $data_lang->data_id = $data->id;
    //             $data_lang->save();
    //         }
    //     }
    //     return true;
    // }

    public function managerAttributeSimpleData($value, $instance_id, $data = null)
    {   
        $value = !empty($value) ? $value : 'Aucune réponse';	
        if ($data == null) {
            $data = new Data();
        } else {
            $data = Data::where(['instance_id' => $instance_id, 'attribute_id' => $this->id])->first();
        }
    
        if (!is_array($value)) {
            $value = [$value];
        }
    
        foreach ($value as $key => $val) {
            $dataItem = clone $data; // Clone the original data object
            $dataItem->value = $val;
            $dataItem->instance_id = $instance_id;
            $dataItem->attribute_id = $this->id;
            $dataItem->class_id = $this->classe_id;
            $dataItem->save();
    
            // Handle multilingual data if enabled
            if ($this->is_lang == 1) {
                $data_lang = null;
                if ($dataItem == null) {
                    $data_lang = new DataLang();
                } else {
                    $data_lang = DataLang::where(['data_id' => $dataItem->id, 'lang_id' => $this->attributeLangs()->first()->lang_id])->first();
                }
                $data_lang->value = $val;
                $data_lang->lang_id = $this->attributeLangs()->first()->lang_id;
                $data_lang->data_id = $dataItem->id;
                $data_lang->save();
            }
        }
        return true;
    }
    
    public function ma($lang_id)
    {   
        $class_src = Classe::where(['id' => $this->classe_src_id])->first();
        $attribute_lang = AttributeLang::where(['attribute_id' => $this->id, 'lang_id' => $lang_id])->first();
        $result_tab = [
            'id' => $this->id,
            'tech_name' => $this->tech_name,
            'position' => $this->position,
            'attr' => $this->attr,
            'attr_label' => $this->attr_label,
            'render_in' => $this->render_in,
            'module_in' => $this->module_in,
            'render_out' => $this->render_out,
            'module_out' => $this->module_out,
            'is_lang' => $this->is_lang,
            'actif' => $this->actif,
            'visible' => $this->visible,
            'list_visible' => $this->list_visible,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'classe_id' => $this->classe_id,
            'groupe_attribute_id' => $this->groupe_attribute_id,
            'classe_src_id' => $this->classe_src_id,
            'component_id' => $this->component_id,
            'groupe_attribute_src' => $this->groupe_attribute_id,
            'lib' => $this->lib,
            'component_multi' => $this->component_id_multi,
            'component_unique' => $this->component_id_unique,
            'instances_src' => [],
        ];
        try {
            //code...
            $result_tab['instances_src'] = $class_src->getmyInstances($lang_id);
        } catch (\Throwable $th) {
            //throw $th;
        }
        if (is_numeric($this->classe_src_id)) {
            # code...
            $classe = Classe::where(['id' => $this->classe_src_id])->first();
            $result_tab['groupe_attribute_src'] = $classe->getmyAttributeGroups($lang_id,null);
            $result_tab['classe_src'] = $classe->getmyInstances($lang_id);
        }else {
            # code...
            $result_tab['groupe_attribute_src'] = [];
            $result_tab['classe_src'] = [];
        }
        if (is_numeric($this->component_id)) {
            $result_tab['component_id'] = Component::where(['id' => $this->component_id])->first();
            $result_tab['component_multi'] =  $result_tab['component_id']->lib;
            $result_tab['component_unique'] =  $result_tab['component_id']->lib;
            $result_tab['component_id'] =  $result_tab['component_id']->lib;
        }
        return $result_tab;
    }
}
