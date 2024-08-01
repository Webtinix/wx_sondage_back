<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Lang;
use App\Models\Classe;
use App\Models\Instance;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeLang;
use App\Models\Component;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        // try {
            if ($id) {
                # code...
                $attribute = Attribute::findOrFail($id);
                return response()->json(['attributes' => $attribute, 'class' => $attribute->class]);
            }
            // Récupérer toutes les instances de la ressource Attribute
            $attributes = Attribute::all();
            
            // Retourner une réponse JSON avec les attributs récupérés
            return response()->json(['attributes' => $attributes]);
        // } catch (\Exception $e) {
        //     // En cas d'erreur, retourner une réponse avec un message d'erreur
        //     return response()->json(['error' => 'Une erreur est survenue lors de la récupération des attributs.'], 500);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function post(Request $request)
    {
        // try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'lib' => 'required|string',
                'tech_name' => 'required|string',
                'position' => 'required|integer',
                'attr' => 'nullable|string',
                'attr_label' => 'nullable|string',
                'render_in' => 'nullable|string',
                'module_in' => 'nullable|string',
                'render_out' => 'nullable|string',
                'module_out' => 'nullable|string',
                'is_lang' => 'nullable|boolean',
                'actif' => 'nullable|boolean',
                'visible' => 'nullable|boolean',
                'list_visible' => 'nullable|boolean',
                'disabled' => 'nullable|boolean',
                'classe_id' => 'nullable|integer',
                'groupe_attribute_id' => 'required|integer',
                'classe_src_id' => 'nullable|integer',
                'component_id' => 'nullable|string',
                'component_id_multi' => 'nullable|integer',
                'component_id_unique' => 'nullable|integer',
            ]);
            // dd($request->json()->all()['instance_src']);
            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);

            }
            $data_att = $request->json()->all();
            if (empty($request->json()->all()['classe_id'])) {
                # code...
                $class = GroupeAttribute::findOrFail($request->json()->all()['groupe_attribute_id']);
                // dd($class->classe_id);
                $data_att['classe_id'] = $class->classe_id;
            }

            if (empty($request->json()->all()['component_id_multi'])) {
                # code...
                $data_att['component_id_multi'] = 1;
            }else {
                # code...
                $data_att['component_id_multi'] = Component::where(['lib' => $request->json()->all()['component_id_multi']])->first()->id;
            }

            if (empty($request->json()->all()['component_id_unique'])) {
                # code...
                $data_att['component_id_unique'] = 3;
            }else {
                # code...
                $data_att['component_id_unique'] = Component::where(['lib' => $request->json()->all()['component_id_unique']])->first()->id;
            }

            if (empty($request->json()->all()['component_id'])) {
                # code...
                $data_att['component_id'] = 4;
            }else {
                # code...
                $data_att['component_id'] = Component::where(['lib' => $request->json()->all()['component_id']])->first()->id;
            }

            // Créer une nouvelle instance de l'attribut
            $attribute = Attribute::create($data_att);
            if (empty($request->json()->all()['is_lang']) or $request->json()->all()['is_lang'] == true) {
                # code...
                $lang = Lang::where(['iso' => 'fr'])->first();
                    # code...
                $attributelang = AttributeLang::create(['attribute_id' => $attribute->id, 'lang_id' => $lang->id, 'lib' => $request->json()->all()['lib']]);
            }
            $class_sub = null;
            //on verifie si la clé  instance_src existe dans le json de la requête
            if (!empty($request->json()->all()['instance_src']) && $request->json()->all()['instance_src'] != "") {
                //on recupere l'id de la classe
                $data = json_decode($request->json()->all()['instance_src'],true);
                if (!empty($data['tech_name_class'])) {
                    $class_sub = Classe::where(['tech_name' =>  $data['tech_name_class']])->first();
                    if (empty($class_sub)) {
                        # code...
                        $class_sub = Classe::create([
                            'tech_name' =>  $data['tech_name_class'],
                            'lib' =>  $data['lib'], 
                            'company_id' => 1,
                            'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                            'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                        ]);
                    }
                }
                $attribute->classe_src_id =  $class_sub->id;
                $attribute->save();
                //create du groupe de l'attribut
                $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
                $groupeAttribute = GroupeAttribute::create([
                    'classe_id' => $class_sub->id,
                    'position' => 1,
                    'component_id_multi' => $gac->id,
                    'component_id_unique' => $gac->id,
                    'lib' => $data['lib'],
                    ]);

                // dd($data['values']);
                foreach ($data['values'] as $key_ => $value) {
                    $instance = Instance::create([
                        'classe_id' => $class_sub->id,
                    ]);
                    foreach ($value as $key => $val) {
                        
                        if ($key == 'id') {
                            continue;
                        }
                        
                        $attribute_sub = Attribute::where(['tech_name' => $key, 'classe_id' => $class_sub->id])->first();

                    ///-----creation de l'instance-----
                        if ($attribute_sub == null) {
                            # code...
                            $attribute_sub = Attribute::create([
                                'lib' => $val['lib'],
                                'tech_name' => $key,
                                'classe_id' => $class_sub->id,
                                'groupe_attribute_id' => $groupeAttribute->id,
                                'position' => 1,
                                'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                                'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                                'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                            ]);
                        }
                    //-----creation du data----------
                    if (is_array($val['value'])) {
                        # code...
                        foreach ($val['value'] as $k => $v) {
                            # code...
                            $value_sub = Data::create([
                                'attribute_id' => $attribute_sub->id,
                                'class_id' => $class_sub->id,
                                'value' => $v,
                                'instance_id' => $instance->id,
                            ]);
                        } 
                    }else {
                        # code...
                        $value_sub = Data::create([
                            'attribute_id' => $attribute_sub->id,
                            'class_id' => $class_sub->id,
                            'value' => $val['value'],
                            'instance_id' => $instance->id,
                        ]);
                    }
                        
                    }
                }
                
            }
            // Retourner une réponse JSON avec l'attribut créé
            return response()->json(['message' => 'Attribut créé avec succès.', 'code' => '200' ], Response::HTTP_OK);
        // } catch (\Exception $e) {
        //     // En cas d'erreur, retourner une réponse avec un message d'erreur
        //     return response()->json(['error' => 'Une erreur est survenue lors de la création de l\'attribut.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function put(Request $request, string $id)
    {
        try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), [
                'tech_name' => 'required|string',
                'position' => 'required|integer',
                'attr' => 'nullable|string',
                'attr_label' => 'nullable|string',
                'render_in' => 'nullable|string',
                'module_in' => 'nullable|string',
                'render_out' => 'nullable|string',
                'module_out' => 'nullable|string',
                'is_lang' => 'nullable|boolean',
                'actif' => 'nullable|boolean',
                'visible' => 'nullable|boolean',
                'list_visible' => 'nullable|boolean',
                'disabled' => 'nullable|boolean',
                'classe_id' => 'nullable|integer',
                'groupe_attribute_id' => 'nullable|integer',
                'classe_src_id' => 'nullable|integer',
                'component_id' => 'nullable|string',
                'component_id_multi' => 'nullable|string',
                'component_id_unique' => 'nullable|string',
            ]);

            // Vérifier si la validation a échoué
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $data_att = $request->json()->all();
            if (empty($request->json()->all()['classe_id'])) {
                # code...
                $class = GroupeAttribute::findOrFail($request->json()->all()['groupe_attribute_id']);
                // dd($class->classe_id);
                $data_att['classe_id'] = $class->classe_id;
            }

            if (empty($request->json()->all()['component_id_multi'])) {
                $data_att['component_id_multi'] = 1;
            }else {
                # code...
                $data_att['component_id_multi'] = Component::where(['lib' => $request->json()->all()['component_id_multi']])->first()->id;
            }

            if (empty($request->json()->all()['component_id_unique'])) {
                # code...
                $data_att['component_id_unique'] = 3;
            }else {
                # code...
                $data_att['component_id_unique'] = Component::where(['lib' => $request->json()->all()['component_id_unique']])->first()->id;
            }

            if (empty($request->json()->all()['component_id'])) {
                # code...
                $data_att['component_id'] = 4;
            }else {
                # code...
                $data_att['component_id'] = Component::where(['lib' => $request->json()->all()['component_id']])->first()->id;
            }


            // Récupérer l'attribut spécifié par son ID
            $attribute = Attribute::findOrFail($id);
             // Mettre à jour les attributs de l'attribut avec les nouvelles données JSON
            $attribute->update($data_att);
            $clnew = false;
            $class_sub = null;
            $gac = Component::where(['lib' => 'com.webtinix.infusio.GroupeAttributes'])->first();
                //on verifie si la clé  instance_src existe dans le json de la requête
                if (!empty($request->json()->all()['instance_src']) && $request->json()->all()['instance_src'] != "") {
                    $data = json_decode($request->json()->all()['instance_src'],true);
                    if (!empty($data['tech_name_class'])) {
                        $class_sub = Classe::where(['tech_name' =>  $data['tech_name_class']])->first();
                        if (empty($class_sub)) {
                            # code...
                            $class_sub = Classe::create([
                                'tech_name' =>  $data['tech_name_class'],
                                'lib' =>  $data['lib'], 
                                'company_id' => 1,
                                'component_multi_id' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                                'component_unique_id' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                            ]);
                            $groupeAttribute = GroupeAttribute::create([
                                'classe_id' => $class_sub->id,
                                'position' => 1,
                                'component_id_multi' => $gac->id,
                                'component_id_unique' => $gac->id,
                                'lib' => $data['lib'],
                                ]);
                            $clnew = true;
                        }
                    }
                    //create du groupe de l'attribut

                    foreach ($data['values'] as $key_ => $value) {
                        if (!empty($value['id'])) {
                            # code...
                            $instance = Instance::where(['id' => $value['id']])->first();
                        }else {
                            # code...
                            $instance = Instance::create([
                                'classe_id' => $class_sub->id,
                            ]);
                        }
                        foreach ($value as $key => $val) {
                            if ($key == 'id') {
                                continue;
                            }
                        ///-----creation de l'instance-----
                            $attribute_sub = Attribute::where(['tech_name' => $key])->first();
                            if (empty($attribute_sub)) {
                                $attribute_sub = Attribute::create([
                                    'lib' => $val['lib'],
                                    'tech_name' => $key,
                                    'classe_id' => $class_sub->id,
                                    'groupe_attribute_id' => $groupeAttribute->id,
                                    'position' => 1,
                                    'component_id' =>  Component::where(['lib' => 'com.webtinix.infusio.server.InputText'])->first()->id,
                                    'component_id_multi' => Component::where(['lib' => 'com.webtinix.infusio.server.DataTable'])->first()->id,
                                    'component_id_unique' => Component::where(['lib' => 'com.webtinix.infusio.server.Form'])->first()->id,
                                ]);
                            }
                            //-----creation du data----------
                            $dt = Data::where(['attribute_id' => $attribute_sub->id, 'class_id' => $class_sub->id, 'instance_id' => $instance->id])->first();

                            // Si on nous demande de supprimer l'instance
                            if (isset($val['deleted']) && !empty($val['deleted']) && $val['deleted'] == 1) {
                                if (!empty($dt)) {
                                    # code...
                                    $dt->delete();
                                }
                                $instance->delete();
                                // # code...
                            }else{
                                if (empty($dt)) {
                                    $value_sub = Data::create([
                                        'attribute_id' => $attribute_sub->id,
                                        'class_id' => $class_sub->id,
                                        'value' => $val['value'],
                                        'instance_id' => $instance->id,
                                    ]);
                                }else{
                                    $dt->value = $val['value'];
                                    $dt->save();
                                }
                            }
                        }
                    }
                    
                }
            // Retourner une réponse JSON avec un message de succès
                return response()->json(['code' => 200, 'message' => 'Attribut mis à jour avec succès.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404, 'message' => 'Une erreur est survenue lors de la mise à jour de l\'attribut.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            // Récupérer l'attribut spécifié par son ID
            $attribute = Attribute::findOrFail($id);
            // Supprimer tous les données liees à l'attribut
            foreach ($attribute->attributeLangs()->get() as $key => $value) {
                # code...
                $value->delete();
            }
            // Supprimer l'attribut
            $attribute->delete();
            // Retourner une réponse JSON avec un message de succès
            return response()->json(['code' => 200, 'message' => 'Attribut supprimé avec succès.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['code' => 404,'message' => 'Une erreur est survenue lors de la suppression de l\'attribut.'], Response::HTTP_NOT_FOUND);
        }
    }
}
