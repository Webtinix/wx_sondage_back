<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ClassLang;
use PHPUnit\Event\Code\ClassMethod;

class Classe extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lib',
        'tech_name',
        'class_parent_id',
        'company_id',
        'component_multi_id',
        'component_unique_id',
    ];

    public function component_unique(): BelongsTo
    {
        return $this->belongsTo(Component::class, 'id', 'component_unique_id');
    }

    public function component_multi(): BelongsTo
    {
        return $this->belongsTo(Component::class, 'id', 'component_multi_id');
    }

    public function instances(): HasMany
    {
        return $this->hasMany(Instance::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function groupeAttributes(): HasMany
    {
        return $this->hasMany(GroupeAttribute::class);
    }

    public function classLangs(): HasMany
    {
        return $this->hasMany(ClassLang::class);
    }

    public function me($lang_id, $instance = null, $form_empty = false)
    {
        $class = $this;
        $class_lang = ClassLang::where(['classe_id' => $class->id, 'lang_id' => $lang_id,])->first();
        
        $class_tab = [
            'lib' => $class->lib,
            'tech_name' => $class->tech_name,
            'company_id' => $class->id,
            'class_parent_id' => $class->class_parent_id,
            'component_multi_id' => $class->component_multi_id,
            'component_unique_id' => $class->component_unique_id,
        ];
        if (is_numeric($class->component_multi_id)) {
            # code...
            $class_tab['component_multi'] = Component::where(['id' => $class->component_multi_id])->first()->lib;
        }
        if (is_numeric($class->component_unique_id)) {
            # code...
            $class_tab['component_unique'] = Component::where(['id' => $class->component_unique_id])->first()->lib;
        }
        return['class' => $class_tab];
    }


//     public function getmyAttributeGroups($lang_id, $instance)
// {
//     $result_ga = [];
//     $class_lang = ClassLang::where(['classe_id' => $this->id, 'lang_id' => $lang_id])->first();

//     // Option 1: Si la relation groupeAttributes est définie dans le modèle
//     foreach ($this->groupeAttributes as $value) {
//         $result_ga[] = $value->me($lang_id, $instance);
//     }
//     // dd(count($result_ga));
//     dd($result_ga);
//     return $result_ga;
// }

    public function getmyAttributeGroups($lang_id,$instance = null)
    {
        $result_ga = [];
        $class = $this;
        $class_lang = ClassLang::where(['classe_id' => $class->id, 'lang_id' => $lang_id])->first();

        foreach ($this->groupeAttributes as $key => $value) {
            # code...
            $result_ga[] = $value->me($lang_id, $instance);
        }
        // dd($result_ga);
        return $result_ga;
    }

    public function getmyInstances($lang_id, $instance_id = null, $form_empty = false, $class_name = null, $per_page = 10)
    {
        $total = 0;
        $all_instance = [];
        $result_tab = [
            'meta' => [
                'total' => $total,
                'current' => 1,
                'instance' => $instance_id !== null ? 'unique' : 'multi',
                'links' => [],
            ],
            'data' => [],
        ];
        if ($instance_id === "0") {
            $all_instance = [];
        }else {	
            if ($instance_id === null) {
                if ($form_empty == false and ($class_name == 'formation' or strstr($class_name, 'sondage-') !== false)) {
                    $all_instance = Instance::where(['classe_id' => $this->id])->orderBy('created_at', 'desc')->paginate($per_page);
                }else {
                    $all_instance = Instance::where(['classe_id' => $this->id])->orderBy('created_at', 'desc')->get();
                }
                $total = count($all_instance);
            }else {
            $all_instance = Instance::where(['id' => $instance_id])->get();
            }
        }
        if(count($all_instance) > 1 and ($class_name == 'formation' or strstr($class_name, 'sondage-') !== false) ) {
            $result_tab['meta']['total'] = $total;
            $result_tab['meta']['current'] = $all_instance->toArray()['current_page'];
            $result_tab['meta']['links'] = $all_instance->toArray()['links'];
        }
        foreach ($all_instance as $key => $value) {
            $tab = $value->me($lang_id, $instance_id, $form_empty);
            if ($tab != []) {
                $result_tab['data'][] = $tab;
            }else {
                continue;
            }
        }
        return $result_tab;
    }

//     public function getmyInstances($lang_id, $instance_id = null, $form_empty = false)
// {
//     $query = Instance::where('classe_id', $this->id);
//     $total = $query->count();
//     if ($instance_id !== null && $instance_id !== "0") {
//         $query->where('id', $instance_id);
//     }

//     $instances = $query->orderByDesc('created_at')->get();
//     // dd($instances);
//     $result_tab = [
//         'meta' => [
//             'total' => $total,
//             'current' => 1,
//             'instance' => $instance_id !== null ? 'unique' : 'multi',
//         ],
//         'data' => $instances->map(function ($instance) use ($lang_id, $instance_id, $form_empty) {
//             $tab = $instance->me($lang_id, $instance_id, $form_empty);
//             return $tab ? $tab : null;
//         })->filter()->all(),
//     ];
//     return $result_tab;
// }



    public function defaultQuestions() : void {
        $sondage = $this ;
        // liste des options
        $liste_des_options_par_defaut = Classe::where(['tech_name' => 'liste_des_options_par_defaut_du_sondage'])->first();
        if ($liste_des_options_par_defaut == null) {
            $liste_des_options_par_defaut = Classe::create([
                'lib' => 'liste_des_options_par_defaut', 
                'tech_name' => 'liste_des_options_par_defaut_du_sondage', 
                'company_id' => $sondage->company_id,
                'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
                'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);
    
            $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
            $group_liste_des_options_par_defaut = GroupeAttribute::create([
                'classe_id' => $liste_des_options_par_defaut->id, 
                'position' => 1, 
                'lib' => 'liste_des_options_par_defaut_du_sondage' . $liste_des_options_par_defaut->id, 
                'attr' => '{"className":"grid gap-4"}', 
                'component_id_multi' => $gac->id, 
                'component_id_unique' => $gac->id
            ]);
    
            $attribute_option = Attribute::create([
                'tech_name' => 'attribute_option'.$liste_des_options_par_defaut->tech_name,
                'classe_id' => $liste_des_options_par_defaut->id,
                'groupe_attribute_id' => $group_liste_des_options_par_defaut->id,
                'lib' => 'Très mécontent',
                'position' => 1,
                'required' => 0,
                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            ]);

            $data_create_ins = ['classe_id' => $liste_des_options_par_defaut->id, 'parent_id' => null];
            $instance1 = Instance::create($data_create_ins);
            Data::create(['instance_id' => $instance1->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Très mécontent' , 'attribute_id' => $attribute_option->id]);
            $instance2 = Instance::create($data_create_ins);
            Data::create(['instance_id' => $instance2->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Mécontent' , 'attribute_id' => $attribute_option->id]);
            $instance3 = Instance::create($data_create_ins);
            Data::create(['instance_id' => $instance3->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Satisfait' , 'attribute_id' => $attribute_option->id]);
            $instance4 = Instance::create($data_create_ins);
            Data::create(['instance_id' => $instance4->id, 'class_id' => $liste_des_options_par_defaut->id, 'value' =>'Tres satisfait' , 'attribute_id' => $attribute_option->id]);

        }
        // recupereration du premier groupe

        $groupe = GroupeAttribute::where(['classe_id' => $sondage->id, 'position' => '1'])->first();
        
        $attribute_q9= Attribute::create([
            'tech_name' => 'animation_et_vitesse_de_presentation_du_cours_par_le_formateur'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Animation et vitesse de présentation du cours par le formateur",
            'position' => 8,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q10= Attribute::create([
            'tech_name' => 'explications_claires_du_formateur'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Explications claires du formateur",
            'position' => 9,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q11= Attribute::create([
            'tech_name' => 'connaissances_du_formateur'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Connaissances du formateur",
            'position' => 10,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q12= Attribute::create([
            'tech_name' => 'organisation_du_formateur'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Organisation du formateur",
            'position' => 11,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q13= Attribute::create([
            'tech_name' => 'disponibilite_du_formateur'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Disponibilité du formateur",
            'position' => 12,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q14= Attribute::create([
        'tech_name' => 'qu_avez_vous_pense_de_la_formation_dans_sa_globalite'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Qu'avez-vous pensé de la formation dans sa globalité",
            'position' => 13,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q15= Attribute::create([
            'tech_name' => 'etat_et_proprete_du_site'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Etat et propreté du site",
            'position' => 14,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q16= Attribute::create([
            'tech_name' => 'acceuil_site'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Acceuil site",
            'position' => 15,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q17= Attribute::create([
            'tech_name' => 'dejeuner'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Déjeuner",
            'position' => 16,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);

        $attribute_q1 = Attribute::create([
            'tech_name' => 'equilibre_theorie_pratique_de_la_formation_'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => 'Équilibre théorie / pratique de la formation',
            'position' => 1,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);

        // $attribute_q2 = Attribute::create([
        //     'tech_name' => 'equilibre_théorie_pratique_de_la_formation'.$sondage->tech_name,
        //     'classe_id' => $sondage->id,
        //     'classe_src_id' => $liste_des_options_par_defaut->id,
        //     'groupe_attribute_id' => $groupe->id,
        //     'lib' => 'Durée de la formation',
        //     'position' => ,
        //     'required' => 0,
        //     'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
        //     'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
        //     'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        // ]);

        $attribute_q3 = Attribute::create([
            'tech_name' => 'duree_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => 'Durée de la formation',
            'position' => 2,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        
        $attribute_q4= Attribute::create([
            'tech_name' => 'duree_des_pauses_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => 'Durée des pauses de la formation',
            'position' => 3,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q5= Attribute::create([
            'tech_name' => 'apport_delements_nouveaux_Objectifs_atteints_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Apport d'éléments nouveaux / Objectifs atteints de la formation",
            'position' => 4,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q6= Attribute::create([
            'tech_name' => 'materiels_utilises_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Matériels utilisés de la formation",
            'position' => 5,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q7= Attribute::create([
            'tech_name' => 'fascicule_remis_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Fascicule remis de la formation",
            'position' => 6,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]);
        $attribute_q8= Attribute::create([
            'tech_name' => 'accent_du_personnel_sur_la_securite_de_la_formation'.$sondage->tech_name,
            'classe_id' => $sondage->id,
            'classe_src_id' => $liste_des_options_par_defaut->id,
            'groupe_attribute_id' => $groupe->id,
            'lib' => "Accent du personnel sur la sécurité de la formation",
            'position' => 7,
            'required' => 0,
            'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.RadioButton'])->first()->id,
            'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
        ]); 
    }
}
