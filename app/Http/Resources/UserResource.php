<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @author josemarsilva
 */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
