<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'role' => config('global.roles')[(int)$this->level - 1],
            'avatar' => $this->avatar,
            'joined' => $this->created_at->format('d-m-Y H:m:s')
        ];
    }

    public static function collection($resource)
    {
        return parent::collection($resource)->map(function ($item) {
            return $item;
        });
    }
}
