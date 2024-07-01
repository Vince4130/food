<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionMesures extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'Energie, Règlement UE N° 1169/2011 (kJ/100 g)',
        'Energie, Règlement UE N° 1169/2011 (kcal/100 g)',
        'Energie, N x facteur Jones, avec fibres  (kJ/100 g)',
        'Energie, N x facteur Jones, avec fibres  (kcal/100 g)',
        'Eau (g/100 g)',
        'Protéines, N x facteur de Jones (g/100 g)',
        'Protéines, N x 6.25 (g/100 g)',
        'Glucides (g/100 g)',
        'Lipides (g/100 g)',
        'Sucres (g/100 g)',
        'Fructose (g/100 g)',
        'Galactose (g/100 g)',
        'Glucose (g/100 g)',
        'Lactose (g/100 g)',
        'Maltose (g/100 g)',
        'Saccharose (g/100 g)',
        'Amidon (g/100 g)',
        'Fibres alimentaires (g/100 g)',
        'Polyols totaux (g/100 g)',
        'Cendres (g/100 g)',
        'Alcool (g/100 g)',
        'Acides organiques (g/100 g)',
        'AG saturés (g/100 g)',
        'AG monoinsaturés (g/100 g)',
        'AG polyinsaturés (g/100 g)',
        'AG 4:0, butyrique (g/100 g)',
        'AG 6:0, caproïque (g/100 g)',
        'AG 8:0, caprylique (g/100 g)',
        'AG 10:0, caprique (g/100 g)',
        'AG 12:0, laurique (g/100 g)',
        'AG 14:0, myristique (g/100 g)',
        'AG 16:0, palmitique (g/100 g)',
        'AG 18:0, stéarique (g/100 g)',
        'AG 18:1 9c (n-9), oléique (g/100 g)',
        'AG 18:2 9c,12c (n-6), linoléique (g/100 g)',
        'AG 18:3 c9,c12,c15 (n-3), alpha-linolénique (g/100 g)',
        'AG 20:4 5c,8c,11c,14c (n-6), arachidonique (g/100 g)',
        'AG 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100 g)',
        'AG 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100 g)',
        'Cholestérol (mg/100 g)',
        'Sel chlorure de sodium (g/100 g)',
        'Calcium (mg/100 g)',
        'Chlorure (mg/100 g)',
        'Cuivre (mg/100 g)',
        'Fer (mg/100 g)',
        'Iode (µg/100 g)',
        'Magnésium (mg/100 g)',
        'Manganèse (mg/100 g)',
        'Phosphore (mg/100 g)',
        'Potassium (mg/100 g)',
        'Sélénium (µg/100 g)',
        'Sodium (mg/100 g)',
        'Zinc (mg/100 g)',
        'Rétinol (µg/100 g)',
        'Beta-Carotène (µg/100 g)',
        'Vitamine D (µg/100 g)',
        'Vitamine E (mg/100 g)',
        'Vitamine K1 (µg/100 g)',
        'Vitamine K2 (µg/100 g)',
        'Vitamine C (mg/100 g)',
        'Vitamine B1 ou Thiamine (mg/100 g)',
        'Vitamine B2 ou Riboflavine (mg/100 g)',
        'Vitamine B3 ou PP ou Niacine (mg/100 g)',
        'Vitamine B5 ou Acide pantothénique (mg/100 g)',
        'Vitamine B6 (mg/100 g)',
        'Vitamine B9 ou Folates totaux (µg/100 g)',
        'Vitamine B12 (µg/100 g)',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
    ];
}
