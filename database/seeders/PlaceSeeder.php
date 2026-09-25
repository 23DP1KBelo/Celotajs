<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [

            'AF' => ['Kabul', 'Kandahar', 'Herat', 'Mazar-i-Sharif', 'Jalalabad'],
            'AL' => ['Tirana', 'Durres', 'Vlore', 'Shkoder', 'Fier'],
            'DZ' => ['Algiers', 'Oran', 'Constantine', 'Annaba', 'Blida'],
            'AD' => ['Andorra la Vella', 'Escaldes-Engordany', 'Encamp', 'La Massana', 'Canillo'],
            'AO' => ['Luanda', 'Huambo', 'Lobito', 'Benguela', 'Lubango'],
            'AG' => ['Saint John\'s', 'All Saints', 'Liberta', 'Potters Village', 'Bolans'],
            'AR' => ['Buenos Aires', 'Cordoba', 'Rosario', 'Mendoza', 'La Plata'],
            'AM' => ['Yerevan', 'Gyumri', 'Vanadzor', 'Vagharshapat', 'Hrazdan'],
            'AU' => ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide'],
            'AT' => ['Vienna', 'Graz', 'Linz', 'Salzburg', 'Innsbruck'],
            'AZ' => ['Baku', 'Ganja', 'Sumqayit', 'Mingachevir', 'Lankaran'],

            'BS' => ['Nassau', 'Freeport', 'West End', 'Coopers Town', 'Marsh Harbour'],
            'BH' => ['Manama', 'Riffa', 'Muharraq', 'Hamad Town', 'Isa Town'],
            'BD' => ['Dhaka', 'Chittagong', 'Khulna', 'Rajshahi', 'Sylhet'],
            'BB' => ['Bridgetown', 'Speightstown', 'Oistins', 'Holetown', 'Bathsheba'],
            'BY' => ['Minsk', 'Gomel', 'Mogilev', 'Vitebsk', 'Grodno'],
            'BE' => ['Brussels', 'Antwerp', 'Ghent', 'Charleroi', 'Liege'],
            'BZ' => ['Belize City', 'Belmopan', 'San Ignacio', 'Orange Walk', 'Dangriga'],
            'BJ' => ['Porto-Novo', 'Cotonou', 'Parakou', 'Abomey-Calavi', 'Djougou'],
            'BT' => ['Thimphu', 'Phuntsholing', 'Punakha', 'Paro', 'Jakar'],
            'BO' => ['La Paz', 'Santa Cruz de la Sierra', 'Cochabamba', 'Sucre', 'Oruro'],
            'BA' => ['Sarajevo', 'Banja Luka', 'Tuzla', 'Zenica', 'Mostar'],
            'BW' => ['Gaborone', 'Francistown', 'Molepolole', 'Maun', 'Kasane'],
            'BR' => ['Sao Paulo', 'Rio de Janeiro', 'Brasilia', 'Salvador', 'Fortaleza'],
            'BN' => ['Bandar Seri Begawan', 'Kuala Belait', 'Seria', 'Tutong', 'Bangar'],
            'BG' => ['Sofia', 'Plovdiv', 'Varna', 'Burgas', 'Ruse'],
            'BF' => ['Ouagadougou', 'Bobo-Dioulasso', 'Koudougou', 'Banfora', 'Ouahigouya'],
            'BI' => ['Bujumbura', 'Gitega', 'Ngozi', 'Muyinga', 'Ruyigi'],

            'CV' => ['Praia', 'Mindelo', 'Santa Maria', 'Assomada', 'Espargos'],
            'KH' => ['Phnom Penh', 'Siem Reap', 'Battambang', 'Sihanoukville', 'Kampong Cham'],
            'CM' => ['Yaounde', 'Douala', 'Bamenda', 'Bafoussam', 'Garoua'],
            'CA' => ['Toronto', 'Montreal', 'Vancouver', 'Calgary', 'Ottawa'],
            'CF' => ['Bangui', 'Bimbo', 'Berberati', 'Carnot', 'Bambari'],
            'TD' => ['N\'Djamena', 'Moundou', 'Abéché', 'Sarh', 'Kelo'],
            'CL' => ['Santiago', 'Valparaiso', 'Concepcion', 'Antofagasta', 'Temuco'],
            'CN' => ['Beijing', 'Shanghai', 'Guangzhou', 'Shenzhen', 'Chengdu'],
            'CO' => ['Bogota', 'Medellin', 'Cali', 'Barranquilla', 'Cartagena'],
            'KM' => ['Moroni', 'Mutsamudu', 'Fomboni'],
            'CG' => ['Brazzaville', 'Pointe-Noire', 'Dolisie', 'Nkayi', 'Ouesso'],
            'CD' => ['Kinshasa', 'Lubumbashi', 'Mbuji-Mayi', 'Kisangani', 'Kananga'],
            'CR' => ['San Jose', 'Alajuela', 'Cartago', 'Heredia', 'Liberia'],
            'CI' => ['Yamoussoukro', 'Abidjan', 'Bouake', 'Daloa', 'Korhogo'],
            'HR' => ['Zagreb', 'Split', 'Rijeka', 'Osijek', 'Zadar'],
            'CU' => ['Havana', 'Santiago de Cuba', 'Camaguey', 'Holguin', 'Santa Clara'],
            'CY' => ['Nicosia', 'Limassol', 'Larnaca', 'Paphos', 'Famagusta'],
            'CZ' => ['Prague', 'Brno', 'Ostrava', 'Plzen', 'Liberec'],

            'DK' => ['Copenhagen', 'Aarhus', 'Odense', 'Aalborg', 'Esbjerg'],
            'DJ' => ['Djibouti City', 'Ali Sabieh', 'Tadjoura', 'Obock', 'Dikhil'],
            'DM' => ['Roseau', 'Portsmouth', 'Marigot', 'Berekua', 'Mahaut'],
            'DO' => ['Santo Domingo', 'Santiago de los Caballeros', 'La Romana', 'San Pedro de Macoris', 'Puerto Plata'],

            'EC' => ['Quito', 'Guayaquil', 'Cuenca', 'Santo Domingo', 'Machala'],
            'EG' => ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima', 'Port Said'],
            'SV' => ['San Salvador', 'Santa Ana', 'San Miguel', 'Soyapango', 'Santa Tecla'],
            'GQ' => ['Malabo', 'Bata', 'Ebebiyin', 'Aconibe', 'Mongomo'],
            'ER' => ['Asmara', 'Keren', 'Massawa', 'Assab', 'Mendefera'],
            'EE' => ['Tallinn', 'Tartu', 'Narva', 'Parnu', 'Kohtla-Jarve'],
            'SZ' => ['Mbabane', 'Manzini', 'Lobamba', 'Siteki', 'Piggs Peak'],
            'ET' => ['Addis Ababa', 'Dire Dawa', 'Mekelle', 'Gondar', 'Bahir Dar'],

            'FJ' => ['Suva', 'Nadi', 'Lautoka', 'Labasa', 'Ba'],
            'FI' => ['Helsinki', 'Espoo', 'Tampere', 'Vantaa', 'Oulu'],
            'FR' => ['Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice'],

            'GA' => ['Libreville', 'Port-Gentil', 'Franceville', 'Oyem', 'Moanda'],
            'GM' => ['Banjul', 'Serekunda', 'Brikama', 'Bakau', 'Farafenni'],
            'GE' => ['Tbilisi', 'Batumi', 'Kutaisi', 'Rustavi', 'Gori'],
            'DE' => ['Berlin', 'Hamburg', 'Munich', 'Cologne', 'Frankfurt'],
            'GH' => ['Accra', 'Kumasi', 'Tamale', 'Takoradi', 'Cape Coast'],
            'GR' => ['Athens', 'Thessaloniki', 'Patras', 'Heraklion', 'Larissa'],
            'GD' => ['St. George\'s', 'Gouyave', 'Grenville', 'Victoria', 'Sauteurs'],
            'GT' => ['Guatemala City', 'Mixco', 'Villa Nueva', 'Quetzaltenango', 'Escuintla'],
            'GN' => ['Conakry', 'Nzerekore', 'Kankan', 'Kindia', 'Labe'],
            'GW' => ['Bissau', 'Bafata', 'Gabu', 'Cacheu', 'Bolama'],
            'GY' => ['Georgetown', 'Linden', 'New Amsterdam', 'Bartica', 'Skeldon'],

            'HT' => ['Port-au-Prince', 'Cap-Haitien', 'Gonaives', 'Les Cayes', 'Jacmel'],
            'HN' => ['Tegucigalpa', 'San Pedro Sula', 'La Ceiba', 'Choloma', 'Comayagua'],
            'HU' => ['Budapest', 'Debrecen', 'Szeged', 'Miskolc', 'Pecs'],

            'IS' => ['Reykjavik', 'Kopavogur', 'Hafnarfjordur', 'Akureyri', 'Reykjanesbaer'],
            'IN' => ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Ahmedabad'],
            'ID' => ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang'],
            'IR' => ['Tehran', 'Mashhad', 'Isfahan', 'Karaj', 'Shiraz'],
            'IQ' => ['Baghdad', 'Basra', 'Mosul', 'Erbil', 'Najaf'],
            'IE' => ['Dublin', 'Cork', 'Limerick', 'Galway', 'Waterford'],
            'IL' => ['Jerusalem', 'Tel Aviv', 'Haifa', 'Rishon LeZion', 'Petah Tikva'],
            'IT' => ['Rome', 'Milan', 'Naples', 'Turin', 'Palermo'],

            'JM' => ['Kingston', 'Montego Bay', 'Spanish Town', 'Portmore', 'Mandeville'],
            'JP' => ['Tokyo', 'Yokohama', 'Osaka', 'Nagoya', 'Sapporo'],
            'JO' => ['Amman', 'Zarqa', 'Irbid', 'Aqaba', 'Madaba'],

            'KZ' => ['Almaty', 'Astana', 'Shymkent', 'Karaganda', 'Aktobe'],
            'KE' => ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret'],
            'KI' => ['South Tarawa', 'Betio', 'Bairiki', 'Bikenibeu', 'Teaoraereke'],
            'KP' => ['Pyongyang', 'Hamhung', 'Chongjin', 'Nampo', 'Wonsan'],
            'KR' => ['Seoul', 'Busan', 'Incheon', 'Daegu', 'Daejeon'],
            'KW' => ['Kuwait City', 'Al Ahmadi', 'Hawally', 'Salmiya', 'Jahra'],
            'KG' => ['Bishkek', 'Osh', 'Jalal-Abad', 'Karakol', 'Tokmok'],

            'LA' => ['Vientiane', 'Savannakhet', 'Pakse', 'Luang Prabang', 'Thakhek'],
            'LV' => ['Riga', 'Daugavpils', 'Liepaja', 'Jelgava', 'Jurmala'],
            'LB' => ['Beirut', 'Tripoli', 'Sidon', 'Tyre', 'Zahle'],
            'LS' => ['Maseru', 'Teyateyaneng', 'Mafeteng', 'Hlotse', 'Mohale\'s Hoek'],
            'LR' => ['Monrovia', 'Gbarnga', 'Buchanan', 'Kakata', 'Ganta'],
            'LY' => ['Tripoli', 'Benghazi', 'Misrata', 'Bayda', 'Zawiya'],
            'LI' => ['Vaduz', 'Schaan', 'Balzers', 'Triesen', 'Eschen'],
            'LT' => ['Vilnius', 'Kaunas', 'Klaipeda', 'Siauliai', 'Panevezys'],
            'LU' => ['Luxembourg City', 'Esch-sur-Alzette', 'Differdange', 'Dudelange', 'Ettelbruck'],

            'MG' => ['Antananarivo', 'Toamasina', 'Antsirabe', 'Fianarantsoa', 'Mahajanga'],
            'MW' => ['Lilongwe', 'Blantyre', 'Mzuzu', 'Zomba', 'Kasungu'],
            'MY' => ['Kuala Lumpur', 'George Town', 'Johor Bahru', 'Ipoh', 'Malacca City'],
            'MV' => ['Male', 'Addu City', 'Fuvahmulah', 'Kulhudhuffushi', 'Thinadhoo'],
            'ML' => ['Bamako', 'Sikasso', 'Mopti', 'Segou', 'Kayes'],
            'MT' => ['Valletta', 'Birkirkara', 'Mosta', 'Qormi', 'Sliema'],
            'MH' => ['Majuro', 'Ebeye'],
            'MR' => ['Nouakchott', 'Nouadhibou', 'Rosso', 'Kiffa', 'Kaedi'],
            'MU' => ['Port Louis', 'Beau Bassin-Rose Hill', 'Vacoas-Phoenix', 'Curepipe', 'Quatre Bornes'],
            'MX' => ['Mexico City', 'Guadalajara', 'Monterrey', 'Puebla', 'Tijuana'],
            'FM' => ['Palikir', 'Kolonia', 'Weno', 'Tofol', 'Colonia'],
            'MD' => ['Chisinau', 'Balti', 'Bender', 'Tiraspol', 'Cahul'],
            'MC' => ['Monaco'],
            'MN' => ['Ulaanbaatar', 'Erdenet', 'Darkhan', 'Choibalsan', 'Moron'],
            'ME' => ['Podgorica', 'Niksic', 'Budva', 'Bar', 'Herceg Novi'],
            'MA' => ['Rabat', 'Casablanca', 'Marrakesh', 'Fes', 'Tangier'],
            'MZ' => ['Maputo', 'Matola', 'Nampula', 'Beira', 'Chimoio'],

            'MM' => ['Yangon', 'Mandalay', 'Naypyidaw', 'Mawlamyine', 'Bago'],

            'NA' => ['Windhoek', 'Walvis Bay', 'Swakopmund', 'Oshakati', 'Rundu'],
            'NR' => ['Yaren', 'Anabar', 'Anetan', 'Baiti', 'Meneng'],
            'NP' => ['Kathmandu', 'Pokhara', 'Lalitpur', 'Biratnagar', 'Birgunj'],
            'NL' => ['Amsterdam', 'Rotterdam', 'The Hague', 'Utrecht', 'Eindhoven'],
            'NZ' => ['Auckland', 'Wellington', 'Christchurch', 'Hamilton', 'Dunedin'],
            'NI' => ['Managua', 'Leon', 'Granada', 'Masaya', 'Matagalpa'],
            'NE' => ['Niamey', 'Zinder', 'Maradi', 'Agadez', 'Tahoua'],
            'NG' => ['Lagos', 'Kano', 'Ibadan', 'Abuja', 'Benin City'],
            'MK' => ['Skopje', 'Bitola', 'Kumanovo', 'Prilep', 'Tetovo'],
            'NO' => ['Oslo', 'Bergen', 'Trondheim', 'Stavanger', 'Drammen'],

            'OM' => ['Muscat', 'Salalah', 'Sohar', 'Nizwa', 'Sur'],

            'PK' => ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad'],
            'PW' => ['Ngerulmud', 'Koror', 'Melekeok', 'Airai', 'Ngaraard'],
            'PA' => ['Panama City', 'Colon', 'David', 'La Chorrera', 'Santiago'],
            'PG' => ['Port Moresby', 'Lae', 'Mount Hagen', 'Madang', 'Goroka'],
            'PY' => ['Asuncion', 'Ciudad del Este', 'San Lorenzo', 'Luque', 'Capiata'],
            'PE' => ['Lima', 'Arequipa', 'Trujillo', 'Chiclayo', 'Cusco'],
            'PH' => ['Manila', 'Quezon City', 'Davao City', 'Cebu City', 'Zamboanga City'],
            'PL' => ['Warsaw', 'Krakow', 'Wroclaw', 'Poznan', 'Gdansk'],
            'PT' => ['Lisbon', 'Porto', 'Amadora', 'Braga', 'Coimbra'],

            'QA' => ['Doha', 'Al Rayyan', 'Al Wakrah', 'Umm Salal Muhammad', 'Al Khor'],

            'RO' => ['Bucharest', 'Cluj-Napoca', 'Timisoara', 'Iasi', 'Constanta'],
            'RU' => ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Yekaterinburg', 'Kazan'],
            'RW' => ['Kigali', 'Butare', 'Gisenyi', 'Ruhengeri', 'Byumba'],

            'KN' => ['Basseterre', 'Charlestown', 'Sandy Point Town', 'Cayon', 'Gingerland'],
            'LC' => ['Castries', 'Vieux Fort', 'Gros Islet', 'Soufriere', 'Micoud'],
            'VC' => ['Kingstown', 'Georgetown', 'Barrouallie', 'Chateaubelair', 'Layou'],
            'WS' => ['Apia', 'Vaitele', 'Faleula', 'Siusega', 'Leulumoega'],
            'SM' => ['San Marino', 'Serravalle', 'Borgo Maggiore', 'Domagnano', 'Fiorentino'],
            'ST' => ['Sao Tome', 'Santo Antonio', 'Neves', 'Santana', 'Guadalupe'],
            'SA' => ['Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam'],
            'SN' => ['Dakar', 'Touba', 'Thies', 'Saint-Louis', 'Kaolack'],
            'RS' => ['Belgrade', 'Novi Sad', 'Nis', 'Kragujevac', 'Subotica'],
            'SC' => ['Victoria', 'Beau Vallon', 'Anse Boileau', 'Anse Royale', 'Takamaka'],
            'SL' => ['Freetown', 'Bo', 'Kenema', 'Makeni', 'Koidu'],
            'SG' => ['Singapore'],
            'SK' => ['Bratislava', 'Kosice', 'Presov', 'Zilina', 'Nitra'],
            'SI' => ['Ljubljana', 'Maribor', 'Celje', 'Kranj', 'Koper'],
            'SB' => ['Honiara', 'Gizo', 'Auki', 'Munda', 'Buala'],
            'SO' => ['Mogadishu', 'Hargeisa', 'Kismayo', 'Bosaso', 'Baidoa'],
            'ZA' => ['Johannesburg', 'Cape Town', 'Durban', 'Pretoria', 'Port Elizabeth'],
            'SS' => ['Juba', 'Wau', 'Malakal', 'Yei', 'Bor'],
            'ES' => ['Madrid', 'Barcelona', 'Valencia', 'Seville', 'Zaragoza'],
            'LK' => ['Colombo', 'Kandy', 'Galle', 'Jaffna', 'Negombo'],
            'SD' => ['Khartoum', 'Omdurman', 'Port Sudan', 'Kassala', 'Nyala'],
            'SR' => ['Paramaribo', 'Lelydorp', 'Brokopondo', 'Nieuw Nickerie', 'Moengo'],
            'SE' => ['Stockholm', 'Gothenburg', 'Malmo', 'Uppsala', 'Vasteras'],
            'CH' => ['Zurich', 'Geneva', 'Basel', 'Lausanne', 'Bern'],
            'SY' => ['Damascus', 'Aleppo', 'Homs', 'Latakia', 'Hama'],

            'TJ' => ['Dushanbe', 'Khujand', 'Kulob', 'Bokhtar', 'Istaravshan'],
            'TZ' => ['Dodoma', 'Dar es Salaam', 'Mwanza', 'Arusha', 'Mbeya'],
            'TH' => ['Bangkok', 'Chiang Mai', 'Pattaya', 'Phuket City', 'Nakhon Ratchasima'],
            'TL' => ['Dili', 'Baucau', 'Maliana', 'Suai', 'Lospalos'],
            'TG' => ['Lome', 'Sokode', 'Kara', 'Atakpame', 'Kpalime'],
            'TO' => ['Nuku\'alofa', 'Neiafu', 'Haveluloto', 'Vaini', 'Pangai'],
            'TT' => ['Port of Spain', 'San Fernando', 'Chaguanas', 'Arima', 'Point Fortin'],
            'TN' => ['Tunis', 'Sfax', 'Sousse', 'Ettadhamen', 'Kairouan'],
            'TR' => ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Antalya'],
            'TM' => ['Ashgabat', 'Turkmenabat', 'Dashoguz', 'Mary', 'Balkanabat'],
            'TV' => ['Funafuti'],
            'UG' => ['Kampala', 'Gulu', 'Lira', 'Mbarara', 'Jinja'],
            'UA' => ['Kyiv', 'Kharkiv', 'Odesa', 'Dnipro', 'Lviv'],
            'AE' => ['Dubai', 'Abu Dhabi', 'Sharjah', 'Al Ain', 'Ajman'],
            'GB' => ['London', 'Birmingham', 'Manchester', 'Liverpool', 'Leeds'],
            'US' => ['New York City', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'],
            'UY' => ['Montevideo', 'Salto', 'Ciudad de la Costa', 'Paysandu', 'Las Piedras'],
            'UZ' => ['Tashkent', 'Samarkand', 'Namangan', 'Andijan', 'Bukhara'],

            'VU' => ['Port Vila', 'Luganville', 'Isangel', 'Sola', 'Lakatoro'],
            'VA' => ['Vatican City'],
            'VE' => ['Caracas', 'Maracaibo', 'Valencia', 'Barquisimeto', 'Maracay'],
            'VN' => ['Ho Chi Minh City', 'Hanoi', 'Da Nang', 'Hai Phong', 'Can Tho'],

            'YE' => ['Sana\'a', 'Aden', 'Taiz', 'Hodeidah', 'Ibb'],
            'ZM' => ['Lusaka', 'Kitwe', 'Ndola', 'Kabwe', 'Livingstone'],
            'ZW' => ['Harare', 'Bulawayo', 'Chitungwiza', 'Mutare', 'Gweru'],

        ];

        foreach ($places as $countryCode => $cityNames) {
            $country = Country::where('country_code', $countryCode)->first();

            if (!$country) {
                continue;
            }

            foreach ($cityNames as $cityName) {
                Place::create([
                    'name' => $cityName,
                    'country_id' => $country->id,
                ]);
            }
        }
    }
}