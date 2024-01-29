<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Comment as ModelsComment;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Console\Command;

class Playground extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playground';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sistema de playground...');

        /**
         * Para quando preciso for uma factory de lojinhas virtuais
         */
        // Shop::factory()->has(User::factory(['user_type_id' => 2]))->create();

        // Product::factory()->create();

        // Cart::factory()->create();

        // ModelsComment::factory()->create();

        $this->info('Tudo certo!');
    }
}
