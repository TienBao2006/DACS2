<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'summary',
        'content',
        'image',
        'is_featured',
        'is_published',
        'author',
        'views',
        'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    // Scope để lấy tin đã xuất bản
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    // Scope để lấy tin nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope để sắp xếp theo ngày xuất bản mới nhất
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Accessor để lấy đường dẫn ảnh đầy đủ
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Kiểm tra xem ảnh có phải là URL đầy đủ không
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            // Kiểm tra file có tồn tại trong uploads/news không
            if (file_exists(public_path('uploads/news/' . $this->image))) {
                return asset('uploads/news/' . $this->image);
            }
            // Nếu không có trong uploads, thử storage
            if (file_exists(public_path('storage/news/' . $this->image))) {
                return asset('storage/news/' . $this->image);
            }
        }
        // Trả về ảnh mặc định nếu không có ảnh
        return 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=400&fit=crop&crop=face';
    }

    // Accessor để lấy tóm tắt ngắn
    public function getShortSummaryAttribute()
    {
        if ($this->summary) {
            return \Str::limit($this->summary, 150);
        }
        return \Str::limit(strip_tags($this->content), 150);
    }

    // Accessor để format ngày xuất bản
    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d/m/Y H:i') : '';
    }

    // Accessor để format ngày xuất bản ngắn
    public function getShortDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d/m/Y') : '';
    }

    // Method để tăng lượt xem
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Method để kiểm tra tin có mới không (trong 7 ngày)
    public function getIsNewAttribute()
    {
        return $this->published_at && $this->published_at->diffInDays(now()) <= 7;
    }
}