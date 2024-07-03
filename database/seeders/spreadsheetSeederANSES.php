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
        
        // Example setting
        $set->worksheetTableMapping = ['alim_grps' => 'alim_grps', 
                                       'alim_ss_grps' => 'alim_ss_grps', 
                                       'alim_ss_ss_grps' => 'alim_ss_ss_grps', 
                                       'produits' => 'produits', 
                                       'nutrition_mesures' => 'nutrition_mesures'];
    }
}
