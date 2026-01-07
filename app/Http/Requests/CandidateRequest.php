<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Rules\Cpf;

class CandidateRequest extends FormRequest
{
    // Valores possíveis do select de gênero (values em inglês, labels em PT-BR no Blade)
    public const GENDERS = ['Male','Female','Other','Prefer not to say'];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Normalizações
        $cpf   = $this->input('cpf');
        $zip   = $this->input('zip');
        $phone = $this->input('phone');

        if ($cpf)   { $cpf   = preg_replace('/\D+/', '', $cpf); }   // mantém só dígitos
        if ($zip)   { $zip   = preg_replace('/\D+/', '', $zip); }   // só dígitos (CEP)
        if ($phone) { $phone = preg_replace('/\D+/', '', $phone); } // só dígitos (10-11)

        $this->merge([
            'cpf'   => $cpf,
            'zip'   => $zip,
            'phone' => $phone,
        ]);
    }

    public function rules(): array
    {
        $candidateId = $this->route('candidate') ? $this->route('candidate')->id : null;
        
        return [
            // Dados pessoais
            'full_name'   => ['required','string','max:255'],
            'cpf'         => ['required','digits:11', new Cpf(), Rule::unique('candidates', 'cpf')->ignore($candidateId)],
            'birth_date'  => ['nullable','date','before:today'],
            'gender'      => ['nullable','string', Rule::in(self::GENDERS)],

            // Arquivos
            'logo'        => ['nullable','image','mimes:png,jpg,jpeg,webp','max:2048'], // até 2MB
            'resume'      => ['nullable','file','mimes:pdf,doc,docx','max:4096'],       // até 4MB

            // Endereço
            'zip'         => ['nullable','digits:8'],        // armazenando sem máscara
            'street'      => ['nullable','string','max:255'],
            'number'      => ['nullable','string','max:20'],
            'complement'  => ['nullable','string','max:100'],
            'neighborhood'=> ['nullable','string','max:120'],
            'city'        => ['nullable','string','max:120'],
            'state'       => ['nullable','string','size:2'], // UF (ex.: SP)

            // Contato
            'phone'       => ['nullable','digits_between:10,11'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique'   => 'Este :attribute já está em uso.',
            'confirmed'=> 'A confirmação de :attribute não confere.',
            'image'    => 'O arquivo de :attribute deve ser uma imagem.',
            'mimes'    => 'O :attribute deve ser do tipo: :values.',
            'max'      => 'O :attribute não pode ter mais que :max :unit.',
            'digits'   => 'O :attribute deve conter exatamente :digits dígitos.',
            'digits_between' => 'O :attribute deve ter entre :min e :max dígitos.',
            'size'     => 'O :attribute deve ter :size caracteres.',
            'date'     => 'O :attribute não é uma data válida.',
            'before'   => 'O :attribute deve ser anterior a hoje.',
            'in'       => 'O valor selecionado em :attribute é inválido.',
            // unidades amigáveis
            'logo.max'   => 'A imagem não pode exceder 2MB.',
            'resume.max' => 'O currículo não pode exceder 4MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name'             => 'Nome Completo',
            'cpf'                   => 'CPF',
            'birth_date'            => 'Data de Nascimento',
            'gender'                => 'Gênero',
            'logo'                  => 'Foto',
            'resume'                => 'Currículo',
            'zip'                   => 'CEP',
            'street'                => 'Endereço',
            'number'                => 'Número',
            'complement'            => 'Complemento',
            'neighborhood'          => 'Bairro',
            'city'                  => 'Cidade',
            'state'                 => 'Estado',
            'phone'                 => 'Telefone',
        ];
    }
}
