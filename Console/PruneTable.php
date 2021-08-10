<?php

namespace Lex10000\LaravelPruneDatabaseTable\Console;

use Lex10000\LaravelPruneDatabaseTable\Contracts\PruneCommandInterface;
use DateTimeInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PruneTable extends Command implements PruneCommandInterface
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:prune {table : table name}
    { --hours=48 : количество часов, за которое надо чистить таблицу}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Данная команда выполняет очистку таблицы за последние N часов';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info(
            $this->prune(
                now()->subHours($this->option('hours'))).' entries pruned in '.$this->argument('table').' table.'
        );
    }

    public function prune(DateTimeInterface $before)
    {
        $query = DB::table($this->argument('table'))->where('created_at', '<', $before);

        $totalDeleted = 0;

        $chunkSize = config('prune-table.chunk-size', 100);

        do {
            $deleted = $query->take($chunkSize)->delete();

            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        $logChannel = config('prune-table.log-channel', 'stack');

        Log::channel($logChannel)->debug($totalDeleted.' entries pruned in '.$this->argument('table').'table.');
        return $totalDeleted;
    }
}
