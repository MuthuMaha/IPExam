<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ipmpc extends Model
{
    protected $table='IP_MPC_Marks';
    protected $primaryKey='sl';
    public $timestamps=false;
    protected $fillable=['CAMPUS_ID', 'STUD_ID', 'exam_id', 'PHYSICS', 'CHEMISTRY', 'MATHEMATICS', 'TOTAL', 'SEC_RANK', 'CAMP_RANK', 'CITY_RANK', 'DISTRICT_RANK', 'STATE_RANK', 'ALL_INDIA_RANK', 'ENGLISH', 'GK', 'MATHEMATICS_RANK', 'PHYSICS_RANK', 'CHEMISTRY_RANK', 'M_RANK', 'P_RANK', 'C_RANK', 'MAT1', 'MAT2', 'MAT3', 'PHY1', 'PHY2', 'CHE1', 'CHE2', 'REG_RANK', 'CAMPUS' ];
}
