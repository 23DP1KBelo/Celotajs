<?php

namespace Database\Seeders;

use App\Models\Place;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [

            'Riga' => [
                [
                    'title' => 'Riga Castle',
                    'description' => 'A historic castle located on the banks of the Daugava River.',
                ],
                [
                    'title' => 'Freedom Monument',
                    'description' => 'One of the most important national symbols of Latvia.',
                ],
                [
                    'title' => 'House of the Black Heads',
                    'description' => 'A historic building located in the heart of Riga Old Town.',
                ],
                [
                    'title' => 'Riga Central Market',
                    'description' => 'One of the largest and most historic markets in Europe.',
                ],
            ],

            'Daugavpils' => [
                [
                    'title' => 'Daugavpils Fortress',
                    'description' => 'A historic fortress and one of the most important landmarks in Daugavpils.',
                ],
                [
                    'title' => 'Mark Rothko Art Centre',
                    'description' => 'An art centre dedicated to the famous artist Mark Rothko.',
                ],
                [
                    'title' => 'Church Hill',
                    'description' => 'A historic area known for its churches representing different denominations.',
                ],
                [
                    'title' => 'Unity House',
                    'description' => 'A cultural and architectural landmark in the centre of Daugavpils.',
                ],
            ],

            'Liepaja' => [
                [
                    'title' => 'Karosta',
                    'description' => 'A historic military district in the northern part of Liepaja.',
                ],
                [
                    'title' => 'Liepaja Beach',
                    'description' => 'A long sandy Baltic Sea beach popular with visitors and locals.',
                ],
                [
                    'title' => 'Seaside Park',
                    'description' => 'A large park located close to the beach.',
                ],
                [
                    'title' => 'Liepaja Holy Trinity Cathedral',
                    'description' => 'A historic Lutheran cathedral in the centre of Liepaja.',
                ],
            ],

            'Jelgava' => [
                [
                    'title' => 'Jelgava Palace',
                    'description' => 'A historic Baroque palace and one of the main landmarks of Jelgava.',
                ],
                [
                    'title' => 'Jelgava Holy Trinity Church Tower',
                    'description' => 'A tower offering panoramic views over Jelgava.',
                ],
                [
                    'title' => 'Jelgava Promenade',
                    'description' => 'A scenic walking area along the Lielupe River.',
                ],
                [
                    'title' => 'Jelgava History and Art Museum',
                    'description' => 'A museum presenting the history and culture of Jelgava.',
                ],
            ],

            'Jurmala' => [
                [
                    'title' => 'Jurmala Beach',
                    'description' => 'A famous sandy beach stretching along the Gulf of Riga.',
                ],
                [
                    'title' => 'Dzintari Forest Park',
                    'description' => 'A recreational forest park with walking paths and an observation tower.',
                ],
                [
                    'title' => 'Dzintari Concert Hall',
                    'description' => 'A well-known concert venue located in the heart of Jurmala.',
                ],
                [
                    'title' => 'Jurmala Open-Air Museum',
                    'description' => 'A museum presenting the traditional life and fishing heritage of Jurmala.',
                ],
            ],

            'Vilnius' => [
                [
                    'title' => 'Gediminas Castle Tower',
                    'description' => 'A historic tower offering views over the city of Vilnius.',
                ],
                [
                    'title' => 'Vilnius Cathedral',
                    'description' => 'A major Catholic cathedral located in Cathedral Square.',
                ],
                [
                    'title' => 'Gate of Dawn',
                    'description' => 'A historic city gate and important religious landmark.',
                ],
                [
                    'title' => 'Užupis',
                    'description' => 'A distinctive artistic district located in the historic centre of Vilnius.',
                ],
            ],

            'Kaunas' => [
                [
                    'title' => 'Kaunas Castle',
                    'description' => 'A medieval castle located near the confluence of the Nemunas and Neris rivers.',
                ],
                [
                    'title' => 'House of Perkunas',
                    'description' => 'A historic Gothic building in the Old Town of Kaunas.',
                ],
                [
                    'title' => 'Laisves Aleja',
                    'description' => 'A famous pedestrian boulevard in the centre of Kaunas.',
                ],
                [
                    'title' => 'Pažaislis Monastery',
                    'description' => 'A historic Baroque monastery complex near Kaunas.',
                ],
            ],

            'Klaipeda' => [
                [
                    'title' => 'Klaipeda Old Town',
                    'description' => 'A historic district featuring traditional architecture and cobbled streets.',
                ],
                [
                    'title' => 'Klaipeda Castle',
                    'description' => 'The site of a historic castle and museum complex.',
                ],
                [
                    'title' => 'Theatre Square',
                    'description' => 'One of the main public squares in the centre of Klaipeda.',
                ],
                [
                    'title' => 'Lithuanian Sea Museum',
                    'description' => 'A maritime museum located near the northern part of the Curonian Spit.',
                ],
            ],

            'Tallinn' => [
                [
                    'title' => 'Tallinn Old Town',
                    'description' => 'A UNESCO World Heritage historic centre with medieval architecture.',
                ],
                [
                    'title' => 'Alexander Nevsky Cathedral',
                    'description' => 'A distinctive Orthodox cathedral on Toompea Hill.',
                ],
                [
                    'title' => 'Toompea Castle',
                    'description' => 'A historic castle complex located in the centre of Tallinn.',
                ],
                [
                    'title' => 'Kadriorg Palace',
                    'description' => 'A historic Baroque palace surrounded by Kadriorg Park.',
                ],
            ],

            'Tartu' => [
                [
                    'title' => 'Tartu University',
                    'description' => 'The historic main building of the University of Tartu.',
                ],
                [
                    'title' => 'Tartu Town Hall',
                    'description' => 'A historic town hall located in the centre of Tartu.',
                ],
                [
                    'title' => 'AHHAA Science Centre',
                    'description' => 'An interactive science centre suitable for visitors of all ages.',
                ],
                [
                    'title' => 'Toome Hill',
                    'description' => 'A historic park area with views and important university landmarks.',
                ],
            ],

            'Warsaw' => [
                [
                    'title' => 'Royal Castle',
                    'description' => 'A historic castle and former royal residence in Warsaw.',
                ],
                [
                    'title' => 'Old Town',
                    'description' => 'The historic centre of Warsaw with its reconstructed medieval streets.',
                ],
                [
                    'title' => 'Palace of Culture and Science',
                    'description' => 'One of the most recognizable buildings in Warsaw.',
                ],
                [
                    'title' => 'Łazienki Park',
                    'description' => 'A large historic park featuring palaces, gardens and monuments.',
                ],
            ],

            'Berlin' => [
                [
                    'title' => 'Brandenburg Gate',
                    'description' => 'One of the most famous landmarks of Berlin.',
                ],
                [
                    'title' => 'Reichstag Building',
                    'description' => 'The historic seat of the German Bundestag.',
                ],
                [
                    'title' => 'Museum Island',
                    'description' => 'A historic museum complex located in central Berlin.',
                ],
                [
                    'title' => 'Berlin Wall Memorial',
                    'description' => 'A memorial site documenting the history of the Berlin Wall.',
                ],
            ],

            'Paris' => [
                [
                    'title' => 'Eiffel Tower',
                    'description' => 'The iconic landmark and symbol of Paris.',
                ],
                [
                    'title' => 'Louvre Museum',
                    'description' => 'One of the world’s most famous museums.',
                ],
                [
                    'title' => 'Notre-Dame Cathedral',
                    'description' => 'A historic Gothic cathedral located on the Île de la Cité.',
                ],
                [
                    'title' => 'Arc de Triomphe',
                    'description' => 'A monumental arch located at the western end of the Champs-Élysées.',
                ],
            ],

            'Rome' => [
                [
                    'title' => 'Colosseum',
                    'description' => 'An ancient Roman amphitheatre and one of Rome’s most famous landmarks.',
                ],
                [
                    'title' => 'Trevi Fountain',
                    'description' => 'A famous Baroque fountain in the centre of Rome.',
                ],
                [
                    'title' => 'Pantheon',
                    'description' => 'An exceptionally preserved ancient Roman building.',
                ],
                [
                    'title' => 'Roman Forum',
                    'description' => 'The archaeological remains of the ancient centre of Roman public life.',
                ],
            ],

            'London' => [
                [
                    'title' => 'Big Ben',
                    'description' => 'The famous clock tower at the Palace of Westminster.',
                ],
                [
                    'title' => 'Tower of London',
                    'description' => 'A historic fortress on the banks of the River Thames.',
                ],
                [
                    'title' => 'Buckingham Palace',
                    'description' => 'The famous London residence of the British monarch.',
                ],
                [
                    'title' => 'London Eye',
                    'description' => 'A large observation wheel on the South Bank of the River Thames.',
                ],
            ],

            'New York City' => [
                [
                    'title' => 'Statue of Liberty',
                    'description' => 'A famous monument located on Liberty Island.',
                ],
                [
                    'title' => 'Empire State Building',
                    'description' => 'One of the most recognizable skyscrapers in New York City.',
                ],
                [
                    'title' => 'Central Park',
                    'description' => 'A large urban park in the centre of Manhattan.',
                ],
                [
                    'title' => 'Times Square',
                    'description' => 'A major commercial and entertainment area in Manhattan.',
                ],
            ],

            'Tokyo' => [
                [
                    'title' => 'Tokyo Skytree',
                    'description' => 'A broadcasting and observation tower offering views over Tokyo.',
                ],
                [
                    'title' => 'Senso-ji Temple',
                    'description' => 'One of Tokyo’s oldest and most famous Buddhist temples.',
                ],
                [
                    'title' => 'Meiji Shrine',
                    'description' => 'A Shinto shrine surrounded by forest in central Tokyo.',
                ],
                [
                    'title' => 'Tokyo Imperial Palace',
                    'description' => 'The main residence of the Emperor of Japan.',
                ],
            ],

            'Sydney' => [
                [
                    'title' => 'Sydney Opera House',
                    'description' => 'An internationally recognized performing arts centre.',
                ],
                [
                    'title' => 'Sydney Harbour Bridge',
                    'description' => 'A major landmark crossing Sydney Harbour.',
                ],
                [
                    'title' => 'Bondi Beach',
                    'description' => 'One of Sydney’s most famous beaches.',
                ],
                [
                    'title' => 'Royal Botanic Garden',
                    'description' => 'A large botanical garden overlooking Sydney Harbour.',
                ],
            ],

            'Dubai' => [
                [
                    'title' => 'Burj Khalifa',
                    'description' => 'The world-famous skyscraper dominating the Dubai skyline.',
                ],
                [
                    'title' => 'Dubai Mall',
                    'description' => 'One of the largest shopping and entertainment complexes in the world.',
                ],
                [
                    'title' => 'Palm Jumeirah',
                    'description' => 'An iconic artificial island shaped like a palm tree.',
                ],
                [
                    'title' => 'Dubai Creek',
                    'description' => 'A historic waterway that played an important role in Dubai’s development.',
                ],
            ],

            'Singapore' => [
                [
                    'title' => 'Marina Bay Sands',
                    'description' => 'A major hotel, entertainment and architectural landmark.',
                ],
                [
                    'title' => 'Gardens by the Bay',
                    'description' => 'A large futuristic garden complex featuring the famous Supertrees.',
                ],
                [
                    'title' => 'Merlion Park',
                    'description' => 'A waterfront landmark featuring Singapore’s famous Merlion statue.',
                ],
                [
                    'title' => 'Sentosa Island',
                    'description' => 'A popular island resort with beaches and attractions.',
                ],
            ],

            'Toronto' => [
                [
                    'title' => 'CN Tower',
                    'description' => 'A famous telecommunications and observation tower.',
                ],
                [
                    'title' => 'Royal Ontario Museum',
                    'description' => 'A major museum of art, culture and natural history.',
                ],
                [
                    'title' => 'Casa Loma',
                    'description' => 'A historic Gothic Revival mansion and museum.',
                ],
                [
                    'title' => 'St. Lawrence Market',
                    'description' => 'A historic market in downtown Toronto.',
                ],
            ],

            'Mexico City' => [
                [
                    'title' => 'Zocalo',
                    'description' => 'The main central square of Mexico City.',
                ],
                [
                    'title' => 'Chapultepec Castle',
                    'description' => 'A historic castle located in Chapultepec Park.',
                ],
                [
                    'title' => 'Frida Kahlo Museum',
                    'description' => 'A museum located in the former home of artist Frida Kahlo.',
                ],
                [
                    'title' => 'Palace of Fine Arts',
                    'description' => 'A major cultural and architectural landmark in Mexico City.',
                ],
            ],

            'Buenos Aires' => [
                [
                    'title' => 'Obelisco',
                    'description' => 'A famous monument located on Avenida 9 de Julio.',
                ],
                [
                    'title' => 'Casa Rosada',
                    'description' => 'The historic government palace overlooking Plaza de Mayo.',
                ],
                [
                    'title' => 'La Boca',
                    'description' => 'A colourful neighbourhood famous for Caminito street.',
                ],
                [
                    'title' => 'Recoleta Cemetery',
                    'description' => 'A historic cemetery known for its elaborate monuments and tombs.',
                ],
            ],

            'Rio de Janeiro' => [
                [
                    'title' => 'Christ the Redeemer',
                    'description' => 'The famous statue overlooking Rio de Janeiro.',
                ],
                [
                    'title' => 'Sugarloaf Mountain',
                    'description' => 'A distinctive mountain offering panoramic views of the city.',
                ],
                [
                    'title' => 'Copacabana Beach',
                    'description' => 'One of the world’s best-known urban beaches.',
                ],
                [
                    'title' => 'Tijuca National Park',
                    'description' => 'A large urban rainforest surrounding parts of Rio de Janeiro.',
                ],
            ],

            'Cape Town' => [
                [
                    'title' => 'Table Mountain',
                    'description' => 'The iconic flat-topped mountain overlooking Cape Town.',
                ],
                [
                    'title' => 'Robben Island',
                    'description' => 'A historic island and former prison site.',
                ],
                [
                    'title' => 'V&A Waterfront',
                    'description' => 'A popular waterfront area with shops, restaurants and attractions.',
                ],
                [
                    'title' => 'Kirstenbosch Botanical Garden',
                    'description' => 'A famous botanical garden located at the eastern slopes of Table Mountain.',
                ],
            ],

            'Cairo' => [
                [
                    'title' => 'Giza Pyramids',
                    'description' => 'The famous ancient pyramids located near Cairo.',
                ],
                [
                    'title' => 'Great Sphinx of Giza',
                    'description' => 'An ancient limestone monument near the Giza pyramids.',
                ],
                [
                    'title' => 'Egyptian Museum',
                    'description' => 'A major museum containing ancient Egyptian artefacts.',
                ],
                [
                    'title' => 'Khan el-Khalili',
                    'description' => 'A historic bazaar in Islamic Cairo.',
                ],
            ],

            'Istanbul' => [
                [
                    'title' => 'Hagia Sophia',
                    'description' => 'A historic monument reflecting the Byzantine and Ottoman history of Istanbul.',
                ],
                [
                    'title' => 'Blue Mosque',
                    'description' => 'A famous Ottoman-era mosque near Sultanahmet Square.',
                ],
                [
                    'title' => 'Topkapi Palace',
                    'description' => 'A historic Ottoman palace overlooking the Bosphorus.',
                ],
                [
                    'title' => 'Grand Bazaar',
                    'description' => 'One of the largest and oldest covered markets in the world.',
                ],
            ],

            'Bangkok' => [
                [
                    'title' => 'Grand Palace',
                    'description' => 'A historic royal complex in central Bangkok.',
                ],
                [
                    'title' => 'Wat Arun',
                    'description' => 'A famous Buddhist temple located on the Chao Phraya River.',
                ],
                [
                    'title' => 'Wat Pho',
                    'description' => 'A historic temple complex famous for its reclining Buddha.',
                ],
                [
                    'title' => 'Chatuchak Weekend Market',
                    'description' => 'One of Bangkok’s largest markets.',
                ],
            ],

            'Seoul' => [
                [
                    'title' => 'Gyeongbokgung Palace',
                    'description' => 'The largest of the Five Grand Palaces of Seoul.',
                ],
                [
                    'title' => 'N Seoul Tower',
                    'description' => 'An observation tower offering panoramic views over Seoul.',
                ],
                [
                    'title' => 'Bukchon Hanok Village',
                    'description' => 'A historic neighbourhood with traditional Korean houses.',
                ],
                [
                    'title' => 'Myeongdong',
                    'description' => 'A popular shopping and entertainment district in central Seoul.',
                ],
            ],

            'Beijing' => [
                [
                    'title' => 'Forbidden City',
                    'description' => 'A vast imperial palace complex in central Beijing.',
                ],
                [
                    'title' => 'Great Wall of China',
                    'description' => 'A famous historic defensive structure accessible from Beijing.',
                ],
                [
                    'title' => 'Temple of Heaven',
                    'description' => 'A historic imperial religious complex in Beijing.',
                ],
                [
                    'title' => 'Summer Palace',
                    'description' => 'A historic imperial garden and palace complex.',
                ],
            ],

            'Delhi' => [
                [
                    'title' => 'Red Fort',
                    'description' => 'A historic Mughal fortress in Old Delhi.',
                ],
                [
                    'title' => 'India Gate',
                    'description' => 'A prominent war memorial in central Delhi.',
                ],
                [
                    'title' => 'Qutub Minar',
                    'description' => 'A historic minaret and UNESCO World Heritage Site.',
                ],
                [
                    'title' => 'Humayun\'s Tomb',
                    'description' => 'A historic Mughal tomb complex.',
                ],
            ],

            'Moscow' => [
                [
                    'title' => 'Red Square',
                    'description' => 'The famous central square of Moscow.',
                ],
                [
                    'title' => 'Moscow Kremlin',
                    'description' => 'A historic fortified complex and political centre.',
                ],
                [
                    'title' => 'Saint Basil\'s Cathedral',
                    'description' => 'A distinctive cathedral located beside Red Square.',
                ],
                [
                    'title' => 'Tretyakov Gallery',
                    'description' => 'A major museum of Russian art.',
                ],
            ],

            'Athens' => [
                [
                    'title' => 'Acropolis',
                    'description' => 'The ancient citadel overlooking Athens.',
                ],
                [
                    'title' => 'Parthenon',
                    'description' => 'The famous ancient temple on the Acropolis.',
                ],
                [
                    'title' => 'Acropolis Museum',
                    'description' => 'A museum dedicated to archaeological finds from the Acropolis.',
                ],
                [
                    'title' => 'Ancient Agora',
                    'description' => 'An important archaeological site in ancient Athens.',
                ],
            ],

            'Amsterdam' => [
                [
                    'title' => 'Rijksmuseum',
                    'description' => 'A major Dutch national museum.',
                ],
                [
                    'title' => 'Van Gogh Museum',
                    'description' => 'A museum dedicated to the works of Vincent van Gogh.',
                ],
                [
                    'title' => 'Anne Frank House',
                    'description' => 'A historic house and museum associated with Anne Frank.',
                ],
                [
                    'title' => 'Dam Square',
                    'description' => 'A central historic square in Amsterdam.',
                ],
            ],

            'Lisbon' => [
                [
                    'title' => 'Belem Tower',
                    'description' => 'A historic fortified tower on the Tagus River.',
                ],
                [
                    'title' => 'Jeronimos Monastery',
                    'description' => 'A famous Manueline-style monastery in Belem.',
                ],
                [
                    'title' => 'Sao Jorge Castle',
                    'description' => 'A historic castle overlooking central Lisbon.',
                ],
                [
                    'title' => 'Praca do Comercio',
                    'description' => 'A large waterfront square in central Lisbon.',
                ],
            ],

            'Madrid' => [
                [
                    'title' => 'Royal Palace of Madrid',
                    'description' => 'A historic royal palace in central Madrid.',
                ],
                [
                    'title' => 'Prado Museum',
                    'description' => 'One of the world’s most important art museums.',
                ],
                [
                    'title' => 'Retiro Park',
                    'description' => 'A historic park in the centre of Madrid.',
                ],
                [
                    'title' => 'Puerta del Sol',
                    'description' => 'One of Madrid’s best-known central squares.',
                ],
            ],

            'Vienna' => [
                [
                    'title' => 'Schonbrunn Palace',
                    'description' => 'A historic imperial palace and gardens.',
                ],
                [
                    'title' => 'Hofburg Palace',
                    'description' => 'A major former imperial residence in central Vienna.',
                ],
                [
                    'title' => 'St. Stephen\'s Cathedral',
                    'description' => 'A famous Gothic cathedral in the centre of Vienna.',
                ],
                [
                    'title' => 'Belvedere Palace',
                    'description' => 'A historic Baroque palace complex and art museum.',
                ],
            ],

            'Prague' => [
                [
                    'title' => 'Prague Castle',
                    'description' => 'A historic castle complex overlooking Prague.',
                ],
                [
                    'title' => 'Charles Bridge',
                    'description' => 'A historic bridge crossing the Vltava River.',
                ],
                [
                    'title' => 'Old Town Square',
                    'description' => 'The historic central square of Prague.',
                ],
                [
                    'title' => 'Astronomical Clock',
                    'description' => 'A famous medieval astronomical clock on Prague Old Town Hall.',
                ],
            ],

            'Budapest' => [
                [
                    'title' => 'Buda Castle',
                    'description' => 'A historic castle complex overlooking the Danube.',
                ],
                [
                    'title' => 'Hungarian Parliament Building',
                    'description' => 'One of Budapest’s most recognizable landmarks.',
                ],
                [
                    'title' => 'Fisherman\'s Bastion',
                    'description' => 'A historic terrace offering views over the city.',
                ],
                [
                    'title' => 'Széchenyi Thermal Bath',
                    'description' => 'One of Budapest’s famous historic thermal baths.',
                ],
            ],

            'Stockholm' => [
                [
                    'title' => 'Vasa Museum',
                    'description' => 'A museum housing the preserved 17th-century Vasa warship.',
                ],
                [
                    'title' => 'Stockholm Palace',
                    'description' => 'The official royal palace in central Stockholm.',
                ],
                [
                    'title' => 'Gamla Stan',
                    'description' => 'Stockholm’s historic old town.',
                ],
                [
                    'title' => 'ABBA The Museum',
                    'description' => 'A museum dedicated to the Swedish music group ABBA.',
                ],
            ],

            'Helsinki' => [
                [
                    'title' => 'Helsinki Cathedral',
                    'description' => 'A distinctive white cathedral overlooking Senate Square.',
                ],
                [
                    'title' => 'Suomenlinna',
                    'description' => 'A historic sea fortress located on islands off Helsinki.',
                ],
                [
                    'title' => 'Temppeliaukio Church',
                    'description' => 'A famous rock church carved directly into solid rock.',
                ],
                [
                    'title' => 'Market Square',
                    'description' => 'A lively waterfront market in central Helsinki.',
                ],
            ],

            'Oslo' => [
                [
                    'title' => 'Vigeland Sculpture Park',
                    'description' => 'A large park containing works by sculptor Gustav Vigeland.',
                ],
                [
                    'title' => 'Oslo Opera House',
                    'description' => 'A modern architectural landmark on Oslo’s waterfront.',
                ],
                [
                    'title' => 'Viking Ship Museum',
                    'description' => 'A museum known for its historic Viking ships.',
                ],
                [
                    'title' => 'Akershus Fortress',
                    'description' => 'A historic fortress overlooking Oslo Harbour.',
                ],
            ],

            'Copenhagen' => [
                [
                    'title' => 'Tivoli Gardens',
                    'description' => 'A historic amusement park in central Copenhagen.',
                ],
                [
                    'title' => 'Nyhavn',
                    'description' => 'A colourful historic harbour district.',
                ],
                [
                    'title' => 'Rosenborg Castle',
                    'description' => 'A historic Renaissance castle surrounded by gardens.',
                ],
                [
                    'title' => 'The Little Mermaid',
                    'description' => 'A famous statue inspired by Hans Christian Andersen’s fairy tale.',
                ],
            ],

            'Zurich' => [
                [
                    'title' => 'Old Town',
                    'description' => 'The historic centre of Zurich.',
                ],
                [
                    'title' => 'Grossmunster',
                    'description' => 'A famous twin-towered church in Zurich.',
                ],
                [
                    'title' => 'Lake Zurich',
                    'description' => 'A scenic lake directly beside the city.',
                ],
                [
                    'title' => 'Swiss National Museum',
                    'description' => 'A museum presenting Swiss cultural history.',
                ],
            ],

            'Brussels' => [
                [
                    'title' => 'Grand Place',
                    'description' => 'The historic central square of Brussels.',
                ],
                [
                    'title' => 'Atomium',
                    'description' => 'A distinctive landmark built for the 1958 Brussels World Expo.',
                ],
                [
                    'title' => 'Manneken Pis',
                    'description' => 'A famous bronze statue in central Brussels.',
                ],
                [
                    'title' => 'Royal Palace of Brussels',
                    'description' => 'The official palace of the Belgian monarch.',
                ],
            ],

            'Dublin' => [
                [
                    'title' => 'Dublin Castle',
                    'description' => 'A historic castle complex in central Dublin.',
                ],
                [
                    'title' => 'Trinity College',
                    'description' => 'Ireland’s historic university known for the Book of Kells.',
                ],
                [
                    'title' => 'Guinness Storehouse',
                    'description' => 'A visitor attraction dedicated to the history of Guinness.',
                ],
                [
                    'title' => 'St. Patrick\'s Cathedral',
                    'description' => 'The largest cathedral in Ireland.',
                ],
            ],

            'Edinburgh' => [
                [
                    'title' => 'Edinburgh Castle',
                    'description' => 'A historic castle dominating the Edinburgh skyline.',
                ],
                [
                    'title' => 'Royal Mile',
                    'description' => 'A historic street connecting Edinburgh Castle and Holyrood Palace.',
                ],
                [
                    'title' => 'Palace of Holyroodhouse',
                    'description' => 'The official Scottish residence of the British monarch.',
                ],
                [
                    'title' => 'Arthur\'s Seat',
                    'description' => 'An ancient volcanic hill offering panoramic views over Edinburgh.',
                ],
            ],

            'Los Angeles' => [
                [
                    'title' => 'Hollywood Sign',
                    'description' => 'The iconic sign overlooking Hollywood.',
                ],
                [
                    'title' => 'Griffith Observatory',
                    'description' => 'An observatory offering views of Los Angeles and the Hollywood Sign.',
                ],
                [
                    'title' => 'Santa Monica Pier',
                    'description' => 'A historic pier and entertainment landmark on the Pacific coast.',
                ],
                [
                    'title' => 'Getty Center',
                    'description' => 'A major art museum and cultural centre overlooking Los Angeles.',
                ],
            ],

            'Chicago' => [
                [
                    'title' => 'Millennium Park',
                    'description' => 'A famous downtown park featuring Cloud Gate.',
                ],
                [
                    'title' => 'Art Institute of Chicago',
                    'description' => 'One of the largest and most important art museums in the United States.',
                ],
                [
                    'title' => 'Navy Pier',
                    'description' => 'A major entertainment and recreation destination on Lake Michigan.',
                ],
                [
                    'title' => 'Willis Tower',
                    'description' => 'A famous Chicago skyscraper with an observation deck.',
                ],
            ],

            'San Francisco' => [
                [
                    'title' => 'Golden Gate Bridge',
                    'description' => 'One of the world’s most recognizable suspension bridges.',
                ],
                [
                    'title' => 'Alcatraz Island',
                    'description' => 'A historic island and former federal prison.',
                ],
                [
                    'title' => 'Fisherman\'s Wharf',
                    'description' => 'A popular waterfront neighbourhood.',
                ],
                [
                    'title' => 'Lombard Street',
                    'description' => 'A famous steep and winding street.',
                ],
            ],

            'Washington' => [
                [
                    'title' => 'White House',
                    'description' => 'The official residence and workplace of the President of the United States.',
                ],
                [
                    'title' => 'Lincoln Memorial',
                    'description' => 'A major memorial on the National Mall.',
                ],
                [
                    'title' => 'Washington Monument',
                    'description' => 'A prominent obelisk dedicated to George Washington.',
                ],
                [
                    'title' => 'United States Capitol',
                    'description' => 'The meeting place of the United States Congress.',
                ],
            ],

            'Vancouver' => [
                [
                    'title' => 'Stanley Park',
                    'description' => 'A large urban park beside Vancouver Harbour.',
                ],
                [
                    'title' => 'Capilano Suspension Bridge',
                    'description' => 'A famous suspension bridge surrounded by rainforest.',
                ],
                [
                    'title' => 'Granville Island',
                    'description' => 'A popular cultural and market district.',
                ],
                [
                    'title' => 'Vancouver Lookout',
                    'description' => 'An observation deck offering panoramic views over Vancouver.',
                ],
            ],

            'Montreal' => [
                [
                    'title' => 'Old Montreal',
                    'description' => 'A historic district with preserved architecture and cobbled streets.',
                ],
                [
                    'title' => 'Notre-Dame Basilica',
                    'description' => 'A famous Gothic Revival basilica in Old Montreal.',
                ],
                [
                    'title' => 'Mount Royal',
                    'description' => 'A large green space overlooking Montreal.',
                ],
                [
                    'title' => 'Montreal Botanical Garden',
                    'description' => 'One of the largest botanical gardens in the world.',
                ],
            ],

            'Sao Paulo' => [
                [
                    'title' => 'Paulista Avenue',
                    'description' => 'One of the most important avenues in Sao Paulo.',
                ],
                [
                    'title' => 'Ibirapuera Park',
                    'description' => 'A large urban park and cultural area.',
                ],
                [
                    'title' => 'MASP',
                    'description' => 'The Sao Paulo Museum of Art.',
                ],
                [
                    'title' => 'Municipal Market of Sao Paulo',
                    'description' => 'A historic food market in central Sao Paulo.',
                ],
            ],

            'Lima' => [
                [
                    'title' => 'Historic Centre of Lima',
                    'description' => 'A UNESCO World Heritage historic centre.',
                ],
                [
                    'title' => 'Plaza de Armas',
                    'description' => 'The main historic square of Lima.',
                ],
                [
                    'title' => 'Larco Museum',
                    'description' => 'A museum featuring a large collection of ancient Peruvian art.',
                ],
                [
                    'title' => 'Miraflores',
                    'description' => 'A popular coastal district known for parks, restaurants and ocean views.',
                ],
            ],

            'Santiago' => [
                [
                    'title' => 'San Cristobal Hill',
                    'description' => 'A hill offering panoramic views over Santiago.',
                ],
                [
                    'title' => 'La Moneda Palace',
                    'description' => 'The historic seat of the Chilean government.',
                ],
                [
                    'title' => 'Plaza de Armas',
                    'description' => 'The main historic square in central Santiago.',
                ],
                [
                    'title' => 'Sky Costanera',
                    'description' => 'An observation deck with panoramic views over Santiago.',
                ],
            ],

            'Bogota' => [
                [
                    'title' => 'Gold Museum',
                    'description' => 'A museum containing one of the world’s largest collections of pre-Columbian gold.',
                ],
                [
                    'title' => 'Monserrate',
                    'description' => 'A mountain and pilgrimage site overlooking Bogota.',
                ],
                [
                    'title' => 'La Candelaria',
                    'description' => 'Bogota’s historic colonial district.',
                ],
                [
                    'title' => 'Botero Museum',
                    'description' => 'A museum featuring works by Fernando Botero and other artists.',
                ],
            ],

            'Reykjavik' => [
                [
                    'title' => 'Hallgrimskirkja',
                    'description' => 'A distinctive Lutheran church and major Reykjavik landmark.',
                ],
                [
                    'title' => 'Harpa Concert Hall',
                    'description' => 'A modern concert hall on Reykjavik’s waterfront.',
                ],
                [
                    'title' => 'Sun Voyager',
                    'description' => 'A famous steel sculpture beside the sea.',
                ],
                [
                    'title' => 'Perlan',
                    'description' => 'A museum and observation centre offering views over Reykjavik.',
                ],
            ],

            'Zagreb' => [
                [
                    'title' => 'Zagreb Cathedral',
                    'description' => 'A major Gothic cathedral in the historic centre.',
                ],
                [
                    'title' => 'Ban Jelacic Square',
                    'description' => 'The main central square of Zagreb.',
                ],
                [
                    'title' => 'Upper Town',
                    'description' => 'A historic district with medieval streets and landmarks.',
                ],
                [
                    'title' => 'Museum of Broken Relationships',
                    'description' => 'A unique museum dedicated to personal stories of relationships.',
                ],
            ],

            'Sarajevo' => [
                [
                    'title' => 'Bascarsija',
                    'description' => 'The historic Ottoman-era bazaar and cultural centre of Sarajevo.',
                ],
                [
                    'title' => 'Latin Bridge',
                    'description' => 'A historic bridge over the Miljacka River.',
                ],
                [
                    'title' => 'Sarajevo Tunnel Museum',
                    'description' => 'A museum documenting the Sarajevo Tunnel during the siege of the city.',
                ],
                [
                    'title' => 'Yellow Fortress',
                    'description' => 'A historic fortress offering views over Sarajevo.',
                ],
            ],

            'Belgrade' => [
                [
                    'title' => 'Belgrade Fortress',
                    'description' => 'A historic fortress overlooking the confluence of the Sava and Danube rivers.',
                ],
                [
                    'title' => 'Church of Saint Sava',
                    'description' => 'One of the largest Orthodox churches in the world.',
                ],
                [
                    'title' => 'Knez Mihailova Street',
                    'description' => 'The main pedestrian shopping street in central Belgrade.',
                ],
                [
                    'title' => 'Nikola Tesla Museum',
                    'description' => 'A museum dedicated to the life and work of Nikola Tesla.',
                ],
            ],

            'Ljubljana' => [
                [
                    'title' => 'Ljubljana Castle',
                    'description' => 'A historic castle overlooking the city.',
                ],
                [
                    'title' => 'Triple Bridge',
                    'description' => 'A distinctive bridge complex in the centre of Ljubljana.',
                ],
                [
                    'title' => 'Preseren Square',
                    'description' => 'The central square of Ljubljana.',
                ],
                [
                    'title' => 'Dragon Bridge',
                    'description' => 'A famous Art Nouveau bridge decorated with dragon statues.',
                ],
            ],

            'Bratislava' => [
                [
                    'title' => 'Bratislava Castle',
                    'description' => 'A historic castle overlooking the Danube River.',
                ],
                [
                    'title' => 'Old Town',
                    'description' => 'The historic centre of Bratislava.',
                ],
                [
                    'title' => 'St. Martin\'s Cathedral',
                    'description' => 'A historic Gothic cathedral in Bratislava.',
                ],
                [
                    'title' => 'Michael\'s Gate',
                    'description' => 'The only preserved medieval city gate in Bratislava.',
                ],
            ],

            'Bucharest' => [
                [
                    'title' => 'Palace of Parliament',
                    'description' => 'One of the largest administrative buildings in the world.',
                ],
                [
                    'title' => 'Romanian Athenaeum',
                    'description' => 'A famous concert hall and architectural landmark.',
                ],
                [
                    'title' => 'Old Town',
                    'description' => 'A historic central district with restaurants and preserved buildings.',
                ],
                [
                    'title' => 'Village Museum',
                    'description' => 'An open-air museum presenting traditional Romanian village life.',
                ],
            ],

            'Kyiv' => [
                [
                    'title' => 'Saint Sophia Cathedral',
                    'description' => 'A historic cathedral and UNESCO World Heritage Site.',
                ],
                [
                    'title' => 'Kyiv Pechersk Lavra',
                    'description' => 'A historic monastery complex with underground caves.',
                ],
                [
                    'title' => 'Maidan Nezalezhnosti',
                    'description' => 'The central square of Kyiv.',
                ],
                [
                    'title' => 'Golden Gate',
                    'description' => 'A reconstructed medieval gateway of Kyiv.',
                ],
            ],

            'Tbilisi' => [
                [
                    'title' => 'Narikala Fortress',
                    'description' => 'A historic fortress overlooking Tbilisi.',
                ],
                [
                    'title' => 'Old Tbilisi',
                    'description' => 'A historic district known for traditional architecture and narrow streets.',
                ],
                [
                    'title' => 'Sameba Cathedral',
                    'description' => 'A major Georgian Orthodox cathedral.',
                ],
                [
                    'title' => 'Bridge of Peace',
                    'description' => 'A modern pedestrian bridge crossing the Kura River.',
                ],
            ],

            'Yerevan' => [
                [
                    'title' => 'Republic Square',
                    'description' => 'The main central square of Yerevan.',
                ],
                [
                    'title' => 'Cascade Complex',
                    'description' => 'A large stairway and arts complex overlooking the city.',
                ],
                [
                    'title' => 'Matenadaran',
                    'description' => 'A museum and research centre containing ancient Armenian manuscripts.',
                ],
                [
                    'title' => 'Armenian Genocide Memorial',
                    'description' => 'A memorial complex dedicated to the victims of the Armenian genocide.',
                ],
            ],

            'Almaty' => [
                [
                    'title' => 'Kok Tobe',
                    'description' => 'A mountain and recreation area overlooking Almaty.',
                ],
                [
                    'title' => 'Panfilov Park',
                    'description' => 'A historic park containing the Ascension Cathedral.',
                ],
                [
                    'title' => 'Ascension Cathedral',
                    'description' => 'A colourful historic wooden Orthodox cathedral.',
                ],
                [
                    'title' => 'Medeu',
                    'description' => 'A famous high-altitude sports complex near Almaty.',
                ],
            ],

            'Ulaanbaatar' => [
                [
                    'title' => 'Gandan Monastery',
                    'description' => 'One of Mongolia’s most important Buddhist monasteries.',
                ],
                [
                    'title' => 'Sukhbaatar Square',
                    'description' => 'The central square of Ulaanbaatar.',
                ],
                [
                    'title' => 'National Museum of Mongolia',
                    'description' => 'A museum presenting the history and culture of Mongolia.',
                ],
                [
                    'title' => 'Zaisan Memorial',
                    'description' => 'A hilltop memorial offering views over Ulaanbaatar.',
                ],
            ],

            'Kathmandu' => [
                [
                    'title' => 'Swayambhunath',
                    'description' => 'An ancient religious complex commonly known as the Monkey Temple.',
                ],
                [
                    'title' => 'Boudhanath Stupa',
                    'description' => 'One of the largest Buddhist stupas in Nepal.',
                ],
                [
                    'title' => 'Pashupatinath Temple',
                    'description' => 'An important Hindu temple complex on the Bagmati River.',
                ],
                [
                    'title' => 'Kathmandu Durbar Square',
                    'description' => 'A historic palace square in the heart of Kathmandu.',
                ],
            ],

            'Colombo' => [
                [
                    'title' => 'Gangaramaya Temple',
                    'description' => 'A major Buddhist temple and cultural centre.',
                ],
                [
                    'title' => 'Galle Face Green',
                    'description' => 'A popular oceanfront promenade.',
                ],
                [
                    'title' => 'Colombo National Museum',
                    'description' => 'The largest museum in Sri Lanka.',
                ],
                [
                    'title' => 'Jami Ul-Alfar Mosque',
                    'description' => 'A distinctive historic mosque in Colombo.',
                ],
            ],

            'Hanoi' => [
                [
                    'title' => 'Hoan Kiem Lake',
                    'description' => 'A famous lake in the centre of Hanoi.',
                ],
                [
                    'title' => 'Temple of Literature',
                    'description' => 'A historic temple and centre of learning.',
                ],
                [
                    'title' => 'Ho Chi Minh Mausoleum',
                    'description' => 'A major memorial complex in Hanoi.',
                ],
                [
                    'title' => 'Old Quarter',
                    'description' => 'A historic district known for its narrow streets and traditional shops.',
                ],
            ],

            'Jakarta' => [
                [
                    'title' => 'National Monument',
                    'description' => 'An iconic monument in central Jakarta.',
                ],
                [
                    'title' => 'Istiqlal Mosque',
                    'description' => 'The largest mosque in Indonesia.',
                ],
                [
                    'title' => 'Jakarta Old Town',
                    'description' => 'A historic district with Dutch colonial architecture.',
                ],
                [
                    'title' => 'National Museum of Indonesia',
                    'description' => 'A major museum covering Indonesian history and culture.',
                ],
            ],

            'Manila' => [
                [
                    'title' => 'Intramuros',
                    'description' => 'The historic walled city of Manila.',
                ],
                [
                    'title' => 'Rizal Park',
                    'description' => 'A major urban park and national landmark.',
                ],
                [
                    'title' => 'Manila Ocean Park',
                    'description' => 'A large marine-life themed attraction.',
                ],
                [
                    'title' => 'San Agustin Church',
                    'description' => 'A historic Spanish colonial church in Intramuros.',
                ],
            ],

            'Auckland' => [
                [
                    'title' => 'Sky Tower',
                    'description' => 'A landmark observation and telecommunications tower.',
                ],
                [
                    'title' => 'Auckland War Memorial Museum',
                    'description' => 'A major museum covering New Zealand history and culture.',
                ],
                [
                    'title' => 'Auckland Domain',
                    'description' => 'One of Auckland’s oldest parks.',
                ],
                [
                    'title' => 'Waiheke Island',
                    'description' => 'An island destination known for beaches, vineyards and scenery.',
                ],
            ],

            'Wellington' => [
                [
                    'title' => 'Te Papa Tongarewa',
                    'description' => 'New Zealand’s national museum.',
                ],
                [
                    'title' => 'Wellington Cable Car',
                    'description' => 'A historic cable car offering views over Wellington.',
                ],
                [
                    'title' => 'Mount Victoria',
                    'description' => 'A hill offering panoramic views over Wellington.',
                ],
                [
                    'title' => 'Wellington Botanic Garden',
                    'description' => 'A large botanical garden overlooking the city.',
                ],
            ],

            'Perth' => [
                [
                    'title' => 'Kings Park',
                    'description' => 'A large park and botanical garden overlooking Perth.',
                ],
                [
                    'title' => 'Elizabeth Quay',
                    'description' => 'A waterfront entertainment and recreation area.',
                ],
                [
                    'title' => 'Perth Zoo',
                    'description' => 'A major zoological attraction in Perth.',
                ],
                [
                    'title' => 'Bell Tower',
                    'description' => 'A distinctive bell tower overlooking the Swan River.',
                ],
            ],

            'Melbourne' => [
                [
                    'title' => 'Federation Square',
                    'description' => 'A major cultural and public space in central Melbourne.',
                ],
                [
                    'title' => 'Royal Botanic Gardens',
                    'description' => 'A large botanical garden near central Melbourne.',
                ],
                [
                    'title' => 'Queen Victoria Market',
                    'description' => 'A historic market and major Melbourne attraction.',
                ],
                [
                    'title' => 'Melbourne Cricket Ground',
                    'description' => 'One of Australia’s most famous sporting venues.',
                ],
            ],

            'Brisbane' => [
                [
                    'title' => 'South Bank Parklands',
                    'description' => 'A popular riverside recreation and cultural area.',
                ],
                [
                    'title' => 'Lone Pine Koala Sanctuary',
                    'description' => 'A wildlife sanctuary known for its koalas.',
                ],
                [
                    'title' => 'Story Bridge',
                    'description' => 'A major bridge and Brisbane landmark.',
                ],
                [
                    'title' => 'Brisbane City Botanic Gardens',
                    'description' => 'Historic botanical gardens beside the Brisbane River.',
                ],
            ],

            'Johannesburg' => [
                [
                    'title' => 'Apartheid Museum',
                    'description' => 'A museum documenting the history of apartheid in South Africa.',
                ],
                [
                    'title' => 'Constitution Hill',
                    'description' => 'A historic prison complex and constitutional museum.',
                ],
                [
                    'title' => 'Soweto',
                    'description' => 'A historically important township with several major landmarks.',
                ],
                [
                    'title' => 'Gold Reef City',
                    'description' => 'A theme park and historical attraction based around the city’s gold-mining history.',
                ],
            ],

            'Nairobi' => [
                [
                    'title' => 'Nairobi National Park',
                    'description' => 'A national park located just outside the city centre.',
                ],
                [
                    'title' => 'Giraffe Centre',
                    'description' => 'A conservation and educational centre for Rothschild giraffes.',
                ],
                [
                    'title' => 'Karen Blixen Museum',
                    'description' => 'A museum dedicated to author Karen Blixen.',
                ],
                [
                    'title' => 'Nairobi National Museum',
                    'description' => 'A museum covering Kenya’s history, culture and natural heritage.',
                ],
            ],

            'Marrakesh' => [
                [
                    'title' => 'Jemaa el-Fnaa',
                    'description' => 'The famous central square and marketplace of Marrakesh.',
                ],
                [
                    'title' => 'Bahia Palace',
                    'description' => 'A historic palace known for its architecture and gardens.',
                ],
                [
                    'title' => 'Koutoubia Mosque',
                    'description' => 'The largest mosque in Marrakesh and a major city landmark.',
                ],
                [
                    'title' => 'Majorelle Garden',
                    'description' => 'A famous botanical garden and cultural attraction.',
                ],
            ],

            'Rabat' => [
                [
                    'title' => 'Hassan Tower',
                    'description' => 'A historic minaret and major landmark of Rabat.',
                ],
                [
                    'title' => 'Kasbah of the Udayas',
                    'description' => 'A historic fortified district overlooking the Atlantic Ocean.',
                ],
                [
                    'title' => 'Mohammed V Mausoleum',
                    'description' => 'A monumental mausoleum near Hassan Tower.',
                ],
                [
                    'title' => 'Chellah',
                    'description' => 'Historic Roman and medieval archaeological ruins.',
                ],
            ],

            'Casablanca' => [
                [
                    'title' => 'Hassan II Mosque',
                    'description' => 'A monumental mosque located on the Atlantic coast.',
                ],
                [
                    'title' => 'Old Medina',
                    'description' => 'The historic old quarter of Casablanca.',
                ],
                [
                    'title' => 'Rick\'s Cafe',
                    'description' => 'A Casablanca-themed restaurant inspired by the classic film.',
                ],
                [
                    'title' => 'Corniche',
                    'description' => 'A popular coastal promenade with restaurants and beaches.',
                ],
            ],

            'Accra' => [
                [
                    'title' => 'Kwame Nkrumah Memorial Park',
                    'description' => 'A memorial dedicated to Ghana’s first president.',
                ],
                [
                    'title' => 'Labadi Beach',
                    'description' => 'A popular beach near Accra.',
                ],
                [
                    'title' => 'Independence Arch',
                    'description' => 'A major national monument in Accra.',
                ],
                [
                    'title' => 'Makola Market',
                    'description' => 'A large traditional market in central Accra.',
                ],
            ],

            'Lagos' => [
                [
                    'title' => 'Lekki Conservation Centre',
                    'description' => 'A nature reserve with a famous canopy walkway.',
                ],
                [
                    'title' => 'Nike Art Gallery',
                    'description' => 'A large gallery showcasing Nigerian art and culture.',
                ],
                [
                    'title' => 'National Museum Lagos',
                    'description' => 'A museum featuring Nigerian cultural and historical collections.',
                ],
                [
                    'title' => 'Tarkwa Bay',
                    'description' => 'A popular beach accessible by boat.',
                ],
            ],

            'Addis Ababa' => [
                [
                    'title' => 'National Museum of Ethiopia',
                    'description' => 'A museum famous for its archaeological collections.',
                ],
                [
                    'title' => 'Holy Trinity Cathedral',
                    'description' => 'A major Ethiopian Orthodox cathedral.',
                ],
                [
                    'title' => 'Entoto Hill',
                    'description' => 'A mountain overlooking Addis Ababa.',
                ],
                [
                    'title' => 'Merkato',
                    'description' => 'One of Africa’s largest open-air markets.',
                ],
            ],

            'Kigali' => [
                [
                    'title' => 'Kigali Genocide Memorial',
                    'description' => 'A memorial and educational centre documenting the 1994 genocide against the Tutsi.',
                ],
                [
                    'title' => 'Kimironko Market',
                    'description' => 'A lively market selling local products and crafts.',
                ],
                [
                    'title' => 'Inema Arts Center',
                    'description' => 'A contemporary art centre showcasing Rwandan artists.',
                ],
                [
                    'title' => 'Mount Kigali',
                    'description' => 'A scenic hill offering views over Kigali.',
                ],
            ],

            'Doha' => [
                [
                    'title' => 'Museum of Islamic Art',
                    'description' => 'A major museum containing Islamic art from across the world.',
                ],
                [
                    'title' => 'Souq Waqif',
                    'description' => 'A traditional market in central Doha.',
                ],
                [
                    'title' => 'The Pearl-Qatar',
                    'description' => 'A large artificial island with shops, restaurants and marinas.',
                ],
                [
                    'title' => 'National Museum of Qatar',
                    'description' => 'A museum presenting the history and culture of Qatar.',
                ],
            ],

            'Riyadh' => [
                [
                    'title' => 'Masmak Fortress',
                    'description' => 'A historic fortress associated with the formation of modern Saudi Arabia.',
                ],
                [
                    'title' => 'Kingdom Centre',
                    'description' => 'A famous skyscraper with an observation deck.',
                ],
                [
                    'title' => 'National Museum of Saudi Arabia',
                    'description' => 'A museum presenting Saudi history and culture.',
                ],
                [
                    'title' => 'Diriyah',
                    'description' => 'A historic district and UNESCO World Heritage Site near Riyadh.',
                ],
            ],

            'Jerusalem' => [
                [
                    'title' => 'Western Wall',
                    'description' => 'A major historic and religious site in the Old City.',
                ],
                [
                    'title' => 'Church of the Holy Sepulchre',
                    'description' => 'A major Christian pilgrimage site in the Old City.',
                ],
                [
                    'title' => 'Dome of the Rock',
                    'description' => 'A historic Islamic shrine on the Temple Mount/Haram al-Sharif.',
                ],
                [
                    'title' => 'Tower of David',
                    'description' => 'A historic citadel and museum near the Old City.',
                ],
            ],

            'Tel Aviv' => [
                [
                    'title' => 'Jaffa Old City',
                    'description' => 'A historic port district with ancient streets and architecture.',
                ],
                [
                    'title' => 'Carmel Market',
                    'description' => 'A lively market in central Tel Aviv.',
                ],
                [
                    'title' => 'Tel Aviv Museum of Art',
                    'description' => 'A major art museum in Tel Aviv.',
                ],
                [
                    'title' => 'Rothschild Boulevard',
                    'description' => 'A famous tree-lined boulevard with Bauhaus architecture.',
                ],
            ],

            'Amman' => [
                [
                    'title' => 'Amman Citadel',
                    'description' => 'A historic archaeological site on a hill above Amman.',
                ],
                [
                    'title' => 'Roman Theatre',
                    'description' => 'A large ancient Roman theatre in central Amman.',
                ],
                [
                    'title' => 'Rainbow Street',
                    'description' => 'A popular street with restaurants, cafes and shops.',
                ],
                [
                    'title' => 'Jordan Museum',
                    'description' => 'A museum presenting Jordan’s archaeological and cultural heritage.',
                ],
            ],

            'Beirut' => [
                [
                    'title' => 'Beirut Corniche',
                    'description' => 'A scenic seaside promenade along the Mediterranean.',
                ],
                [
                    'title' => 'National Museum of Beirut',
                    'description' => 'A major archaeological museum in Lebanon.',
                ],
                [
                    'title' => 'Mohammad Al-Amin Mosque',
                    'description' => 'A prominent mosque in central Beirut.',
                ],
                [
                    'title' => 'Pigeon Rocks',
                    'description' => 'Famous natural rock formations off the Beirut coast.',
                ],
            ],

            'Muscat' => [
                [
                    'title' => 'Sultan Qaboos Grand Mosque',
                    'description' => 'A major mosque and architectural landmark of Muscat.',
                ],
                [
                    'title' => 'Mutrah Souq',
                    'description' => 'A traditional covered market near Muscat Harbour.',
                ],
                [
                    'title' => 'Al Alam Palace',
                    'description' => 'The ceremonial palace of the Sultan of Oman.',
                ],
                [
                    'title' => 'Mutrah Corniche',
                    'description' => 'A scenic waterfront promenade.',
                ],
            ],

            'Kathmandu' => [
                [
                    'title' => 'Swayambhunath',
                    'description' => 'An ancient Buddhist and Hindu religious complex.',
                ],
                [
                    'title' => 'Boudhanath Stupa',
                    'description' => 'A major Buddhist pilgrimage site.',
                ],
                [
                    'title' => 'Pashupatinath Temple',
                    'description' => 'An important Hindu temple complex.',
                ],
                [
                    'title' => 'Kathmandu Durbar Square',
                    'description' => 'A historic palace square in the old city.',
                ],
            ],

            'Havana' => [
                [
                    'title' => 'Old Havana',
                    'description' => 'The historic centre of Havana.',
                ],
                [
                    'title' => 'El Capitolio',
                    'description' => 'A monumental historic building in central Havana.',
                ],
                [
                    'title' => 'Malecón',
                    'description' => 'The famous waterfront promenade of Havana.',
                ],
                [
                    'title' => 'Castillo de la Real Fuerza',
                    'description' => 'A historic fortress in Old Havana.',
                ],
            ],

            'Santo Domingo' => [
                [
                    'title' => 'Colonial Zone',
                    'description' => 'The historic district of Santo Domingo.',
                ],
                [
                    'title' => 'Alcazar de Colon',
                    'description' => 'A historic palace in the Colonial Zone.',
                ],
                [
                    'title' => 'Cathedral of Santa Maria la Menor',
                    'description' => 'The oldest cathedral in the Americas.',
                ],
                [
                    'title' => 'Malecon',
                    'description' => 'A popular waterfront avenue along the Caribbean Sea.',
                ],
            ],

            'Panama City' => [
                [
                    'title' => 'Panama Canal',
                    'description' => 'The famous artificial waterway connecting the Atlantic and Pacific Oceans.',
                ],
                [
                    'title' => 'Casco Viejo',
                    'description' => 'The historic old quarter of Panama City.',
                ],
                [
                    'title' => 'Amador Causeway',
                    'description' => 'A scenic causeway connecting several islands.',
                ],
                [
                    'title' => 'Biomuseo',
                    'description' => 'A museum dedicated to Panama’s biodiversity and natural history.',
                ],
            ],

            'San Jose' => [
                [
                    'title' => 'National Theatre of Costa Rica',
                    'description' => 'A historic theatre and architectural landmark.',
                ],
                [
                    'title' => 'National Museum of Costa Rica',
                    'description' => 'A museum covering Costa Rican history and culture.',
                ],
                [
                    'title' => 'Central Market',
                    'description' => 'A traditional market in central San Jose.',
                ],
                [
                    'title' => 'Metropolitan Cathedral',
                    'description' => 'A major cathedral in the centre of San Jose.',
                ],
            ],

            'Guatemala City' => [
                [
                    'title' => 'National Palace of Culture',
                    'description' => 'A historic government building and cultural landmark.',
                ],
                [
                    'title' => 'La Aurora Zoo',
                    'description' => 'A major zoo in Guatemala City.',
                ],
                [
                    'title' => 'Kaminaljuyu',
                    'description' => 'An important archaeological site of the Maya civilization.',
                ],
                [
                    'title' => 'Metropolitan Cathedral',
                    'description' => 'A historic cathedral on the central plaza.',
                ],
            ],

            'Helsinki' => [
                [
                    'title' => 'Helsinki Cathedral',
                    'description' => 'A landmark cathedral overlooking Senate Square.',
                ],
                [
                    'title' => 'Suomenlinna',
                    'description' => 'A historic sea fortress on islands near Helsinki.',
                ],
                [
                    'title' => 'Temppeliaukio Church',
                    'description' => 'A famous church carved into solid rock.',
                ],
                [
                    'title' => 'Market Square',
                    'description' => 'A popular market area beside the harbour.',
                ],
            ],

            'Riga' => [
                [
                    'title' => 'Riga Old Town',
                    'description' => 'The historic centre of Riga with medieval and Art Nouveau architecture.',
                ],
                [
                    'title' => 'Freedom Monument',
                    'description' => 'A major national monument in the centre of Riga.',
                ],
                [
                    'title' => 'House of the Black Heads',
                    'description' => 'A historic building in Riga Old Town.',
                ],
                [
                    'title' => 'Riga Central Market',
                    'description' => 'A historic market complex near the Daugava River.',
                ],
            ],

            'Daugavpils' => [
                [
                    'title' => 'Daugavpils Fortress',
                    'description' => 'A historic fortress complex.',
                ],
                [
                    'title' => 'Mark Rothko Art Centre',
                    'description' => 'An art centre dedicated to Mark Rothko.',
                ],
                [
                    'title' => 'Church Hill',
                    'description' => 'A historic area with several churches.',
                ],
                [
                    'title' => 'Daugavpils Unity House',
                    'description' => 'A cultural landmark in the city centre.',
                ],
            ],

            'Liepaja' => [
                [
                    'title' => 'Karosta',
                    'description' => 'A historic former military district.',
                ],
                [
                    'title' => 'Liepaja Beach',
                    'description' => 'A wide sandy Baltic Sea beach.',
                ],
                [
                    'title' => 'Seaside Park',
                    'description' => 'A large park beside the beach.',
                ],
                [
                    'title' => 'Liepaja Holy Trinity Cathedral',
                    'description' => 'A historic Lutheran cathedral.',
                ],
            ],
        ];
        foreach ($destinations as $placeName => $items) {

            $place = Place::where('name', $placeName)->first();

            if (!$place) {
                continue;
            }

            foreach ($items as $item) {
                Destination::create([
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'places_id' => $place->id,
                ]);
            }
        }
    }
}
