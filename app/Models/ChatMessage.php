<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'message',
        'is_admin',
        'session_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Check if message has a file attachment
     */
    public function hasFile()
    {
        return !is_null($this->file_path);
    }

    /**
     * Check if the file is an image
     */
    public function isImage()
    {
        if (!$this->hasFile()) {
            return false;
        }

        $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($this->file_type, $imageTypes);
    }

    /**
     * Get file URL
     */
    public function getFileUrl()
    {
        if (!$this->hasFile()) {
            return null;
        }

        return asset('storage/' . $this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSize()
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
