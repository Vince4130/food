<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nutrition_mesures', function (Blueprint $table) {
            $table->id();
            $table->string('alim_code');
            $table->string('Energie, Règlement UE N° 1169/2011 (kJ/100 g)');
            $table->string('Energie, Règlement UE N° 1169/2011 (kcal/100 g)');
            $table->string('Energie, N x facteur Jones, avec fibres  (kJ/100 g)');
            $table->string('Energie, N x facteur Jones, avec fibres  (kcal/100 g)');
            $table->string('Eau (g/100 g)');
            $table->string('Protéines, N x facteur de Jones (g/100 g)');
            $table->string('Protéines, N x 6,25 (g/100 g)');
            $table->string('Glucides (g/100 g)');
            $table->string('Lipides (g/100 g)');
            $table->string('Sucres (g/100 g)');
            $table->string('Fructose (g/100 g)');
            $table->string('Galactose (g/100 g)');
            $table->string('Glucose (g/100 g)');
            $table->string('Lactose (g/100  g)');
            $table->string('Maltose (g/100 g)');
            $table->string('Saccharose (g/100 g)');
            $table->string('Amidon (g/100 g)');
            $table->string('Fibres alimentaires (g/100 g)');
            $table->string('Polyols totaux (g/100 g)');
            $table->string('Cendres (g/100 g)');
            $table->string('Alcool (g/100 g)');
            $table->string('Acides organiques (g/100 g)');
            $table->string('AG saturés (g/100 g)');
            $table->string('AG monoinsaturés (g/100 g)');
            $table->string('AG polyinsaturés (g/100 g)');
            $table->string('AG 4:0, butyrique (g/100 g)');
            $table->string('AG 6:0, caproïque (g/100 g)');
            $table->string('AG 8:0, caprylique (g/100 g)');
            $table->string('AG 10:0, caprique (g/100 g)');
            $table->string('AG 12:0, laurique (g/100 g)');
            $table->string('AG 14:0, myristique (g/100 g)');
            $table->string('AG 16:0, palmitique (g/100 g)');
            $table->string('AG 18:0, stéarique (g/100 g)');
            $table->string('AG 18:1 9c (n-9), oléique (g/100 g)');
            $table->string('AG 18:2 9c,12c (n-6), linoléique (g/100 g)');
            $table->string('AG 18:3 c9,c12,c15 (n-3), alpha-linolénique (g/100 g)');
            $table->string('AG 20:4 5c,8c,11c,14c (n-6), arachidonique (g/100 g)');
            $table->string('AG 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100 g)');
            $table->string('AG 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100 g)');
            $table->string('Cholestérol (mg/100 g)');
            $table->string('Sel chlorure de sodium (g/100 g)');
            $table->string('Calcium (mg/100 g)');
            $table->string('Chlorure (mg/100 g)');
            $table->string('Cuivre (mg/100 g)');
            $table->string('Fer (mg/100 g)');
            $table->string('Iode (µg/100 g)');
            $table->string('Magnésium (mg/100 g)');
            $table->string('Manganèse (mg/100 g)');
            $table->string('Phosphore (mg/100 g)');
            $table->string('Potassium (mg/100 g)');
            $table->string('Sélénium (µg/100 g)');
            $table->string('Sodium (mg/100 g)');
            $table->string('Zinc (mg/100 g)');
            $table->string('Rétinol (µg/100 g)');
            $table->string('Beta-Carotène (µg/100 g)');
            $table->string('Vitamine D (µg/100 g)');
            $table->string('Vitamine E (mg/100 g)');
            $table->string('Vitamine K1 (µg/100 g)');
            $table->string('Vitamine K2 (µg/100 g)');
            $table->string('Vitamine C (mg/100 g)');
            $table->string('Vitamine B1 ou Thiamine (mg/100 g)');
            $table->string('Vitamine B2 ou Riboflavine (mg/100 g)');
            $table->string('Vitamine B3 ou PP ou Niacine (mg/100 g)');
            $table->string('Vitamine B5 ou Acide pantothénique (mg/100 g)');
            $table->string('Vitamine B6 (mg/100 g)');
            $table->string('Vitamine B9 ou Folates totaux (µg/100 g)');
            $table->string('Vitamine B12 (µg/100 g)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_mesures');
    }
};
