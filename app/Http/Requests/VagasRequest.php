<?php

namespace App\Http\Requests;

use App\Http\Enum\JobTypes;
use App\Http\Enum\JobModality;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VagasRequest extends FormRequest
{

    public const JOB_TYPES = JobTypes::class;
    public const JOB_MODALITIES = JobModality::class;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // checkbox -> boolean
        $isPublished = $this->has('is_published') ? 1 : 0;
        $isCompanyVisible = $this->has('is_company_visible') ? 1 : 0;

        $this->merge([
            'is_published' => $isPublished,
            'is_company_visible' => $isCompanyVisible,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'              => ['required', 'string', 'max:255'],
            'job_type'           => ['required', 'string', Rule::in(JobTypes::values())],
            'category_id'        => ['required', 'integer', 'exists:job_categories,id'],
            'location'           => ['nullable', 'string', 'max:255'],
            'salary'             => ['nullable', 'string'],
            'modality'           => ['nullable', 'string', Rule::in(JobModality::values())],
            'deadline'           => ['nullable', 'string'],
            'openings'           => ['nullable', 'integer', 'min:1'],
            'is_published'       => ['sometimes', 'boolean'],
            'description'        => ['required', 'string'],
            'requirements'       => ['required', 'string'],
            'highlight_now'      => ['nullable', 'boolean'],
            'highlight_days'     => ['nullable', 'integer', 'in:7,15,30'],
            'benefits'           => ['nullable', 'string'],
            'observation'        => ['nullable', 'string'],
            'is_company_visible' => ['sometimes', 'boolean'],
            'apply_method'       => ['required', 'in:platform,email'],
            'apply_email'        => ['nullable', 'required_if:apply_method,email', 'email:rfc'],
        ];
    }
    public function messages(): array
    {
        return [
            'required'       => 'O campo :attribute é obrigatório.',
            'max'            => 'O :attribute não pode ter mais que :max caracteres.',
            'string'         => 'O :attribute deve ser um texto válido.',
            'integer'        => 'O :attribute deve ser um número inteiro.',
            'numeric'        => 'O :attribute deve ser numérico.',
            'min'            => 'O :attribute deve ser no mínimo :min.',
            'in'             => 'O valor selecionado em :attribute é inválido.',
            'exists'         => 'A :attribute informada não existe.',
            'date'           => 'O :attribute não é uma data válida.',
            'after_or_equal' => 'O :attribute deve ser hoje ou uma data futura.',
            'boolean'        => 'O :attribute deve ser verdadeiro ou falso.',
        ];
    }
    public function attributes(): array
    {
        return [
            'title'        => 'Título',
            'job_type'     => 'Tipo de Contrato',
            'category_id'  => 'Categoria',
            'location'     => 'Localização',
            'salary'       => 'Remuneração',
            'modality'     => 'Modalidade',
            'deadline'     => 'Data de Expiração',
            'openings'     => 'Quantidade de Vagas',
            'is_published' => 'Publicar Agora',            
            'description'  => 'Descrição da Vaga',
            'requirements' => 'Requisitos',
        ];
    }    
}
