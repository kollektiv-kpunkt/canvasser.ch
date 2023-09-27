<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Zipcode;

class ImportZips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zipcode:import {--zipcodesFile=plz_verzeichnis_v2.json} {--populationFile=bevoelkerung_proplz.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import zipcodes from a JSON file in /data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Zipcode::truncate();

        $zipcodes = json_decode(file_get_contents(base_path('data/' . $this->option('zipcodesFile'))), true);
        $population_per_zipcode = json_decode(file_get_contents(base_path('data/' . $this->option('populationFile'))), true);
        foreach ($zipcodes as $zipcode) {
            $this->info('Importing ' . $zipcode['postleitzahl'] . ' ' . $zipcode['ortbez18']);
            $zipcodeModel = new Zipcode();
            $zipcodeModel->zipcode = $zipcode['postleitzahl'];
            $zipcodeModel->city = $zipcode['ortbez18'];
            $zipcodeModel->state = $zipcode['kanton'];
            $zipcodeModel->bfsnr = $zipcode['bfsnr'];
            $zipcodeModel->geoShape = $zipcode['geo_shape'];

            $zipcodeModel->population = 0;
            $zipcodeModel->save();
        }
    }
}
