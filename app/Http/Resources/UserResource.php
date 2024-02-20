<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private ?string $token;

    public function __construct($resource, ?string $token = null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'role' => config('global.roles')[(int)$this->level - 1],
            'avatar' => $this->avatar,
            'joined' => $this->created_at->format('d-m-Y H:m:s')
        ];

        if ($this->token) {
            $data['token'] = $this->token;
        }

        return $data;
    }
}
