<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'author_email',
        'content',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * البحث عن التعليقات المعتمدة فقط
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * البحث عن التعليقات غير المعتمدة
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * تنسيق التاريخ لعرضه بشكل جميل
     */
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->locale('ar')->diffForHumans();
    }

    /**
     * اعتماد التعليق
     */
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * إلغاء اعتماد التعليق
     */
    public function disapprove()
    {
        $this->update(['is_approved' => false]);
    }
}