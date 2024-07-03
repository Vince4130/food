<?php

namespace Database\Seeders;

use bfinlay\SpreadsheetSeeder\SpreadsheetSeeder;

class dataAnses extends SpreadsheetSeeder
{    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function settings(SpreadsheetSeederSettings $set)
    {
        // By default, the seeder will process all XLSX files in /database/seeds/*.xlsx (relative to Laravel project base path)
        
        // Mapping de ce seeder sur le fichier concerné uniquement
        $set->file = ['/database/seeders/food_data_formated.xlsx'];

        // Mapping feuilles excel -> table de la base
        $set->worksheetTableMapping = ['alim_grps' => 'alim_grps', 
                                       'alim_ss_grps' => 'alim_ss_grps', 
                                       'alim_ss_ss_grps' => 'alim_ss_ss_grps', 
                                       'produits' => 'produits', 
                                       'nutrition_mesures' => 'nutrition_mesures'];
    }
}
