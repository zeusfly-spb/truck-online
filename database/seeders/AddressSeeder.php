<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      //type from & to
      Address::create([
          'name' => 'АрмадаТранс (МКТ)',
          'location' => new Point('55.6617422', '37.2377193'),
          'from'=> true,
          'to'=> true,
          'return'=> false
      ]);
      Address::create([
          'name' => 'Бекасово',
          'location' => new Point('55.4492895','36.6400006'),
          'from'=> true,
          'to'=> true,
          'return'=> false
      ]);
      Address::create([
          'name' => 'Белый Раст',
          'location' => new Point('56.1355494','37.4493085'),
          'from'=> true,
          'to'=> true,
          'return'=> false
      ]);
      Address::create([
          'name' => 'Бутово',
          'location' => new Point('55.5396256','37.5461411'),
          'from'=> true,
          'to'=> true,
          'return'=> false
      ]);
      Address::create([
        'name' => 'Селятино',
        'location' => new Point('55.5197366','36.9319276'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Электроугли',
        'location' => new Point('55.726314','38.2168511'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Ворсино',
        'location' => new Point('55.2476726','36.6613066'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Тучково',
        'location' => new Point('55.5937209','36.4705955'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Силикатная',
        'location' => new Point('55.846668','37.6439025'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Ховрино',
        'location' => new Point('55.8602397','37.5354217'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Купавна',
        'location' => new Point('55.7918662','38.1967013'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Логистика терминал',
        'location' => new Point('59.7648753','30.3635199'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Восход',
        'location' => new Point('59.7843783','30.4060314'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Софрино',
        'location' => new Point('56.1518771','37.9732728'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Бронка',
        'location' => new Point('59.9261353','29.6843098'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Контейнерный терминал Санкт-Петербург',
        'location' => new Point('59.870341','30.1962648'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Моби Дик',
        'location' => new Point('59.8704041','30.1164396'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Первый контейнерный терминал ',
        'location' => new Point('59.8758427','30.2133891'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Петролеспорт',
        'location' => new Point('59.8922982','30.2360813'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Gold контейнер',
        'location' => new Point('55.6305245','37.8033645'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Южный',
        'location' => new Point('55.4729899','37.5634281'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Сходня',
        'location' => new Point('55.9431961','37.278523'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Контейнерно-логистический терминал МАНП',
        'location' => new Point('55.278444','37.1109502'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'РТК Видное',
        'location' => new Point('55.5063525','37.7477131'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'ПКТ (Первый Контейнерный Терминал)',
        'location' => new Point('59.8714349','30.2211392'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'ПЛП (Петролеспорт)',
        'location' => new Point('59.8922982','30.2360813'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'ЛП Янино (Логистический Парк "Янино")',
        'location' => new Point('59.9414577','30.5706558'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'Нева-Металл',
        'location' => new Point('59.9018717','30.216247'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'УЛКТ (Усть-Лужский контейнерный терминал)',
        'location' => new Point('59.6582614','28.2535495'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'МПК ЮГ-2 (Многопрофильный Перегрузочный Комплекс ЮГ-2)',
        'location' => new Point('59.6600231','28.2574092'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);
      Address::create([
        'name' => 'КТСП (ЗАО "Контейнерный терминал Санкт-Петербург")',
        'location' => new Point('59.870341','30.1962648'),
        'from'=> true,
        'to'=> true,
        'return'=> false
      ]);


      //type from & to
      Address::create([
        'name' => 'Аврора (Спб)',
        'location' => new Point('59.8987214','29.5632012'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ТЛЦ Сах-Экс',
        'location' => new Point('53.3010803','40.7607411'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'РТК Видное',
        'location' => new Point('55.7729682','36.2267393'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Тетрис',
        'location' => new Point('55.489604','37.563792'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ТЛЦ Белый Раст',
        'location' => new Point('56.1355494','37.4493085'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ContBase',
        'location' => new Point('55.5570775','36.955557'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'SVCONT',
        'location' => new Point('55.7743975','38.2600728'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ТЛЦ ЛЮБЕРЦЫ',
        'location' => new Point('55.6619053','37.9712135'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Мир-Контейнеров',
        'location' => new Point('55.4732819','37.7400347'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Шубино',
        'location' => new Point('55.3475754','38.0048143'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Технопарк',
        'location' => new Point('55.5210977','37.7685759'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Refterminal-YUG',
        'location' => new Point('55.489604','37.563792'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Южный',
        'location' => new Point('55.4702959','37.547343'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ТСФ',
        'location' => new Point('55.4626627','37.7057233'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Островцы',
        'location' => new Point('55.590992','37.9734879'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Восток-Сервис',
        'location' => new Point('55.7423112','38.0696098'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Сергиево-Посадский',
        'location' => new Point('55.6842362','38.9458086'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Тетра Транс',
        'location' => new Point('55.6136682','37.5630271'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Лобня',
        'location' => new Point('56.0255586','37.4652029'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Кунцево-2',
        'location' => new Point('55.732621','37.3816661'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Чехов',
        'location' => new Point('55.1275506','37.5489176'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Коробово',
        'location' => new Point('55.5349222','37.8109083'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'ТК Новый Контейнерный Терминал',
        'location' => new Point('55.4764414','37.5565383'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Практика',
        'location' => new Point('55.7299735','38.2034612'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Контранс',
        'location' => new Point('55.5878166','36.4835865'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Рустрансконт',
        'location' => new Point('55.5145959','37.7227357'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
      Address::create([
        'name' => 'Лесофонд',
        'location' => new Point('55.4626627','37.7057233'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
      ]);
    }
}
