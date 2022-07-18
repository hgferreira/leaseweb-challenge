<?php

namespace App\Listeners;

use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Server;
use App\Models\Location;
use App\Models\StorageType;
use App\Event\CSVUploaded;


class ParseCSV
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\CSVUploaded  $event
     * @return void
     */
    public function handle(CSVUploaded $event)
    {
        if (($slFile = fopen(storage_path('app\public') .'\\'. config('leaseweb.sl_filename'), "r")) !== FALSE) {

            // clear the servers table
            Server::truncate();

            // clear the storage types table
            StorageType:: truncate();

            // clear the locations table
            Location::truncate();

            // process the csv file
            while (($data = fgetcsv($slFile, 1000, ",")) !== FALSE) {
                $this->processRow($data[0]);
            }

            fclose($slFile);
        }
    }

    /**
     * processRow will parse the CSV line by parts and insert the data in the database
     *
     * @param string $csvRow
     * @return array
     */
    public function processRow($csvRow)
    {
        list($csvModel, $csvRam, $csvHdd, $csvLocation, $csvPrice ) = explode(';', $csvRow);

        $model = $this->parseModel($csvModel);
        $ram = $this->parseRam($csvRam);
        $storage = $this->parseStorage($csvHdd);
        $location = $this->parseLocation($csvLocation);
        $price = $this->parsePrice($csvPrice);

        $dbLocation = Location::firstOrCreate(
            ['location' => $location['location']], 
            ['location_code' => $location['location_code']]
        );
        $dbStorageType = StorageType::firstOrCreate(
            ['type' => $storage['type']]
        );

        $server = new Server();
        $server->model = $model;
        $server->ram_size = $ram['size'];
        $server->ram_unit = $ram['unit'];
        $server->ram_type = $ram['type'];
        $server->storage_size = $storage['size'];
        $server->storage_unit = $storage['unit'];
        $server->storage_number = $storage['number'];
        $server->storage_type_id = $dbStorageType->id;
        $server->location_id = $dbLocation->id;
        $server->price = $price['price'];
        $server->currency = $price['currency'];
        
        try {
            return $server->save();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * parseModel will format the model string to isolate the number of processors
     * and the processor band from the rest of the string, applying spaces when needed
     *
     * @param string $csvModel
     * @return string
     */
    public function parseModel($csvModel)
    {
        // pass 1 - isolate intel word
        list($before, $after) = explode('Intel', $csvModel);
        $model = trim($before) . " Intel " . trim($after);

        // pass 2 - look for number of processors, this loop will support
        // servers up to 16 processors
        for ($i = 1; $i <= 16; $i++) {
            $needle = $i.'x';
            if (strpos($model, $needle) !== false) {
                list($before, $after) = explode($needle, $csvModel);
                $model = trim($before) .' '. $needle .' '. trim($after);
                break;
            }
        }

        return $model;
    }

    /**
     * parseRam will separate the ram size and type and return an array with both values
     *
     * @param [type] $csvRam
     * @return void
     */
    public function parseRam($csvRam)
    {
        $ramArray = [];
        $ramArray['unit'] = 'GB';

        list($ramArray['size'], $ramArray['type']) = explode($ramArray['unit'], $csvRam);

        return $ramArray;
    }


    /**
     * parseStorage will return the storage type, number and size from the $csvStorage
     *
     * @param string $csvStorage
     * @return string
     */
    public function parseStorage($csvStorage)
    {
        $storage = [];

        if (strpos($csvStorage, 'GB')) {
            $stTmp = explode('GB', $csvStorage);
            $storage['unit'] = 'GB';
        } elseif (strpos($csvStorage, 'TB')) {
            $stTmp = explode('TB', $csvStorage);
            $storage['unit'] = 'TB';
        } else {
            $stTmp[1] = 'N/A';
            $storage['unit'] = '--';
        }

        $storage['type'] = $stTmp[1];
        
        list($storage['number'], $storage['size']) = explode('x', $stTmp[0]);
        
        return $storage;
    }

    /**
     * parseLocation will evaluete the locationd string from csv and using the available
     * locations on config file, will return a location site and code in an array
     *
     * @param string $csvLocation
     * @return array
     */
    public function parseLocation($csvLocation)
    {
        $locArray = [];

        foreach(config('leaseweb.locations') as $location) { 
            
            // check if the locations is found in configuration locations array
            $pos = strpos($csvLocation, $location);

            // $pos = 0 means it is found at start of the string, so we evalute using false
            if($pos !== FALSE) {
                $locTmp = explode($location, $csvLocation);

                // since the location name is used as needle, we update the array with the location
                // from the config file/foreach loop
                $locArray['location_code'] = $locTmp[1];
                $locArray['city'] = $location;
                $locArray['location'] = $locArray['city'] .' '. $locArray['location_code'];
                
                // found so no need to continue
                break;
            } else {
                $locArray['location_code'] = 'N/A';
                $locArray['city'] = 'N/A';
                $locArray['location'] = 'N/A';
            }
        }

        return $locArray;
    }

    /**
     * parsePrice will remove euro symbol and return an float
     *
     * @param string $csvPrice
     * @return array
     */
    public function parsePrice($csvPrice)
    {
        $price = [];
        $symbol = mb_substr($csvPrice, 0, 1);

        $price['currency'] = $symbol == '€' ? 'eur' : 'usd';
        $price['price'] = round((float) str_replace($symbol, '', $csvPrice), 2);

        return $price;
    }

}
