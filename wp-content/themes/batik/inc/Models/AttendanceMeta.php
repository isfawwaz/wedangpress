<?php

namespace Batik\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceMeta extends Model {

    use SoftDeletes;

    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'wahaha_attendance_metas';

    /**
     * Columns that can be edited - IE not primary key or timestamps if being used
     */
    protected $fillable = [
        'attendance_id',
        'fullname',
        'address',
        'address2',
        'city',
        'postcode',
        'email',
        'phone'
    ];

    public function scopeById( $query, $id ) {
        return $query->where('id', $id);
    }

    public function scopeByAttendanceId( $query, $id ) {
        return $query->where('attendance_id', $id);
    }

    public function scopeSearch( $query, $search ) {
        return $query->where('fullname', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%")
                    ->orWhere('address2', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('postcode', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
    }

    public function attendance() {
        return $this->belongsTo('Batik\Models\Post', 'attendance_id', 'ID');
    }

    public function room_registrations() {
        return $this->hasMany('Batik\Models\RoomRegistration', 'attendance_id', 'attendance_id');
    }

    public function lounge_registrations() {
        return $this->hasMany('Batik\Models\LoungeRegistration', 'attendance_id', 'attendance_id');
    }

    public function hotel_registrations() {
        return $this->hasMany('Batik\Models\HotelRegistration', 'attendance_id', 'attendance_id');
    }

    public function room_registration() {
        return $this->belongsTo('Batik\Models\RoomRegistration', 'attendance_id', 'attendance_id');
    }

    public function lounge_registration() {
        return $this->belongsTo('Batik\Models\LoungeRegistration', 'attendance_id', 'attendance_id');
    }

    public function hotel_registration() {
        return $this->belongsTo('Batik\Models\HotelRegistration', 'attendance_id', 'attendance_id');
    }

    public function getCreatedAtFormattedAttribute() {
        $createdAt = $this->created_at;

        if( !empty($createdAt) ) {
            return $createdAt->format( get_option('date_format') . ' ' . get_option('time_format') );
        }

        return '&mdash;';
    }

    public function getUpdatedAtFormattedAttribute() {
        $createdAt = $this->updated_at;

        if( !empty($createdAt) ) {
            return $createdAt->format( get_option('date_format') . ' ' . get_option('time_format') );
        }

        return '&mdash;';
    }
}