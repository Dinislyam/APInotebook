<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Notebook",
 *     required={"name", "phone", "email"},
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="company", type="string"),
 *     @OA\Property(property="birth_date", type="string", format="date"),
 *     @OA\Property(property="photo_path", type="string", format="uri")
 * )
 */
class Notebook extends Model
{
    use HasFactory; // Добавляем трейт для работы с фабриками

    protected $fillable = [
        'full_name',
        'company',
        'phone',
        'email',
        'birth_date',
        'photo_path',
    ];
}
