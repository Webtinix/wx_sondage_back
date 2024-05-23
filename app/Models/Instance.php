<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Instance extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'classe_id',
        'parent_id',
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function datas(): HasMany
    {
        return $this->hasMany(Data::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Instance::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Instance::class, 'parent_id');
    }

    public function me($lang_id, $instance = null, $form_empty = false)
{
    try {
        $class = $this->classe;
        if ($class->tech_name == "formation" && auth()->user()->role != "admin") {
            $data = $this->data()->where('attribute_id', Attribute::where('tech_name', 'auto_generate_formateur_id')->first()->id)->first();
            if ($data && $data->value != auth()->user()->id) {
                return [];
            }
        }
    } catch (\Throwable $th) {
        // Handle exception if needed
    }

    $result_tab = [
        'instance' => [
            'id' => $this->id,
            'classe_id' => $this->classe_id,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ],
        'data' => [
            'groupe_attributes' => [],
        ],
    ];

    $all_groupe_class = $this->classe->groupeAttributes()->orderBy('position', 'asc')->get();

    foreach ($all_groupe_class as $value) {
        $d = [
            'id' => $value->id,
            'lib' => $value->lib,
            'position' => $value->position,
            'attr' => $value->attr,
            'classe_id' => $value->classe_id,
        ];

        if ($value->component_id !== null) {
            $d['component_multi'] = $value->componentMulti->lib();
            $d['component_unique'] = $value->componentUnique->lib();
        }

        $attributes = $value->attributes()->orderBy('position', 'asc')->get();

        foreach ($attributes as $attribute) {
            $data = $this->datas()->where('attribute_id', $attribute->id)->first();
            if ($data) {
                $d['attributes'][] = $data->me($lang_id, $instance, $form_empty);
            }
        }

        $result_tab['data']['groupe_attributes'][] = $d;
    }

    return $result_tab;
}

    // public function me($lang_id, $instance = null, $form_empty = false)
    // { 
    //     $class = Classe::find($this->classe_id); 
        
    //     try {
    //         //code...
    //         // if ($class->tech_name == "formation" && auth()->user()->role == "utilisateur") {
    //         if ($class->tech_name == "formation" && auth()->user()->role != "admin") {
    //             $data = Data::where([
    //                 'instance_id' => $this->id, 
    //                 'attribute_id' => Attribute::where(['tech_name' => 'auto_generate_formateur_id'])->first()->id
    //             ])->first();
    //             if ($data->value != auth()->user()->id) {
    //                 # code...
    //                 return [];
    //             }
    //         }
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    //     $all_groupe_class = GroupeAttribute::where(['classe_id' => $this->classe_id])->orderBy('position', 'asc')->get();
    //     $result_tab = [
    //         'instance' => [
    //             'id' => $this->id,
    //             'classe_id' => $this->classe_id,
    //             'parent_id' => $this->parent_id,
    //             'created_at' => $this->created_at->format('d/m/Y H:i:s'),
    //             'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
    //         ],
    //         'data' => [],
    //     ];

    //     $data_group_attribute = [];
    //     foreach ($all_groupe_class as $key => $value) {
    //         # code...
    //         $d=[
    //             'id' =>$value->id,
    //             'lib' => $value->lib,
    //             'position' =>$value->position,
    //             'attr' =>$value->attr,
    //             'classe_id' =>$value->classe_id,
    //         ];
    //         if (is_numeric($value->component_id)) {
    //             # code...
    //             $d['component_multi'] = Component::where(['id' => $value->component_multi])->first()->lib(); 
    //         }
    //         if (is_numeric($value->component_unique)) {
    //             # code...
    //             $d['component_unique'] = Component::where(['id' => $value->component_unique])->first()->lib();
    //         }
    //         $attributes = Attribute::where(['groupe_attribute_id' => $value->id])->orderBy('position', 'asc')->get();
    //         foreach ($attributes as $key_ => $attribute_value) {
    //             $data = Data::where(['instance_id' => $this->id, 'attribute_id' => $attribute_value->id])->first();
    //             if ($data == null) {
    //                 // $p = $attribute_value->ma($lang_id);
    //                 // $p['values'] = [];
    //                 // $d['attributes'][] = $p;
    //             }else {
    //                 $d['attributes'][] = $data->me($lang_id, $instance, $form_empty);
    //             }
    //         }
    //         $data_group_attribute[] = $d;
    //     }
    //     $result_tab['data']['groupe_attributes'] = $data_group_attribute;
    //     return $result_tab;
    // }

    public function pBif()
    {
        $model  =[
            'id' => $this->id,
            'libelle' => $this->myData('lib'),
            'description' => $this->myData('description') ,
            'nombreStagiaires' => $this->myData('nombre_etudiant'),
            'formateur' => $this->formateurInfo($this->myData('auto_generate_formateur_id')),
            'informationSondage' => [
                'questionSondage' => $this->pBis()['questionSondage'],
                'reponseSondage' =>  $this->pBis()['reponseSondage']
            ],
            'createAt' => $this->myData('date_creation'),
            'updateAt' => $this->myData('date_modification'),
        ];
        return $model;
    }

    function  myData($tech_name_attribute){  
        try {
            //code...
            $a = Attribute::where(['tech_name' => $tech_name_attribute, 'classe_id' => $this->classe_id])->first();  
            $r = Classe::where(['tech_name' => $this->classe()->first()->tech_name])->first()
                        ->instances()->where(['id' => $this->id])->first()
                                    ->datas()->where([
                                        'attribute_id' => $a->id
                                    ])->first()->value;
            return $r;
        } catch (\Throwable $th) {
            //throw $th;
            return '';
        }
    }

    function pBis() 
    {
        $d = Classe::where(['tech_name' => 'sondage-'.$this->id])->first();
        if (!empty($d)) {
            # code...
            $d = $d->instances()->orderBy('created_at', 'desc')->get();
            $q = [];
        $r = [];
        $attr = Classe::where(['tech_name' => 'sondage-'.$this->id])->first()->attributes()->get();
        foreach ($attr as $key => $value) {
            $s = explode('.',$value->component()->first()->lib);
            $q [] = ['id' => $value->id, 'lib' => $value->lib, 'type' => end($s)];
        }
        foreach ($d as $key => $value) {
            foreach ($value->datas()->get() as $k => $val) {
                $r[$key][] = ['id' => $val->id, 'value' => $val->getDataValue(), 'questionId' => $val->attribute()->first()->id,'date' => $val->created_at->format('d/m/Y H:i:s')];
            }
        }
        return ['questionSondage' => $q, 'reponseSondage' => $r];
        }
        return ['questionSondage' => [], 'reponseSondage' => []];
    }


    public function formateurInfo($id)
    {
        return User::where(['id' => $id])->first();
    }
} 
