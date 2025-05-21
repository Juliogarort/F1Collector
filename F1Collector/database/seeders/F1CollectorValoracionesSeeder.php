<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class F1CollectorValoracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs existentes para crear relaciones válidas con el prefijo correcto
        $userIds = DB::table('f1collector_users')->pluck('id')->toArray();
        $productIds = DB::table('f1collector_products')->pluck('id')->toArray();
        $orderIds = DB::table('f1collector_orders')->pluck('id')->toArray();
        
        // Si no hay datos suficientes para crear valoraciones, salir
        if (empty($userIds) || empty($productIds) || empty($orderIds)) {
            $this->command->info('No hay suficientes datos para crear valoraciones. Asegúrate de tener usuarios, productos y pedidos.');
            return;
        }

        // Comentarios para valoraciones
        $comentariosPositivos = [
            'Excelente modelo con acabados excepcionales. Los detalles son impresionantes. ¡Muy recomendable para cualquier coleccionista!',
            'Increíble calidad de fabricación. Los colores son exactamente como en la Fórmula 1 real.',
            'Gran relación calidad-precio. El packaging y la presentación son de primera clase.',
            'Cada detalle está perfectamente replicado. Merece la pena cada euro.',
            'El modelo llegó perfectamente embalado. La aerodinámica está representada con precisión milimétrica.',
            'Supera mis expectativas. Los logos de los patrocinadores están perfectamente impresos.',
            'Una pieza de colección excepcional. Los neumáticos tienen un nivel de detalle asombroso.',
            'La pintura y los acabados son de altísima calidad. No hay imperfecciones visibles.',
        ];

        $comentariosMedios = [
            'Buen modelo en general, aunque algunos detalles podrían estar mejor acabados.',
            'La calidad es buena, pero el precio es un poco elevado para lo que ofrece.',
            'El modelo está bien, pero el embalaje llegó con algunos daños menores.',
            'Buena reproducción del original, aunque algunos detalles de la aerodinámica no son 100% precisos.',
            'Diseño bonito y bien ejecutado, pero le faltan algunos detalles en el cockpit.',
            'El modelo está a la altura de lo esperado, aunque he visto mejores acabados en otros modelos similares.',
            'Buena pieza para la colección, pero los neumáticos parecen un poco menos detallados de lo que esperaba.',
        ];

        $comentariosNegativos = [
            'La calidad no justifica el precio. Hay detalles que deberían estar mejor acabados.',
            'Esperaba más por el precio pagado. Los adhesivos de los patrocinadores no están bien alineados.',
            'Decepcionante. La pintura tiene imperfecciones visibles en varias zonas.',
            'El modelo no se corresponde exactamente con las fotos mostradas en la web.',
            'Llegó con algunas piezas pequeñas rotas. El embalaje podría ser mejor.',
        ];

        // Limpiar tabla si ya tiene datos
        try {
            DB::table('f1collector_valoraciones')->truncate();
            $this->command->info('Tabla de valoraciones limpiada correctamente.');
        } catch (\Exception $e) {
            $this->command->warn('No se pudo limpiar la tabla: ' . $e->getMessage());
            // Si no se puede truncar, intentamos eliminar todos los registros
            DB::table('f1collector_valoraciones')->delete();
            $this->command->info('Registros de valoraciones eliminados correctamente.');
        }
        
        // Crear valoraciones para los productos
        $valoraciones = [];
        $fechaActual = Carbon::now();
        
        // Asignar usuarios únicos a productos para respetar la restricción de clave única
        // Mezclamos los usuarios para asignarlos aleatoriamente
        shuffle($userIds);
        
        // Para cada producto, aseguramos que tenga al menos una valoración
        foreach ($productIds as $index => $productId) {
            // Usar módulo para asignar usuarios de forma cíclica si hay más productos que usuarios
            $userId = $userIds[$index % count($userIds)];
            $orderId = $orderIds[array_rand($orderIds)];
            
            // Determinar puntuación y seleccionar comentario apropiado
            $puntuacion = rand(3, 5); // Más probabilidad de valoraciones positivas
            
            if ($puntuacion >= 4) {
                $comentario = $comentariosPositivos[array_rand($comentariosPositivos)];
            } elseif ($puntuacion == 3) {
                $comentario = $comentariosMedios[array_rand($comentariosMedios)];
            } else {
                $comentario = $comentariosNegativos[array_rand($comentariosNegativos)];
            }
            
            // Crear valoración
            $valoraciones[] = [
                'user_id' => $userId,
                'product_id' => $productId,
                'order_id' => $orderId,
                'puntuacion' => $puntuacion,
                'comentario' => $comentario,
                'compra_verificada' => true,
                'aprobada' => true,
                'created_at' => $fechaActual->copy()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'updated_at' => $fechaActual->format('Y-m-d H:i:s'),
            ];
        }
        
        // Para añadir más valoraciones, necesitamos asegurarnos de que no haya duplicados de usuario-producto
        // Creamos un mapa de las combinaciones ya utilizadas
        $combinacionesUsadas = [];
        foreach ($valoraciones as $val) {
            $combinacionesUsadas[$val['user_id'] . '-' . $val['product_id']] = true;
        }
        
        // Intentamos añadir más valoraciones aleatorias respetando la restricción única
        $intentosMaximos = 100; // Para evitar bucles infinitos
        $valoracionesAdicionales = min(30, count($userIds) * count($productIds) - count($valoraciones)); 
        $valoracionesAgregadas = 0;
        $intentos = 0;
        
        while ($valoracionesAgregadas < $valoracionesAdicionales && $intentos < $intentosMaximos) {
            $intentos++;
            
            $userId = $userIds[array_rand($userIds)];
            $productId = $productIds[array_rand($productIds)];
            $key = $userId . '-' . $productId;
            
            // Verificar si ya existe esta combinación
            if (isset($combinacionesUsadas[$key])) {
                continue;
            }
            
            // Marcar la combinación como usada
            $combinacionesUsadas[$key] = true;
            $valoracionesAgregadas++;
            
            $orderId = $orderIds[array_rand($orderIds)];
            $puntuacion = rand(1, 5); // Distribución completa de puntuaciones
            
            if ($puntuacion >= 4) {
                $comentario = $comentariosPositivos[array_rand($comentariosPositivos)];
            } elseif ($puntuacion == 3) {
                $comentario = $comentariosMedios[array_rand($comentariosMedios)];
            } else {
                $comentario = $comentariosNegativos[array_rand($comentariosNegativos)];
            }
            
            $fechaCreacion = $fechaActual->copy()->subDays(rand(1, 60));
            
            $valoraciones[] = [
                'user_id' => $userId,
                'product_id' => $productId,
                'order_id' => $orderId,
                'puntuacion' => $puntuacion,
                'comentario' => $comentario,
                'compra_verificada' => rand(0, 10) > 2, // 80% de probabilidad de ser compra verificada
                'aprobada' => true,
                'created_at' => $fechaCreacion->format('Y-m-d H:i:s'),
                'updated_at' => $fechaCreacion->format('Y-m-d H:i:s'),
            ];
        }
        
        // Insertar las valoraciones
        try {
            // Intentar insertar todas las valoraciones de una vez
            DB::table('f1collector_valoraciones')->insert($valoraciones);
            $this->command->info('Se han creado ' . count($valoraciones) . ' valoraciones de productos exitosamente.');
        } catch (\Exception $e) {
            // Si falla, intentar insertar una por una para ver cuáles fallan
            $this->command->error('Error al insertar valoraciones en bloque: ' . $e->getMessage());
            $this->command->info('Intentando insertar valoraciones individualmente...');
            
            $insertadas = 0;
            foreach ($valoraciones as $valoracion) {
                try {
                    DB::table('f1collector_valoraciones')->insert($valoracion);
                    $insertadas++;
                } catch (\Exception $innerE) {
                    $this->command->warn('Error al insertar valoración para producto ' . $valoracion['product_id'] . 
                                        ' y usuario ' . $valoracion['user_id'] . ': ' . $innerE->getMessage());
                }
            }
            
            $this->command->info('Se han insertado ' . $insertadas . ' de ' . count($valoraciones) . ' valoraciones de productos.');
        }
    }
}