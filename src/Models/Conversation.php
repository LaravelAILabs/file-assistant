<?php

namespace LaravelAILabs\FileAssistant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

class Conversation extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('file-assistant.tables.conversations');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
