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
          'address' => '143078, Московская область, Одинцовский район, дер. Акулово 102',
          'location' => new Point('55.6617422', '37.2377193'),
          'from'=> true,
          'to'=> true,
          'return'=> false,
          'accept_status'=>true
      ]);
      Address::create([
          'name' => 'Бекасово',
          'address' => 'Московская обл., 143380',
          'location' => new Point('55.4492895','36.6400006'),
          'from'=> true,
          'to'=> true,
          'return'=> false,
          'accept_status'=>true
      ]);
      Address::create([
          'name' => 'Белый Раст',
          'address' => '141870, Московская область, Дмитровский р-н, с. Белый Раст, владение 112, строение 1, литера Б',
          'location' => new Point('56.1355494','37.4493085'),
          'from'=> true,
          'to'=> true,
          'return'=> false,
          'accept_status'=>true
      ]);
      Address::create([
          'name' => 'Бутово',
          'address' => 'Москва, 117623',
          'location' => new Point('55.5396256','37.5461411'),
          'from'=> true,
          'to'=> true,
          'return'=> false,
          'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Селятино',
        'address' => '143345, Россия, Московская обл., Наро-Фоминский р-н. р.п. Селятино, здание ТО-1, ТО-2',
        'location' => new Point('55.5197366','36.9319276'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Электроугли',
        'address'=> 'г. Электроугли, ул. Железнодорожная, вл. 29, стр. 1',
        'location' => new Point('55.726314','38.2168511'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Ворсино',
        'address'=> 'г. Электроугли, ул. Железнодорожная, вл. 29, стр. 1',
        'location' => new Point('55.2476726','36.6613066'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Тучково',
        'address'=> 'ул. Восточная д.1 стр.5 уч.5, Московская Область п.Тучково, Московская обл., 143131',
        'location' => new Point('55.5937209','36.4705955'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Силикатная',
        'address'=> 'г. Москва, пр-д Серебрякова, д.2, стр.1',
        'location' => new Point('55.846668','37.6439025'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Ховрино',
        'address'=> '127486, г. Москва, ул. Пяловская, 19',
        'location' => new Point('55.8602397','37.5354217'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Купавна',
        'address'=> 'Московская область, Ногинский район, г. Старая Купавна, ул. Дорожная, д. 15',
        'location' => new Point('55.7918662','38.1967013'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Логистика терминал',
        'address'=> '196601, город Санкт-петербург, поселок Шушары, шоссе Московское, 54, А',
        'location' => new Point('59.7648753','30.3635199'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Восход',
        'address'=> '196626, г. Санкт-Петербург, пос. Шушары, участок ж/д. «Московское шоссе – река Кузьминка ',
        'location' => new Point('59.7843783','30.4060314'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Софрино',
        'address'=> '141270, Московская область, Пушкинский район, п. Софрино, ул. Победы 10',
        'location' => new Point('56.1518771','37.9732728'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Бронка',
        'address'=> 'Краснофлотское ш., 49, Санкт-Петербург, 198412',
        'location' => new Point('59.9261353','29.6843098'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Контейнерный терминал Санкт-Петербург',
        'address'=> 'Угольная гавань, Элеваторная площадка, 22 литера Щ ',
        'location' => new Point('59.870341','30.1962648'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Моби Дик',
        'address'=> 'Морской портовый комплекс, Санкт-Петербург, Кронштадт, Санкт-Петербург, 197761',
        'location' => new Point('59.8704041','30.1164396'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Первый контейнерный терминал ',
        'address'=> '​Дорога на Турухтанные острова, 17​4 этаж​ Автово, Кировский район, Санкт-Петербург, 198096',
        'location' => new Point('59.8758427','30.2133891'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Петролеспорт',
        'address'=> '198095, г.Санкт-Петербург, Гладкий остров, д.1',
        'location' => new Point('59.8922982','30.2360813'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Gold контейнер',
        'address'=> 'МКАД 17 км, 1, Дзержинский, Москва, 109429',
        'location' => new Point('55.6305245','37.8033645'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Южный',
        'address'=> 'Ново-Сырово м-н, Подольск, Московская область, 142101',
        'location' => new Point('55.4729899','37.5634281'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Сходня',
        'address'=> 'ул. Некрасова, 2-а, Химки, Московская обл., 141420',
        'location' => new Point('55.9431961','37.278523'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Контейнерно-логистический терминал МАНП',
        'address'=> 'Львово, Москва, 142161',
        'location' => new Point('55.278444','37.1109502'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'РТК Видное',
        'address'=> 'Городское поселение Горки Ленинские, Ленинский городской округ, Московская область',
        'location' => new Point('55.5063525','37.7477131'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ПКТ (Первый Контейнерный Терминал)',
        'address'=> '198096, г. Санкт-Петербург, вн. тер. г. муниципальный округ Автово, дор. на Турухтанные острова, д. 30, стр. 2',
        'location' => new Point('59.8714349','30.2211392'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ПЛП (Петролеспорт)',
        'address'=> '198095, г.Санкт-Петербург, Гладкий остров, д.1 ',
        'location' => new Point('59.8922982','30.2360813'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ЛП Янино (Логистический Парк "Янино")',
        'address'=> 'Ленинградская область городской поселок Янино-1, въезд Логистический, здание №5, Санкт-Петербург, Ленинградская обл., 188689',
        'location' => new Point('59.9414577','30.5706558'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Нева-Металл',
        'address'=> 'Санкт-Петербург, дорога на Турухтанные острова, 3-й район морского порта',
        'location' => new Point('59.9018717','30.216247'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'УЛКТ (Усть-Лужский контейнерный терминал)',
        'address'=> '188472, Лен.обл., Кингисеппский р-н, терр. морской торговый порт Усть-Луга, Южный район, д. 470, стр. 70а',
        'location' => new Point('59.6582614','28.2535495'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'МПК ЮГ-2 (Многопрофильный Перегрузочный Комплекс ЮГ-2)',
        'address'=> 'Усть-лужское Сельское Поселение, Ленинградская обл., 188472',
        'location' => new Point('59.6600231','28.2574092'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'КТСП (ЗАО "Контейнерный терминал Санкт-Петербург")',
        'address'=> 'Угольная гавань, Элеваторная площадка, 22 литера Щ, Санкт-Петербург, 198096',
        'location' => new Point('59.870341','30.1962648'),
        'from'=> true,
        'to'=> true,
        'return'=> false,
        'accept_status'=>true
      ]);


      //type return
      Address::create([
        'name' => 'Аврора (Спб)',
        'address'=> '198412, Ломоносов, Санкт-Петербург',
        'location' => new Point('59.8987214','29.5632012'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ТЛЦ Сах-Экс',
        'address'=> '142153, Московская область, Подольский район, деревня Большое Толбино, ул. Промышленная, д.3а/1',
        'location' => new Point('53.3010803','40.7607411'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'РТК Видное',
        'address'=> 'Городское поселение Горки Ленинские, Ленинский городской округ, Московская область',
        'location' => new Point('55.7729682','36.2267393'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Тетрис',
        'address'=> '142170, Симферопольское ш., 22, строение 1, Москва',
        'location' => new Point('55.489604','37.563792'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ТЛЦ Белый Раст',
        'address'=> '141870, Московская область, Дмитровский район, с. Белый Раст, владение 112, строение 1, литера Б',
        'location' => new Point('56.1355494','37.4493085'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ContBase',
        'address'=> 'посёлок Калининец, 25, рп. Калининец',
        'location' => new Point('55.5570775','36.955557'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'SVCONT',
        'address'=> 'Московская обл., Богородский р-н, д. Тимохово, ул. Совхозная',
        'location' => new Point('55.7743975','38.2600728'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ТЛЦ ЛЮБЕРЦЫ',
        'address'=> 'Московская область, г. Люберцы, дп. Красково, ул. 2-я заводская, д.2',
        'location' => new Point('55.6619053','37.9712135'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Мир-Контейнеров',
        'address'=> ' МО, г. Домодедово, ул. Логистическая д.1',
        'location' => new Point('55.4732819','37.7400347'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Шубино',
        'address'=> 'Московская область, городской округ Домодедово, село Шубино',
        'location' => new Point('55.3475754','38.0048143'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Технопарк',
        'address'=> 'ул. Восточная, Горки Ленинские, Московская обл., 142718',
        'location' => new Point('55.5210977','37.7685759'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Refterminal-YUG',
        'address'=> '22, стр. 1 Симферопольское шоссе Щербинка, Москва, Московская обл., 142171',
        'location' => new Point('55.489604','37.563792'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Южный',
        'address'=> 'Ново-Сырово м-н, Подольск, Московская область, 142101',
        'location' => new Point('55.4702959','37.547343'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ТСФ',
        'address'=> '​Улица Зорин лес, 1а​ с. Домодедово, Домодедово городской округ, Московская область, 142029',
        'location' => new Point('55.4626627','37.7057233'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Островцы',
        'address'=> 'МО, д. Островцы, ул Подмосковная, стр 110/1',
        'location' => new Point('55.590992','37.9734879'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Восток-Сервис',
        'address'=> '143921, Чернореченская улица, 67 д. Черное, Балашиха городской округ, Московская область​ ',
        'location' => new Point('55.7423112','38.0696098'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Сергиево-Посадский',
        'address'=> 'Московская область, Сергиево-Посадский г.о., А-108, 84-й километр ',
        'location' => new Point('55.6842362','38.9458086'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Тетра Транс',
        'address'=> 'г.Москва, Каширское шоссе 30-ый км, владение 1, строение 1',
        'location' => new Point('55.6136682','37.5630271'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Лобня',
        'address'=> 'Московская область, г.о. Лобня, г. Лобня, улица Горки Киовские, вл5 ',
        'location' => new Point('56.0255586','37.4652029'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Кунцево-2',
        'address'=> 'г. Москва, ул. Молодогвардейская д.65, стр.3',
        'location' => new Point('55.732621','37.3816661'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Чехов',
        'address'=> '142324, Московская область, г. Чехов, д. Люторецкое, территория промзона Люторец ',
        'location' => new Point('55.1275506','37.5489176'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Коробово',
        'address'=> 'Городское поселение Горки Ленинские, Ленинский городской округ МО, Координаты 55.517194, 37.823921, село Коробово',
        'location' => new Point('55.5349222','37.8109083'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'ТК Новый Контейнерный Терминал',
        'address'=> 'Рязановское шocce, 7, Подольск, Московская обл., 142134',
        'location' => new Point('55.4764414','37.5565383'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Практика',
        'address'=> 'Московская обл. Богородский городской округ, город Электроугли, улица Заводская д.2',
        'location' => new Point('55.7299735','38.2034612'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Контранс',
        'address'=> 'Московская область, Рузский район, поселок Тучково, улица Восточная, дом 1',
        'location' => new Point('55.5878166','36.4835865'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Рустрансконт',
        'address'=> 'МО, поселение Ленинские горки, промзона Пронинский парк, контейнерный терминал «РТК ВИДНОЕ»',
        'location' => new Point('55.5145959','37.7227357'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
      Address::create([
        'name' => 'Лесофонд',
        'address'=> 'ул. Зорин Лес, 1, село Домодедово',
        'location' => new Point('55.4626627','37.7057233'),
        'return'=> true,
        'from'=> false,
        'to'=> false,
        'accept_status'=>true
      ]);
    }
}
