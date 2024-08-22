<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Lang;
use App\Models\Classe;
use App\Models\Instance;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeLang;
use App\Models\Company;
use App\Models\Component;
use Illuminate\Http\Response;
use App\Models\GroupeAttribute;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    private $_instance_pre = null; 
    /**
     * Display a listing of the resource.
     */
    public function get($id = null)
    {
        try {
            if ($id) {
                # code...
                $attribute = Attribute::findOrFail($id);
                return response()->json(['attributes' => $attribute, 'class' => $attribute->class]);
            }
            // Récupérer toutes les instances de la ressource Attribute
            $attributes = Attribute::all();
            
            // Retourner une réponse JSON avec les attributs récupérés
            return response()->json(['attributes' => $attributes]);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des attributs.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function post(Request $request)
    {
        try {
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


                # code...
            $data_att['tech_name'] = Str::slug($request->json()->all()['tech_name'] , '-'). time();
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
                            'company_id' => Company::all()->first()->id,
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

                foreach ($data['values'] as $key_ => $value) {
                    $instance = Instance::create([
                        'classe_id' => $class_sub->id,
                    ]);
                    foreach ($value as $key => $val) {
                        
                        if ($key == 'id') {
                            continue;
                        }
                        
                        $attribute_sub = Attribute::where(['tech_name' => $key, 'classe_id' => $class_sub->id])->first();
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
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse avec un message d'erreur
            return response()->json(['error' => 'Une erreur est survenue lors de la création de l\'attribut.', 'message' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function put(Request $request, string $id)
    { 
        // try {
            // Valider les données JSON de la requête
            $validator = Validator::make($request->json()->all(), $this->validationRules());
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Récupérer les données JSON de la requête
            $data = $request->json()->all();

            // Gérer les valeurs par défaut
            $data['class_id'] = $data['class_id'] ?? $this->getClassId($data['groupe_attribute_id']);
            $data['component_id_multi'] = $this->getComponentId($data['component_id_multi']?? null, 1);
            $data['component_id_unique'] = $this->getComponentId($data['component_id_unique']?? null, 3);
            $data['component_id'] = $this->getComponentId($data['component_id'] ?? null, 4);

            // Mettre à jour l'attribut
            $attribute = Attribute::findOrFail($id);
            $attribute->update($data);

            // Gérer les instances si `instance_src` est présent
            if (!empty($data['instance_src'])) {
                $this->handleInstanceSrc($data['instance_src'], $attribute);
            }

            // Retourner une réponse JSON avec un message de succès
            return response()->json(['code' => 200, 'message' => 'Attribut mis à jour avec succès.'], Response::HTTP_OK);
        // } catch (\Exception $e) {
        //     // En cas d'erreur, retourner une réponse avec un message d'erreur
        //     return response()->json(['code' => 404, 'message' => $e], Response::HTTP_NOT_FOUND);
        // }
    }

    private function validationRules()
    {
        return [
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
        ];
    }

    private function getClassId($groupeAttributeId)
    {
        $class = GroupeAttribute::findOrFail($groupeAttributeId);
        return $class->classe_id;
    }

    private function getComponentId($componentLib, $default)
    {
        if (empty($componentLib)) {
            return $default;
        }
        return Component::where('lib', $componentLib)->first()->id ?? $default;
    }

    private function handleInstanceSrc($instanceSrc, $attribute)
    {
        $data = json_decode($instanceSrc, true);
        $this->removeDeletedAttributes($data);
        $class = $this->getOrCreateClass($data['tech_name_class'] ?? null, $data['lib'] ?? null);
        
        $attribute->classe_src_id = $class[0]->id;
        $attribute->save();
        $groupeAttribute = null;
        if ($class[1] == true) {
            # code...
            $groupeAttribute = $this->createGroupeAttribute($class[0]->id, $data['lib']);
        }else {
            # code...
            $groupeAttribute = $class[2];
        }
        
        $this->createInstancesAndData($data['values'], $class[0]->id, $groupeAttribute->id);
    }

    function transformTab($tab) : array{
        $tab_result = [];
        foreach ($tab as $key => $value) {
            # code...
            $tab_result[] = $value;
        }
        return $tab_result;
    }
    private function removeDeletedAttributes(&$data)
    {
        // $this->_instance_pre = 12;
        // Parcourt les valeurs dans le tableau 'values'
        foreach ($data['values'] as $key_ => $value) {
            // Vérifie si l'ID est présent et non nul
            if (isset($value['id']) && !is_null($value['id']) && is_numeric($value['id'])) {
                $this->_instance_pre = Instance::where('id', $value['id'])->first();
                unset($data['values'][$key_]);
                if (!key_exists('deleted', $this->transformTab($value)[1])) {
                    continue;
                }
            }
            // if () {
                // Vérifie chaque attribut du tableau pour voir si 'deleted' est défini et égal à 1
            foreach ($value as $key => $val) {
                if (isset($val['deleted']) && $val['deleted'] == 1) {
                    // Supprime les attributs et les instances liés
                    $this->deleteAttributeAndInstances($key, $value['id']);
                    // Supprime l'élément du tableau principal
                    unset($data['values'][$key_]);
                    break; // Sort de la boucle après la suppression
                }
            }
            // }
                // dd($this->_instance_pre);
            
        }
        // Réindexe le tableau après la suppression
        $data['values'] = array_values($data['values']);
        // dd($data);
    }

    private function deleteAttributeAndInstances($techName, $id_instance_delete = null)
    {
        $attribute = Attribute::where('tech_name', $techName)->first();
        if ($attribute) {
            $groupeAttribute = $attribute->groupeAttribute;
            $groupeAttribute->attributes()->each(function($attribute) {
                // Supprimer les données associées
                $attribute->datas()->each(function($data) {
                    $data->delete();
                });
                $attribute->delete();
            });
            $groupeAttribute->delete();
            if ($id_instance_delete) {
                $i = Instance::where('id', $id_instance_delete)->first()->delete();
            }
        }
    }

    private function getOrCreateClass($techName, $lib)
    {
        $class = null;
        if (!empty($this->_instance_pre)) {
            # code...
            $class = Classe::where('tech_name', $this->_instance_pre->classe()->first()->tech_name)->first();
        }
        // dd($class);
        $new = false;
        $g = null;
        if ($class == null) {
            $class = Classe::create([
                'tech_name' => $techName,
                'lib' => $lib,
                'company_id' => Company::first()->id,
                'component_multi_id' => Component::where('lib', 'com.webtinix.infusio.server.DataTable')->first()->id,
                'component_unique_id' => Component::where('lib', 'com.webtinix.infusio.server.Form')->first()->id,
            ]);

            $new = true;
        }else{
            $g = GroupeAttribute::where('classe_id', $class->id)->first();
        }

        return [$class, $new, $g];
    }

    private function createGroupeAttribute($classId, $lib)
    {
        $gac = Component::where('lib', 'com.webtinix.infusio.GroupeAttributes')->first();
        return GroupeAttribute::create([
            'classe_id' => $classId,
            'position' => 1,
            'component_id_multi' => $gac->id,
            'component_id_unique' => $gac->id,
            'lib' => $lib,
        ]);
    }

    private function createInstancesAndData($values, $classId, $groupeAttributeId)
    {
        foreach ($values as $valueSet) {
            $instance = Instance::create(['classe_id' => $classId]);
            foreach ($valueSet as $key => $val) {
                if ($key == 'id') continue;

                $attribute = Attribute::where('tech_name', $key)->first();
                if (empty($attribute))
                    $attribute = Attribute::create([
                        'tech_name' => $key,
                        'classe_id' => $classId,
                        'groupe_attribute_id' => $groupeAttributeId,
                        'position' => 1,
                        'component_id' => Component::where('lib', 'com.webtinix.infusio.server.InputText')->first()->id,
                        'component_id_multi' => Component::where('lib', 'com.webtinix.infusio.server.DataTable')->first()->id,
                        'component_id_unique' => Component::where('lib', 'com.webtinix.infusio.server.Form')->first()->id,
                    ]);
                // $attribute = Attribute::firstOrCreate([
                //     'tech_name' => $key,
                //     'classe_id' => $classId,
                // ], [
                //     'lib' => $val['lib'] ?? '',
                //     'groupe_attribute_id' => $groupeAttributeId,
                //     'position' => 1,
                //     'component_id' => Component::where('lib', 'com.webtinix.infusio.server.InputText')->first()->id,
                //     'component_id_multi' => Component::where('lib', 'com.webtinix.infusio.server.DataTable')->first()->id,
                //     'component_id_unique' => Component::where('lib', 'com.webtinix.infusio.server.Form')->first()->id,
                // ]);

                $this->createData($val['value'], $attribute->id, $instance->id, $classId);
            }
        }
    }

    private function createData($values, $attributeId, $instanceId, $classId)
    {
        if (is_array($values)) {
            foreach ($values as $value) {
                Data::create([
                    'attribute_id' => $attributeId,
                    'class_id' => $classId,
                    'value' => $value,
                    'instance_id' => $instanceId,
                ]);
            }
        } else {
            Data::create([
                'attribute_id' => $attributeId,
                'class_id' => $classId,
                'value' => $values,
                'instance_id' => $instanceId,
            ]);
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
