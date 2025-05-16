<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; 



class Scale extends Model
{
    protected $table = 'f1collector_scales';

    protected $fillable = ['value'];

    public function products()
    {
        return $this->hasMany(Product::class, 'scale_id');
    }

    public function deleteScale(Scale $scale)
    {
        $productsUsingScale = Product::where('scale_id', $scale->id)->count();

        $scale->delete();

        return redirect()->route('admin.scales.index')->with('success', 
            'Escala eliminada correctamente. ' .
            ($productsUsingScale > 0 
                ? "⚠️ Recuerda que $productsUsingScale producto(s) tenían esta escala. Ahora están sin asignar. Edita los productos para asignarles una nueva escala." 
                : "")
        );
    }

}
