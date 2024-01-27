<?php

namespace LaravelAILabs\FileAssistant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;

/**
 * @class Conversation
 *
 * @property int $user_id
 *
 * This class represents a conversation, extending the base Model class.
 */
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

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, sprintf('%s_%s', Config::get('file-assistant.tables.conversations'), Config::get('file-assistant.tables.files')));
    }
}
