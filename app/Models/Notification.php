<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'is_active',
        'show_on_homepage',
        'show_popup',
        'start_date',
        'end_date',
        'created_by',
        'view_count'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean',
        'show_popup' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopeForPopup($query)
    {
        return $query->where('show_popup', true);
    }

    public function scopeCurrentlyValid($query)
    {
        $now = Carbon::now();
        return $query->where(function($q) use ($now) {
            $q->where(function($subQ) use ($now) {
                $subQ->whereNull('start_date')
                     ->orWhere('start_date', '<=', $now);
            })
            ->where(function($subQ) use ($now) {
                $subQ->whereNull('end_date')
                     ->orWhere('end_date', '>=', $now);
            });
        });
    }

    public function scopeByPriority($query, $priority = null)
    {
        if ($priority) {
            return $query->where('priority', $priority);
        }
        return $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')");
    }

    // Accessors
    public function getTypeClassAttribute()
    {
        $classes = [
            'info' => 'alert-info',
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'danger' => 'alert-danger'
        ];
        return $classes[$this->type] ?? 'alert-info';
    }

    public function getTypeIconAttribute()
    {
        $icons = [
            'info' => 'fas fa-info-circle',
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'danger' => 'fas fa-exclamation-circle'
        ];
        return $icons[$this->type] ?? 'fas fa-info-circle';
    }

    public function getPriorityClassAttribute()
    {
        $classes = [
            'low' => 'priority-low',
            'medium' => 'priority-medium',
            'high' => 'priority-high',
            'urgent' => 'priority-urgent'
        ];
        return $classes[$this->priority] ?? 'priority-medium';
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => 'badge-secondary',
            'medium' => 'badge-primary',
            'high' => 'badge-warning',
            'urgent' => 'badge-danger'
        ];
        return $badges[$this->priority] ?? 'badge-primary';
    }

    // Methods
    public function isCurrentlyValid()
    {
        $now = Carbon::now();
        
        $startValid = !$this->start_date || $this->start_date <= $now;
        $endValid = !$this->end_date || $this->end_date >= $now;
        
        return $this->is_active && $startValid && $endValid;
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getFormattedContentAttribute()
    {
        return nl2br(e($this->content));
    }
}