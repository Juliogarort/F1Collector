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
        // Verificar si la escala está siendo utilizada por algún producto
        $productsUsingScale = Product::where('scale_id', $scale->id)->count();
        
        if ($productsUsingScale > 0) {
            return redirect()->route('admin.scales.index')
                ->with('error', 'No se puede eliminar la escala "' . $scale->value . '" porque está siendo utilizada por ' . $productsUsingScale . ' producto(s).');
        }

        // Si no hay productos asociados, eliminar la escala
        $scale->delete();
        
        return redirect()->route('admin.scales.index')
            ->with('success', 'Escala eliminada correctamente.');
    }
}
