<?php

namespace App\Console\Data;

use App\Models\Bks;
use App\Models\Payments;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Spatie\DbDumper\Databases\PostgreSql;

class ExportData extends Command
{
    protected $path;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:export-bd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DataBase save';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = base_path().'/public/asdnabfqwdasmda';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->payments($this->path . '/payments.csv');
            $this->bks($this->path . '/bks.csv');
            $this->users($this->path . '/users.csv');
            PostgreSql::create()
                ->setHost(env('DB_HOST'))
                ->setDbName(env('DB_DATABASE'))
                ->setUserName(env('DB_USERNAME'))
                ->setPassword(env('DB_PASSWORD'))
                ->dumpToFile($this->path . '/dump.sql');
            $this->sendEmail([
                $this->path . '/payments.csv',
                $this->path . '/users.csv',
                $this->path . '/bks.csv',
                $this->path . '/dump.sql',
            ]);
        } catch (\Exception $exception) {
            $this->error($exception->getTraceAsString());
        }
    }

    /**
     * @param string $path
     */
    protected function payments(string $path)
    {
        !file_exists($path) || unlink($path);
        $file = fopen($path, 'w');
        fputcsv($file, ['Страна', 'Тип', 'Сумма', 'Валюта', 'Статус', 'Дроп']);
        $sets = Payments::with(['type'])->get();
        foreach ($sets as $set) {
            fputcsv($file, [
                $set->type->title,
                $set->sum,
                $set->currency,
                $set->statuses,
                $set->drop
            ]);
        }
        fclose($file);
    }

    /**
     * @param string $path
     */
    protected function bks(string $path)
    {
        !file_exists($path) || unlink($path);
        $file = fopen($path, 'w');
        fputcsv($file, ['БК', 'Дроп', 'Сумма', 'Валюта', 'Логин', 'Пароль', 'Доп информация', 'Статус']);
        $sets = Bks::with(['bet'])->get();
        foreach ($sets as $set) {
            fputcsv($file, [
                $set->bet->name,
                $set->drop,
                $set->cash,
                $set->currency,
                $set->email,
                $set->password,
                $set->info,
                $set->statuses,
            ]);
        }
        fclose($file);
    }

    /**
     * @param string $path
     */
    protected function users(string $path)
    {
        !file_exists($path) || unlink($path);
        $file = fopen($path, 'w');
        fputcsv($file, ['Имя', 'E-mail', 'Позиция']);
        $sets = User::with('roles')->get();
        foreach ($sets as $set) {
            fputcsv($file, [
                $set->name,
                $set->email,
                $set->roles->pluck('name')
            ]);
        }
        fclose($file);
    }

    /**
     * @param $files
     */
    protected function sendEmail($files)
    {
        $data = [
            'project' => getenv('APP_URL'),
            'time' => date("F j, Y, g:i a")
        ];
        Mail::send('mails.db', $data, function ($message) use($files) {
            $message->from(getenv('MAIL_FROM_ADDRESS'));
            $message->to(getenv('MAIL_TO_ADDRESS'))->subject('Резервная копия базы.');

            foreach($files as $file) {
                $message->attach($file);
            }
        });
    }
}
