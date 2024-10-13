<?php

namespace App\Console\Commands;

use getways\cores\models\Country;
use getways\goldPrices\models\GoldPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GoldPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gold:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the current gold prices.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $globalUrl = "https://www.goldapi.io/api/XAU/USD";
        $localUrl = "https://www.goldapi.io/api/XAU/EGP";
        $apiKey = "goldapi-dclgslz62h7ga-io";

        // Define the headers
        $headers = [
            'x-access-token' => $apiKey,
            'Accept' => 'application/json',
        ];
        try {
            $globalResponse = Http::withHeaders($headers)->get($globalUrl);
            $localResponse = Http::withHeaders($headers)->get($localUrl);
            if ($globalResponse->successful()) {
                $apiData = $globalResponse->json();
                $priceHighOunce = $apiData['high_price'];
                $priceLowOunce = $apiData['low_price'];
                $ounce = $apiData['price'];

                $highPrice24K = $priceHighOunce / 31.1;
                $lowPrice24K = $priceLowOunce / 31.1;

                $all_gold_price = GoldPrice::where('pricing_type', 2)->get();
                foreach ($all_gold_price as $gold_price_global){
                    $dollar = $gold_price_global->country?->dollar;
                    $goldPriceData = [
                        'pricing_type' => 2,
                        'high_price'=>$highPrice24K * $dollar,
                        'low_price'=>$lowPrice24K * $dollar,
                        'ounce'=>$ounce * $dollar
                    ];
                    loadGetway('goldPrices')->updateGoldPrices($gold_price_global->id, $goldPriceData);
                }
                $this->info("The Gold price for buy once is $highPrice24K $ and gold price for sell once is $lowPrice24K $.");
            } else {
                $this->error('Failed to fetch the gold price.');
            }

            if ($localResponse->successful()) {
                $apiData = $localResponse->json();
                $ounce = $apiData['price'];

                $price24K = $apiData['price_gram_24k'] ;
                $price21K = $apiData['price_gram_21k'] ;
                $currency = $apiData['currency'];
                $all_gold_price = GoldPrice::where('pricing_type', 1)->get();
                foreach ($all_gold_price as $gold_price_local){

                    $gold_price = $price24K;
                    if ($gold_price_local->kirat == 2) /*if kirat is 21K*/ {
                        $gold_price = $price21K;
                    }
                    $goldPriceData = [
                        'pricing_type' => 1,
                        'high_price'=>$gold_price,
                        'ounce'=>$ounce
                    ];
                    loadGetway('goldPrices')->updateGoldPrices($gold_price_local->id, $goldPriceData);
                }
                $this->info("The current EGP gold price for 24K is $price24K $currency and gold price for 21K is $price21K $currency.");
            } else {
                $this->error('Failed to fetch the gold price.');
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }

        return 0;
    }
}
