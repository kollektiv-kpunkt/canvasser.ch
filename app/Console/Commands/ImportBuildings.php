<?php

namespace App\Console\Commands;

use App\Models\Building;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Antistatique\Swisstopo\SwisstopoConverter as Converter;

class ImportBuildings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'building:import {--buildingsFile=gebaeude_batiment_edificio.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import buildings from a csv file in /data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Building::truncate();
        $this->info('Reading CSV file');
        $buildings = array_map('str_getcsv', file(base_path('data/' . $this->option('buildingsFile'))));
        $headers = array_shift($buildings);
        $buildings = array_map(function ($row) use ($headers) {
            return array_combine($headers, $row);
        }, $buildings);
        $converter = new Converter();
        $this->info('Importing buildings');
        $bar = $this->output->createProgressBar(count($buildings));
        $bar->start();
        foreach ($buildings as $building) {
            $buildingModel = new Building();
            $buildingModel->EGID = $building['EGID'];
            $latLng = $converter->fromMN95ToWGS(floatval($building['GKODE']), floatval($building['GKODN']));
            $buildingModel->coordinates = DB::raw("ST_GeomFromText('POINT(" . $latLng['long'] . " " . $latLng['lat'] . ")')");
            $buildingModel->numberOfApartments = $building['GANZWHG'];
            $buildingModel->save();
            $bar->advance();
        }
        $bar->finish();
        $this->info('Done');
    }
}
