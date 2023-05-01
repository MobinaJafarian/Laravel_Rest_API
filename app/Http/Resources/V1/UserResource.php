<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            }),

        ];
    }

    public function with(Request $request)
    {
        return [
            'status' => 200,
        ];
    }
}
