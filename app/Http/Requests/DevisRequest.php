<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string',
            'type_batiment' => 'required|string',
            'facture_mensuelle' => 'nullable|numeric',
            'consommation_annuelle' => 'nullable|numeric',
            'type_toiture' => 'nullable|string',
            'orientation' => 'nullable|string',
            'objectifs' => 'nullable|array',
            'message' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'email' => 'Email',
            'telephone' => 'Téléphone',
            'adresse' => 'Adresse',
            'type_batiment' => 'Type de bâtiment',
            'facture_mensuelle' => 'Facture mensuelle',
            'consommation_annuelle' => 'Consommation annuelle',
            'type_toiture' => 'Type de toiture',
            'orientation' => 'Orientation',
            'objectifs' => 'Objectifs',
            'message' => 'Message',
            'user_id' => 'Utilisateur'
        ];
    }
}
