<?php

namespace LaravelAILabs\FileAssistant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Config;

/**
 * @property string $file_hash
 */
class File extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('file-assistant.tables.files');
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, sprintf('%s_%s', Config::get('file-assistant.tables.conversations'), Config::get('file-assistant.tables.files')));
    }
}
