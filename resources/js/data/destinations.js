const base = '/image/'

export const destinations = [
    { id: 1, name: 'SELLA PASS | ITALY', title: 'Sella Pass', city: 'Canazei', country: 'Italy', category: 'Daba', status: 'not_visited', image: base + 'sella-pass.jpg',
        description: 'Sella Pass is a spectacular mountain pass in the heart of the Italian Dolomites. The road winds through green alpine meadows, pine forests and dramatic rocky peaks. Small wooden huts and mountain villages add to the traditional atmosphere of the area. It is a popular destination for hiking, cycling and scenic drives. The views of the Sella massif make this one of the most beautiful places in northern Italy.' },

    { id: 2, name: 'ISLANDS | NORWAY', title: 'Norwegian Islands', city: 'Northern Norway', country: 'Norway', category: 'Daba', status: 'not_visited', image: base + 'norway-islands.jpg',
        description: 'The islands of Northern Norway are surrounded by cold, clear Arctic waters. Steep mountains rise dramatically from the sea and create breathtaking landscapes. Traditional red fishing cabins can be found along quiet coastal villages. The area is perfect for hiking, kayaking and exploring remote nature. During the right season, visitors can also experience the midnight sun or northern lights.' },

    { id: 3, name: 'FJORDS | ICELAND', title: 'Icelandic Fjords', city: 'Westfjords', country: 'Iceland', category: 'Daba', status: 'visited', image: base + 'fjords-islands.jpg',
        description: 'The Icelandic fjords offer some of the most remote landscapes in the country. Dark cliffs and mountains surround deep blue and turquoise waters. Small green islands and quiet beaches create a peaceful atmosphere far from busy tourist areas. The region is ideal for road trips, hiking and wildlife watching. Its untouched scenery makes the Westfjords feel like another world.' },

    { id: 4, name: 'ISLAND | PORTUGAL', title: 'Madeira', city: 'Funchal', country: 'Portugal', category: 'Atpūta', status: 'visited', image: base + 'island portugal.jpg',
        description: 'Madeira is a volcanic island located in the Atlantic Ocean off the coast of Portugal. It is famous for dramatic cliffs, green mountains and deep blue waters. The island has a mild climate that makes it enjoyable throughout much of the year. Visitors can explore coastal paths, mountain trails and charming villages. Madeira is a great destination for relaxing holidays as well as outdoor adventures.' },

    { id: 5, name: 'PLITVICE LAKES | CROATIA', title: 'Plitvice Lakes', city: 'Plitvička Jezera', country: 'Croatia', category: 'Daba', status: 'not_visited', image: base + 'PLITVICE LAKES  CROATIA.jpg',
        description: 'Plitvice Lakes is one of the most famous natural attractions in Croatia. The national park is home to a series of turquoise lakes connected by beautiful waterfalls. Wooden paths allow visitors to walk through forests and enjoy the scenery from different viewpoints. The colors of the water change depending on the minerals, sunlight and season. It is an ideal destination for nature lovers and photographers.' },

    { id: 6, name: 'DOLOMITES | ITALY', title: 'Dolomites', city: 'Cortina d\'Ampezzo', country: 'Italy', category: 'Daba', status: 'visited', image: base + 'DOLOMITES  ITALY.webp',
        description: 'The Dolomites are a spectacular mountain range in northern Italy. Their pale limestone peaks create one of the most recognizable landscapes in Europe. The region offers hundreds of hiking trails, mountain roads and scenic viewpoints. In winter, it becomes a popular destination for skiing and snowboarding. Alpine villages and traditional food make the experience even more memorable.' },

    { id: 7, name: 'SANTORINI | GREECE', title: 'Santorini', city: 'Oia', country: 'Greece', category: 'Atpūta', status: 'not_visited', image: base + 'Santorini.webp',
        description: 'Santorini is a beautiful Greek island formed by a massive volcanic eruption thousands of years ago. Its white houses and blue domes are built along steep cliffs overlooking the Aegean Sea. Oia is especially famous for its spectacular sunsets and romantic atmosphere. Visitors can explore small villages, volcanic beaches and local restaurants. The island is a popular choice for relaxing holidays, honeymoons and unforgettable photographs.' },

    { id: 8, name: 'MALDIVES', title: 'Maldives', city: 'Malé', country: 'Maldives', category: 'Atpūta', status: 'not_visited', image: base + 'MALDIVES.avif',
        description: 'The Maldives is a tropical archipelago made up of hundreds of islands in the Indian Ocean. It is famous for crystal-clear lagoons, white sandy beaches and colorful coral reefs. Many resorts offer private villas built directly over the water. Visitors can enjoy snorkeling, diving, boat trips and peaceful days by the sea. The Maldives is one of the most popular destinations for a luxurious tropical escape.' },

    { id: 9, name: 'TENERIFE | SPAIN', title: 'Tenerife', city: 'Santa Cruz de Tenerife', country: 'Spain', category: 'Atpūta', status: 'visited', image: base + 'TENERIFE SPAIN.jpg',
        description: 'Tenerife is the largest of Spain\'s Canary Islands. The island combines sunny beaches, volcanic landscapes and lively coastal towns. Mount Teide rises in the center of the island and is the highest peak in Spain. Visitors can explore national parks, relax on black-sand beaches and enjoy water activities. Tenerife is a versatile destination that offers both adventure and relaxation.' },

    { id: 10, name: 'LOFOTEN | NORWAY', title: 'Lofoten', city: 'Svolvær', country: 'Norway', category: 'Daba', status: 'not_visited', image: base + 'LOFOTEN  NORWAY.webp',
        description: 'Lofoten is an Arctic archipelago known for dramatic mountains and beautiful coastal scenery. Sharp peaks rise above small fishing villages and quiet beaches. Traditional red cabins create a strong contrast with the surrounding blue sea and green landscapes. In summer, visitors can experience the midnight sun and enjoy long days outdoors. In winter, the region becomes a spectacular place to see the northern lights.' },

    { id: 11, name: 'DISNEYLAND | FRANCE', title: 'Disneyland Paris', city: 'Marne-la-Vallée', country: 'France', category: 'Izklaide', status: 'visited', image: base + 'DISNEYLAND FRANCE.webp',
        description: 'Disneyland Paris is a magical theme park located just outside the French capital. The resort features fairy-tale castles, exciting rides and attractions inspired by famous Disney stories. Visitors can watch colorful parades and meet popular characters throughout the day. There are also themed restaurants, shops and hotels for a complete holiday experience. It is a fun destination for children, families and Disney fans of all ages.' },

    { id: 12, name: 'EUROPA-PARK | GERMANY', title: 'Europa-Park', city: 'Rust', country: 'Germany', category: 'Izklaide', status: 'not_visited', image: base + 'EUROPA-PARK GERMANY.jpg',
        description: 'Europa-Park is Germany\'s largest theme park and one of Europe\'s most popular amusement parks. The park is divided into areas inspired by different European countries. Visitors can enjoy large roller coasters, family attractions and live shows. Each themed area has its own architecture, food and atmosphere. It is a great destination for anyone looking for a full day of entertainment and adventure.' },

    { id: 13, name: 'GARDALAND | ITALY', title: 'Gardaland', city: 'Castelnuovo del Garda', country: 'Italy', category: 'Izklaide', status: 'not_visited', image: base + 'gardaland.jpg',
        description: 'Gardaland is one of Italy\'s most famous amusement parks. It is located near the beautiful shores of Lake Garda in northern Italy. The park offers thrilling roller coasters, family rides, shows and themed attractions. Visitors can also explore the nearby aquarium and enjoy views of the surrounding lake region. Gardaland is a popular choice for families, friends and anyone who loves exciting attractions.' },

    { id: 14, name: 'IBIZA | SPAIN', title: 'Ibiza', city: 'Ibiza Town', country: 'Spain', category: 'Izklaide', status: 'visited', image: base + 'ibiza.jpg',
        description: 'Ibiza is a Mediterranean island famous for its beaches, nightlife and beautiful sunsets. The island has many hidden coves with clear blue water and peaceful surroundings. Ibiza Town offers historic streets, restaurants, shops and lively evening entertainment. The island is also known for its world-famous clubs and electronic music scene. Despite its party reputation, Ibiza also has quiet villages and relaxing places to enjoy nature.' },

    { id: 15, name: 'LAS VEGAS | USA', title: 'Las Vegas', city: 'Las Vegas', country: 'USA', category: 'Izklaide', status: 'not_visited', image: base + 'las vegas.webp',
        description: 'Las Vegas is a famous desert city known for its bright lights and endless entertainment. The Las Vegas Strip is filled with huge hotels, casinos, restaurants and live shows. Visitors can enjoy concerts, performances, themed attractions and luxury shopping. Outside the city, the surrounding desert offers opportunities for hiking and scenic trips. Las Vegas is a place where the city stays energetic from morning until late at night.' },

    { id: 16, name: 'CAPPADOCIA | TURKEY', title: 'Cappadocia', city: 'Göreme', country: 'Turkey', category: 'Daba', status: 'not_visited', image: base + 'CAPPADOCIA-TURKEY.jpg',
        description: 'Cappadocia is a unique region in central Turkey famous for its unusual rock formations. Soft volcanic rock has been shaped into tall fairy chimneys, caves and dramatic valleys. Visitors can explore underground cities, cave churches and traditional villages. Hot air balloon flights at sunrise offer incredible views over the entire landscape. The combination of history, nature and adventure makes Cappadocia a truly special destination.' },

    { id: 17, name: 'BALI | INDONESIA', title: 'Bali', city: 'Ubud', country: 'Indonesia', category: 'Atpūta', status: 'not_visited', image: base + 'bali.webp',
        description: 'Bali is a tropical Indonesian island known for its beautiful landscapes and rich culture. Visitors can explore green rice terraces, ancient temples and lush jungle areas. The island also offers sandy beaches and excellent conditions for surfing and swimming. Ubud is famous for its peaceful atmosphere, art galleries and traditional Balinese culture. Bali is a popular destination for travelers looking for both adventure and relaxation.' },

    { id: 18, name: 'MATTERHORN | SWITZERLAND', title: 'Matterhorn', city: 'Zermatt', country: 'Switzerland', category: 'Daba', status: 'not_visited', image: base + 'MATTERHORN.webp',
        description: 'The Matterhorn is one of the most recognizable mountains in the Swiss Alps. Its distinctive pyramid shape rises dramatically above the village of Zermatt. The surrounding area offers hiking trails, mountain viewpoints and beautiful alpine scenery. During winter, Zermatt becomes a popular destination for skiing and snowboarding. The Matterhorn is an unforgettable destination for anyone who loves mountains and nature.' },

    { id: 19, name: 'AMALFI COAST | ITALY', title: 'Amalfi Coast', city: 'Amalfi', country: 'Italy', category: 'Atpūta', status: 'visited', image: base + 'AMALFI COAST.jpg',
        description: 'The Amalfi Coast is one of the most beautiful coastal regions in southern Italy. Colorful villages are built into steep cliffs overlooking the deep blue Tyrrhenian Sea. The area is famous for lemon groves, scenic roads and traditional Italian restaurants. Visitors can explore charming towns such as Amalfi, Positano and Ravello. The combination of dramatic scenery, delicious food and Mediterranean culture makes it a perfect holiday destination.' },

    { id: 20, name: 'UNIVERSAL STUDIOS | USA', title: 'Universal Studios', city: 'Orlando', country: 'USA', category: 'Izklaide', status: 'not_visited', image: base + 'UNIVERSAL STUDIOS.avif',
        description: 'Universal Studios in Orlando is a large entertainment resort inspired by movies and television. The parks feature immersive worlds, thrilling roller coasters and interactive attractions. Visitors can explore famous film locations and experience rides based on popular characters and stories. The resort also offers live shows, restaurants, shops and themed hotels. It is an exciting destination for movie fans, families and adventure seekers.' },

    { id: 21, name: 'TIVOLI GARDENS | DENMARK', title: 'Tivoli Gardens', city: 'Copenhagen', country: 'Denmark', category: 'Izklaide', status: 'visited', image: base + 'TIVOLI GARDENS.jpg',
        description: 'Tivoli Gardens is one of the oldest amusement parks in the world. It is located in the center of Copenhagen and combines classic rides with beautiful gardens. Visitors can enjoy roller coasters, concerts, restaurants and seasonal events. At night, thousands of lights create a warm and magical atmosphere throughout the park. Tivoli is a unique place where traditional charm and modern entertainment come together.' },

    { id: 22, name: 'PORTAVENTURA | SPAIN', title: 'PortAventura', city: 'Salou', country: 'Spain', category: 'Izklaide', status: 'not_visited', image: base + 'PORTAVENTURA.avif',
        description: 'PortAventura is a large theme park located near the Mediterranean coast of Spain. The park is divided into different themed areas inspired by cultures and regions around the world. Visitors can enjoy large roller coasters, family attractions and spectacular shows. The resort also includes a water park where guests can cool down during hot summer days. Its location near the beach makes it easy to combine amusement park fun with a relaxing seaside holiday.' },

    { id: 23, name: 'TOKYO | JAPAN', title: 'Tokyo', city: 'Tokyo', country: 'Japan', category: 'Izklaide', status: 'not_visited', image: base + 'tokyo.jpg',
        description: 'Tokyo is a huge Japanese city where traditional culture and modern technology exist side by side. The city is famous for bright neon streets, arcades, shopping districts and countless restaurants. Visitors can also discover peaceful temples, historic neighborhoods and beautiful gardens. Tokyo offers entertainment for almost every interest, from anime and gaming to fashion and traditional cuisine. Its combination of energy, culture and futuristic architecture makes it one of the most exciting cities in the world.' },

    { id: 24, name: 'SEYCHELLES', title: 'Seychelles', city: 'Mahé', country: 'Seychelles', category: 'Atpūta', status: 'not_visited', image: base + 'SEYCHELLES.webp',
        description: 'The Seychelles is an island nation in the Indian Ocean famous for its tropical beauty. The islands have white sandy beaches, clear turquoise water and enormous granite boulders. Visitors can swim, snorkel, dive and explore lush tropical forests. Mahé and the surrounding islands offer a peaceful atmosphere away from large cities and busy resorts. Seychelles is an ideal destination for travelers looking for nature, relaxation and beautiful beaches.' },

    { id: 25, name: 'ZAKYNTHOS | GREECE', title: 'Zakynthos', city: 'Zakynthos', country: 'Greece', category: 'Atpūta', status: 'visited', image: base + 'ZAKYNTHOS GREECE.jpg',
        description: 'Zakynthos is a beautiful Greek island located in the Ionian Sea. It is famous for its crystal-clear waters, dramatic cliffs and hidden sea caves. Navagio Beach is one of the island\'s most recognizable sights and is surrounded by impressive rocky cliffs. Visitors can enjoy boat trips, swimming, snorkeling and exploring traditional villages. The relaxed atmosphere and stunning coastline make Zakynthos a great summer destination.' },

    { id: 26, name: 'BANFF | CANADA', title: 'Banff', city: 'Banff', country: 'Canada', category: 'Daba', status: 'not_visited', image: base + 'banff.webp',
        description: 'Banff is a mountain town located in the heart of the Canadian Rockies. The surrounding national park is famous for turquoise lakes, glaciers and snow-covered peaks. Visitors can hike through forests, explore mountain trails and watch local wildlife. Lake Louise and Moraine Lake are among the most famous natural attractions in the region. Banff is an excellent destination for hiking, skiing and experiencing the beauty of the Canadian wilderness.' },

    { id: 27, name: 'TORRES DEL PAINE | CHILE', title: 'Torres del Paine', city: 'Puerto Natales', country: 'Chile', category: 'Daba', status: 'not_visited', image: base + 'TORRES DEL PAINE CHILE.webp',
        description: 'Torres del Paine is a spectacular national park in the Patagonia region of Chile. The park is famous for enormous granite towers, glaciers, lakes and wide open landscapes. Strong winds and changing weather give the region a wild and dramatic character. Visitors can explore the famous W Trek and other hiking routes through the park. It is one of the world\'s most impressive destinations for trekking and adventure.' },

    { id: 28, name: 'DUBAI | UAE', title: 'Dubai', city: 'Dubai', country: 'UAE', category: 'Izklaide', status: 'visited', image: base + 'dubai.jpg',
        description: 'Dubai is a modern desert city known for its impressive architecture and luxurious lifestyle. The city is home to famous skyscrapers, huge shopping malls and world-class entertainment. Visitors can enjoy beaches, indoor attractions, desert safaris and spectacular restaurants. The Burj Khalifa offers incredible views over the city and surrounding desert. Dubai combines modern urban life with traditional Middle Eastern culture and exciting experiences.' }
]

export function findDestination(id) {
    return destinations.find((place) => place.id === Number(id))
}