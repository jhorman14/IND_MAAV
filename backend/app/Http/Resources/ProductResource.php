<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->name,
            'descripcion' => $this->description,
            'precio' => (float) $this->price,
            'peso' => $this->weight_kg,
            'dimensiones' => [
                'ancho_mm' => $this->dimensions_width_mm,
                'profundidad_mm' => $this->dimensions_depth_mm,
                'alto_mm' => $this->dimensions_height_mm,
            ],
            'stock' => $this->available_quantity,
            'seo_slug' => $this->slug,
            'activo' => (bool) $this->visible_public,
            'categoria' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category?->id,
                    'nombre' => $this->category?->name,
                ];
            }),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
