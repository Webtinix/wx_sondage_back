<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class GroupeAttribute extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'classe_id',
        'position',
        'attr',
        'component_id_multi',
        'component_id_unique',
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function me($lang_id, $instance = null){
        $result_tab = [
                'id' =>$this->id,
                'lib' => $this->lib,
                'position' =>$this->position,
                'attr' =>$this->attr,
                'classe_id' =>$this->classe_id,
                'component_multi' => $this->component_id_multi,
                'component_unique' => $this->component_id_unique,
                'attributes' => []
            ];

            if (is_numeric($this->component_id_multi)) {
                # code...
                $result_tab['component_multi'] = Component::where(['id' => $this->component_id_multi])->first(); 
                $result_tab['component_multi'] = $result_tab['component_multi']->lib;
            }
            if (is_numeric($this->component_id_unique)) {
                # code...
                $result_tab['component_unique'] = Component::where(['id' => $this->component_id_unique])->first();
                $result_tab['component_unique'] = $result_tab['component_unique']->lib;
            }

            $attributes = Attribute::where(['groupe_attribute_id' => $this->id])->orderBy('position', 'ASC')->get();
            foreach ($attributes as $key => $value) {
                # code...
                $result_tab['attributes'][] = $value->ma($lang_id);
                // dd($value->ma($lang_id));
            }
            return $result_tab;
    }
}
