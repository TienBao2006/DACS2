<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'category',
        'is_public',
        'uploaded_by',
        'downloads',
        'tags'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'downloads' => 'integer',
        'tags' => 'array'
    ];

    // Relationship với User (người upload)
    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    // Lấy kích thước file dạng readable
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Lấy icon theo loại file
    public function getFileIconAttribute()
    {
        $extension = strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc' => 'fas fa-file-word text-primary',
            'docx' => 'fas fa-file-word text-primary',
            'xls' => 'fas fa-file-excel text-success',
            'xlsx' => 'fas fa-file-excel text-success',
            'ppt' => 'fas fa-file-powerpoint text-warning',
            'pptx' => 'fas fa-file-powerpoint text-warning',
            'txt' => 'fas fa-file-alt text-secondary',
            'zip' => 'fas fa-file-archive text-info',
            'rar' => 'fas fa-file-archive text-info',
        ];
        
        return $icons[$extension] ?? 'fas fa-file text-muted';
    }

    // Scope cho tài liệu công khai
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Scope theo category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}