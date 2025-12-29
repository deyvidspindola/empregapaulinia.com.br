<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cnpj;

class CompanyRequest extends FormRequest
{

    public const SIZES = ['1-10','11-50','51-200','201-500','501-1000','1000+'];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $website = $this->input('website');

        // Normaliza CNPJ/Tax ID: remove tudo que não for dígito (mantém flexível p/ outros países)
        $taxId = $this->input('tax_id');
        if ($taxId) {
            $taxId = preg_replace('/\D+/', '', $taxId);
        }

        // Se website sem esquema, prefixa https://
        if ($website && !preg_match('#^https?://#i', $website)) {
            $website = 'https://' . $website;
        }

        $this->merge([
            'tax_id' => $taxId,
            'website' => $website,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $companyId = $this->route('dados_da_empresa');
        
        return [
            // Empresa
            'name'           => ['required','string','max:255'],
            'trade_name'     => ['nullable','string','max:255'],
            'tax_id'         => [
                'required',
                'digits:14',
                new Cnpj(),
                Rule::unique('companies', 'tax_id')->ignore($companyId),
            ],
            'industry'       => ['nullable','string', 'max:255'],
            'company_size'   => ['nullable','string', Rule::in(self::SIZES)],

            // Endereço
            'street'         => ['nullable','string','max:255'],
            'number'         => ['nullable','string','max:30'],
            'complement'     => ['nullable','string','max:100'],
            'neighborhood'   => ['nullable','string','max:100'],
            'city'           => ['nullable','string','max:100'],
            'state'          => ['nullable','string','max:100'],
            'zip'            => ['nullable','string','max:20'],
            'country'        => ['nullable','string','max:100'],

            // Contato
            'phone'          => ['nullable','string','max:40'],
            'website'        => ['nullable','url','max:255'],

            // Logo
            'logo'           => ['nullable','image','mimes:png,jpg,jpeg,webp','max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique'   => 'Este :attribute já está em uso.',
            'url'      => 'Informe uma URL válida em :attribute.',
            'image'    => 'O arquivo de :attribute deve ser uma imagem.',
            'mimes'    => 'O :attribute deve ser do tipo: :values.',
            'max'      => 'O :attribute não pode ter mais que :max caracteres.',
            'in'       => 'O valor selecionado em :attribute é inválido.',          
        ];
    }
    public function attributes(): array
    {
        return [
            'name'   => 'Nome da Empresa',
            'trade_name'     => 'Nome Fantasia',
            'tax_id'         => 'CNPJ',
            'industry'       => 'Setor de Atuação',
            'company_size'   => 'Porte da Empresa',
            'street'         => 'Endereço',
            'number'         => 'Número',
            'complement'     => 'Complemento',
            'neighborhood'   => 'Bairro',
            'city'           => 'Cidade',
            'state'          => 'Estado',
            'zip'            => 'CEP',
            'country'        => 'País',
            'phone'          => 'Telefone',
            'website'        => 'Website',
            'logo'           => 'Logo',
        ];
    }    
}
