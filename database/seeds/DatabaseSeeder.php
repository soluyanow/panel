<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        /**
         * Запролнение пользователей
         */
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => bcrypt('LLn1bHnS'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        /**
         * Заполнение настроек
         */
        DB::table('settings')->insert([
            'name' => 'email',
            'value' => 'moll-log@yandex.ru',
            'text' => 'Почтовый ящик',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'login',
            'value' => 'moll-log',
            'text' => 'Пользователь',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'password',
            'value' => 'vjkkjnxtn',
            'text' => 'Пароль',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'server',
            'value' => 'yandex.ru',
            'text' => 'Почтовый сервер',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'port',
            'value' => '993',
            'text' => 'Порт',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'folder',
            'value' => 'INBOX',
            'text' => 'Папка сбора почты',
            'user_id' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'subject',
            'value' => 'Acronis',
            'text' => 'Тема поиска',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'debug_mode',
            'value' => '0',
            'text' => 'Режим отладки',
            'type' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('settings')->insert([
            'name' => 'attach_name',
            'value' => 'Report',
            'text' => 'Идентификатор вложения',
            'type' => 'debug',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        /**
         * Запролнение статусов
         */
        DB::table('statuses')->insert([
            'name' => 'успех',
            'identity' => 'bg-blue',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('statuses')->insert([
            'name' => 'есть ошибки',
            'identity' => 'bg-danger',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('statuses')->insert([
            'name' => 'пропущен по времени',
            'identity' => 'bg-warning',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        /**
         * Запролнение типов
         */
        DB::table('types')->insert([
            'name' => 'обновление баз',
            'identity' => 'update',
            'active' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('types')->insert([
            'name' => 'архивация баз',
            'identity' => 'archive',
            'active' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('types')->insert([
            'name' => 'выполнение',
            'identity' => 'execute',
            'active' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
