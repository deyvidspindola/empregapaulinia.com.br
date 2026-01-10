<?php

// app/Models/Setting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
protected $fillable = ['key', 'value', 'type'];

    /**
     * Normaliza e persiste o value conforme o tipo.
     */
    public function setValueAttribute($v): void
    {
        $type = strtolower($this->type ?? 'string');

        switch ($type) {
            case 'int':
            case 'integer':
            case 'number':
                $this->attributes['value'] = (string) (is_numeric($v) ? (int) $v : 0);
                break;

            case 'bool':
            case 'boolean':
            case 'checkbox':
                // aceita "1", 1, true, "on", "yes"
                $bool = filter_var($v, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                $this->attributes['value'] = $bool ? '1' : '0';
                break;

            case 'json':
            case 'array':
            case 'keyvalue':
                // sempre persiste como JSON
                $this->attributes['value'] = is_string($v) && $this->looksLikeJson($v)
                    ? $v
                    : json_encode($v ?? [], JSON_UNESCAPED_UNICODE);
                break;

            default:
                // fallback: se vier array, guarda como JSON; senão, string
                $this->attributes['value'] = is_array($v)
                    ? json_encode($v, JSON_UNESCAPED_UNICODE)
                    : (string) $v;
                break;
        }
    }

    /**
     * Retorna o value já convertido para o tipo apropriado.
     */
    public function getValueAttribute($v)
    {
        $type = strtolower($this->type ?? 'string');

        switch ($type) {
            case 'int':
            case 'integer':
            case 'number':
                return (int) $v;

            case 'bool':
            case 'boolean':
            case 'checkbox':
                return $v === '1' || $v === 1 || $v === true;

            case 'json':
            case 'array':
            case 'keyvalue':
                if (is_array($v)) return $v;
                $decoded = json_decode($v ?? '[]', true);
                return is_array($decoded) ? $decoded : [];

            default:
                return $v;
        }
    }

    private function looksLikeJson(string $value): bool
    {
        if ($value === '') return false;
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }
}