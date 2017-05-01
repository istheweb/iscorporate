<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 12/01/17
 * Time: 9:04
 */

namespace Istheweb\IsCorporate\Models;

use October\Rain\Database\Model;

class Base extends Model
{
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = [
        'name',
        'slug',
        'caption',
        'description',
        'meta_keywords',
        'meta_description',
        'short_description',
        'text_value',
        'value',
        'motivo',
        'observaciones_entrega',
        'motivo_no_aceptacion',
        'actividad',
        'observaciones',
        'reply',
        'content',
        'subject'
    ];
}