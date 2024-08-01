<?php

namespace App\Http\Controllers;

use DateTime;
use App\Infusio;
use App\Models\Data;
use App\Models\Lang;
use App\Models\User;
use App\Models\Classe;
use App\Models\Company;
use App\Models\DataLang;
use App\Models\Instance;
use App\Models\Attribute;
use App\Models\ClassLang;
use App\Models\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\JWT;



class InfusioController extends Controller
{
    // Ajouter les attributs component multi et unique à Groupe, Attributs

    protected $user;
    protected $key_api;  
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->key_api = 'wx-qf3tLXbrXtdA7Tx@$AiR&md!8eooaYhrAzn3GjPzPe7iaFbJx$ga3QEYYaKzXqiih&QBnaHXetjnjxcxqf3tiaFbJx$ga3QEYYaKzXqiih';
        
    }
    
    public function get(Request $request, $company_uid, $lang_iso , $class_tech_name, $instance_id = "0")
    {   
        $company = null;
        $lang = null;
        if ($company_uid != null) {
            # code...
            $company = Company::where(['uid' => $company_uid])->first();
        }

        if ($lang_iso != null) {
            # code...
            $lang = Lang::where(['iso' => $lang_iso])->first();
        }
        if($class_tech_name != null) {
            $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            $me = $class->me($lang->id);
            $t = explode('-', $class_tech_name);
            // dd($t[1]);
            $i = Instance::where(['id' => $t[1]])->first();
            $a = Attribute::where(['tech_name' => 'auto_generate_formateur'])->first();
            $d = Data::where(['attribute_id' => $a->id, 'instance_id' => $i->id])->first();
            $f = $d->value;

            $infusioJson = [
                'class' => $me['class'],
                'groupe_attributes' => $class->getmyAttributeGroups($lang->id,null,true),
                'instances' =>$class->getmyInstances($lang->id,$instance_id,true,$class->tech_name ),
            ];
            $infusioJson['class']['formateur'] = $f;
            return response()->json($infusioJson,Response::HTTP_OK);
        }
    }

    public function getClass(Request $request, $company_uid ,  $lang_iso , $class_tech_name,  $instance = null)
    {
        // dd($company_uid, $lang_iso, $class_tech_name, $instance);
        // if (empty(auth()->user())) {
        //     # code...
        //     return response()->json(['code' => 401, 'message' => 'Vous devez vous connecter' ],Response::HTTP_UNAUTHORIZED);
        // }
        // dd(auth()->user()->id);

        $token = $request->header('API-KEY');
        // dd($this->key_api,$token);
        if ($token != $this->key_api) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $instance_id = $instance;
        $company = null;
        $lang = null;
        if ($company_uid != null) {
            # code...
            $company = Company::where(['uid' => $company_uid])->first();
        }
        
        if ($lang_iso != null) {
            # code...
            $lang = Lang::where(['iso' => $lang_iso])->first();
        }
        // dd($company, $lang,  $company->id);
        if($class_tech_name != null) {
            $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            $form_empty = false;
            // dd($instance_id);
            if ($instance_id == "0") {
                # code...
                $form_empty = true;
            }
            //on les charge dans le tableau infusioJson
            $me = $class->me($lang->id,$instance_id, $form_empty);
            // dd($me);
            $infusioJson = [
                'class' => $me['class'],
                // 'groupe_attributes' => $me['attributes'],
                // 'instances' => $me['instances'],
                'groupe_attributes' => $class->getmyAttributeGroups($lang->id,$instance_id,$form_empty),
                'instances' =>$class->getmyInstances($lang->id,$instance_id,$form_empty, $class->tech_name ),
            ];
            return response()->json($infusioJson,Response::HTTP_OK);
        }
        // $component = Infusio::renderComponent('com.webtinix.infusio.server.DataTable');
    }

    public function post(Request $request, $company_uid, $lang_iso, $class_tech_name )
    {
        
        $token = $request->header('API-KEY');        
        if ($token != $this->key_api) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }
        try {
            $company = null;
            $lang = null;
            if ($company_uid != null) {
                # code...
                $company = Company::where(['uid' => $company_uid])->first();
            }
            
            if ($lang_iso != null) {
                # code...
                $lang = Lang::where(['iso' => $lang_iso])->first();
            }
            $class = null;
            if($class_tech_name != null) {
                $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            }
            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            $instance = null;
            $data_create_ins = ['classe_id' => $class->id, 'parent_id' => null];

            $instance = Instance::create($data_create_ins);
            $data = $request->json()->all()['data'];
            try {
                foreach($data as $key => $value) {
                    $attribute = Attribute::where(['tech_name' => $key, 'classe_id' => $class->id])->first();
                    if(!empty($attribute)) {
                        $attribute->managerAttributeSimpleData((!empty($value) ? $value : "Aucune réponse"), $instance->id);
                    }
    
                    // if (trim($key) == 'lib' && $class_tech_name =='formation') {
                    //     $lib_formation = $value;
                    // }
                    
                }
            } catch (\Throwable $th) {
                //throw $th;
                
            }
            // En particulier si la classe est formation, on va creer un sondage
            // if ($class_tech_name =='formation') {
            //     //On va dater la creation de la formation 
            //     try {
            //         //code...
            //         foreach (['date_modification'=> date('d/m/Y H:i:s'), 'date_creation' => date('d/m/Y H:i:s') ] as $key => $value) {
            //             # code...
            //             $attribute = Attribute::where(['tech_name' => $key, 'classe_id' => $class->id])->first();
            //             $attribute->managerAttributeSimpleData($value, $instance->id);
            //             # code...
            //         }
            //     } catch (\Throwable $th) {
            //         //throw $th;
            //     }
            //     $class_sondage = Classe::create([
            //         'lib' => $lib_formation, 
            //         'tech_name' => 'sondage-'.$instance->id, 
            //         'company_id' => $company->id,
            //         'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.SondageResult'])->first()->id,
            //         'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            //     ]);
            //     // $group = GroupeAttribute::create(['classe_id' => $class_sondage->id, 'position' => 1, 'lib' => 'Sondage']);
            //     $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
            //     $group = GroupeAttribute::create(['classe_id' => $class_sondage->id, 'position' => 1, 'lib' => 'Sondage ' . $class_sondage->id, 'attr' => '{"className":"grid gap-4"}', 'component_id_multi' => $gac->id, 'component_id_unique' => $gac->id]);
            //     $comment_group = GroupeAttribute::create(['classe_id' => $class_sondage->id, 'position' => 2, 'lib' => 'Commentaire','attr' => '{"className":"grid gap-4"}', 'component_id_multi' => $gac->id, 'component_id_unique' => $gac->id]);
            //     $attribute_sub = Attribute::create([
            //         'tech_name' => 'commentaire'.$class_sondage->tech_name,
            //         'classe_id' => $class_sondage->id,
            //         'groupe_attribute_id' => $comment_group->id,
            //         'lib' => 'Commentaire',
            //         'position' => 1,
            //         'required' => 0,
            //         'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.TextArea'])->first()->id,
            //         'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
            //         'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
            //     ]);

            //     // création du formulaire par defaut 
            //     $class_sondage->defaultQuestions();
            //     //creation du data pour lier le sondage avec la formation id_sondage_formation
            //     $id_sondage_formation = Attribute::where(['tech_name' => 'id_sondage_formation'])->first()->id;
            //     Data::create(['instance_id' => $instance->id, 'class_id' => $class->id, 'value' => $data['lib'], 'classe_id_src'=> $class_sondage->id, 'attribute_id' => $id_sondage_formation]);
            // }
            return response()->json(['code' => 200, 'message' => $class_tech_name.' cree avec succes' ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['code' => 404, 'message' => $th->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function put(Request $request , $company_uid, $lang_iso ,$class_tech_name, $instance_id)
    {
        
        $token = $request->header('API-KEY');
        // dd($token);
        
	if ($token != $this->key_api) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $company = null;
            // $lang = null;
            if ($company_uid != null) {
                # code...
                $company = Company::where(['uid' => $company_uid])->first();
            }
            
            $class = null;
            if($class_tech_name != null) {
                $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            }
            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            $instance = Instance::where(['id' => $instance_id, 'classe_id' => $class->id])->first();
            if ($instance == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'L\'instance '.$instance_id.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            // dd($instance->datas()->get());
            $data = $request->json()->all()['data'];
            if ($class_tech_name =='formation') {
                //On va dater la creation de la formation 
                try {
                    //code...
                    $data['date_modification'] = date('d/m/Y H:i:s');
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }
            foreach ($data as $key => $value) {
                $attribute = Attribute::where(['tech_name' => $key, 'classe_id' => $class->id])->first();
                $attribute->managerAttributeSimpleData($value, $instance->id,"data");
            }
            return response()->json(['code' => 200, 'message' => 'Succès' ], Response::HTTP_OK);
    }

    public function delete(Request $request, $company_uid , $lang_iso , $class_tech_name , $instance_id = null)
    {
        $token = $request->header('API-KEY');
        // dd($token);
        
	if ($token != $this->key_api) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
        }
        try {
            //code...
            $company = null;
            $lang = null;
            if ($company_uid != null) {
                # code...
                $company = Company::where(['uid' => $company_uid])->first();
            }

            if ($lang_iso != null) {
                # code...
                $lang = Lang::where(['iso' => $lang_iso])->first();
            }
            $class = null;
            if($class_tech_name != null) {
                $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            }

            $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ], Response::HTTP_NOT_FOUND);
            }
            $instance = Instance::where(['id' => $instance_id])->first();
            $datas = Data::where(['instance_id' => $instance->id])->orderBy('created_at', 'desc')->get();
            foreach ($datas as $key => $data) {
                # code...
                $data_langs = DataLang::where(['data_id' => $data->id])->get();
                foreach ($data_langs as $key => $data_lang) {
                    # code...
                    $data_lang->delete();
                }
                $data->delete();
            }
            $instance->delete();
            return response()->json(['code' => 200, 'message' => 'Succès' ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            // return response()->json(['code' => 404, 'message' => 'Echec' ], Response::HTTP_NOT_FOUND);
            return response()->json(['code' => 404, 'message' => $th->getMessage() ], Response::HTTP_NOT_FOUND);
        }
    }

    public function postSondage(Request $request, $company_uid = null, $lang_iso = null, $class_tech_name = null, $instance_id = null)
    {
        try {
            //code...
            $company = null;
            $lang = null;
            if ($company_uid != null) {
                # code...
                $company = Company::where(['uid' => $company_uid])->first();
            }
            
            if ($lang_iso != null) {
                # code...
                $lang = Lang::where(['iso' => $lang_iso])->first();
            }
            $class = null;
            if($class_tech_name != null) {
                $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            }

            if ($class == null) {
                # code...
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }

            $instance = null;
            $data_create_ins = ['classe_id' => $class->id, 'parent_id' => null];

            $instance = Instance::create($data_create_ins);
            // $data = $request->json()->all()['data'];
            $data = $this->convertJSONArrays($request->json()->all())['data'];
            // dd($data);
            foreach($data as $key => $value) {
                $attribute = Attribute::where(['tech_name' => $key, 'classe_id' => $class->id])->first();
                // dump($key, $attribute, );
                $attribute->managerAttributeSimpleData($value, $instance->id);
            }

            return response()->json(['code' => 200, 'message' => $class_tech_name.' cree avec succes' ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['code' => 404, 'message' => $th->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }


    public function getSondage(Request $request, $company_uid ,$lang_iso, $class_tech_name ,   $instance_id = null)
    {   
        $page = $request->input('page');
        if (count(explode('/',($class_tech_name))) == 1) {
            # code...
            $instance_id = null;
        }else {
            $instance_id = explode('/',($class_tech_name))[1];
            $class_tech_name = explode('/',($class_tech_name))[0];
        }
        
        $company = null;
        $lang = null;
        if ($company_uid != null) {
            # code...
            $company = Company::where(['uid' => $company_uid])->first();
        }

        if ($lang_iso != null) {
            # code...
            $lang = Lang::where(['iso' => $lang_iso])->first();
        }
        if($class_tech_name != null) {
            $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
            if ($class == null) {
                return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
            }
            $form_empty = false;
            if ($instance_id == "0") {
                $form_empty = true;
            }
            //on les charge dans le tableau infusioJson
            // dd($form_empty, $instance_id,$lang->id);
            $me = $class->me($lang->id,$instance_id, $form_empty);
            $infusioJson = [
                'class' => $me['class'],
                'groupe_attributes' => $class->getmyAttributeGroups($lang->id,null),
                'instances' =>$class->getmyInstances($lang->id,$instance_id,$form_empty, $class->tech_name),
            ];
            return response()->json($infusioJson,Response::HTTP_OK);
            // return response()->json(['code' => 200, 'message' => 'Succès' ], Response::HTTP_OK);
        }
        // $component = Infusio::renderComponent('com.webtinix.infusio.server.DataTable');
    }

    public function convertJSONArrays($array)
    {
        foreach ($array as $key => $value) {
            if (is_string($value) && strpos($value, '[') === 0) {
                $array[$key] = json_decode($value);
            } elseif (is_array($value)) {
                $array[$key] = $this->convertJSONArrays($value);
            }
        }
        // dd($array);
        return $array;
    }

    public function getTotalSondage(Request $request, $company_uid ,$lang_iso, $class_tech_name)
    {

        $class = Classe::where(['tech_name' => $class_tech_name])->first();
        $i = Instance::where(['classe_id' => $class->id])->orderBy('created_at', 'desc')->get();
        return response()->json([ 'total_result' => $i->count() ],Response::HTTP_OK);
    }




    // Cette fonction est aussi utiliser du côté du Front pour le traitement des chaines
    // public function nettoyerChaine($chaine) {
    //     $chaine = str_replace(' ', '_', $chaine);
    //     $chaine = preg_replace('/[\x{0300}-\x{036f}\W]/u', '', normalizer_normalize($chaine, \Normalizer::FORM_D));
    //     return $chaine;
    // }
    // public function getDate() {
    //     $maintenant = new DateTime(); // Créer un nouvel objet DateTime
    //     $annee = $maintenant->format('Y'); // Année sur quatre chiffres
    //     $mois = $maintenant->format('n'); // Mois (de 1 à 12)
    //     $jour = $maintenant->format('j'); // Jour du mois (de 1 à 31)
    //     $heure = $maintenant->format('G'); // Heure (de 0 à 23)
    //     $minute = $maintenant->format('i'); // Minute (de 0 à 59)
    //     $seconde = $maintenant->format('s'); // Seconde (de 0 à 59)
    //     return $annee.$mois.$jour.$heure.$minute.$seconde;
    // } 


    // public function getInscription(Request $request, $company_uid ,$lang_iso, $class_tech_name ,   $instance_id = null)
    // {   
    //     $page = $request->input('page');
    //     if (count(explode('/',($class_tech_name))) == 1) {
    //         # code...
    //         $instance_id = null;
    //     }else {
    //         $instance_id = explode('/',($class_tech_name))[1];
    //         $class_tech_name = explode('/',($class_tech_name))[0];
    //     }
        
    //     $company = null;
    //     $lang = null;
    //     if ($company_uid != null) {
    //         # code...
    //         $company = Company::where(['uid' => $company_uid])->first();
    //     }

    //     if ($lang_iso != null) {
    //         # code...
    //         $lang = Lang::where(['iso' => $lang_iso])->first();
    //     }
    //     if($class_tech_name != null) {
    //         $class = Classe::where(['tech_name' => $class_tech_name, 'company_id' => $company->id])->first();
    //         if ($class == null) {
    //             return response()->json(['code' => 404, 'message' => 'La classe '.$class_tech_name.' n\'existe pas' ],Response::HTTP_NOT_FOUND);
    //         }
    //         $form_empty = false;
    //         if ($instance_id == "0") {
    //             $form_empty = true;
    //         }
    //         //on les charge dans le tableau infusioJson
    //         // dd($form_empty, $instance_id,$lang->id);
    //         $me = $class->me($lang->id,$instance_id, $form_empty);
    //         $infusioJson = [
    //             'class' => $me['class'],
    //             'groupe_attributes' => $class->getmyAttributeGroups($lang->id,null),
    //             'instances' =>$class->getmyInstances($lang->id,$instance_id,$form_empty, $class->tech_name),
    //         ];
    //         return response()->json($infusioJson,Response::HTTP_OK);
    //         // return response()->json(['code' => 200, 'message' => 'Succès' ], Response::HTTP_OK);
    //     }
    //     // $component = Infusio::renderComponent('com.webtinix.infusio.server.DataTable');
    // }
}
