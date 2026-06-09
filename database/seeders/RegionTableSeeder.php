<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('counties')->truncate();
        DB::table('cities')->truncate();

        $cities = [
            'İstanbul' => ['Kadıköy', 'Beşiktaş', 'Üsküdar', 'Ataşehir', 'Bakırköy', 'Sarıyer', 'Şişli', 'Fatih', 'Esenyurt', 'Pendik'],
            'Ankara' => ['Çankaya', 'Keçiören', 'Yenimahalle', 'Mamak', 'Altındağ', 'Sincan', 'Pursaklar', 'Etimesgut', 'Polatlı', 'Çubuk'],
            'İzmir' => ['Konak', 'Karşıyaka', 'Bornova', 'Buca', 'Narlıdere', 'Gaziemir', 'Çiğli', 'Bayraklı', 'Karabağlar', 'Balçova'],
            'Bursa' => ['Osmangazi', 'Nilüfer', 'Yıldırım', 'Karacabey', 'Gemlik', 'Mudanya', 'Kestel', 'Gürsu', 'İnegöl', 'Mustafakemalpaşa'],
            'Antalya' => ['Muratpaşa', 'Kepez', 'Alanya', 'Konyaaltı', 'Manavgat', 'Aksu', 'Döşemealtı', 'Serik', 'Finike', 'Kemer'],
            'Adana' => ['Seyhan', 'Yüreğir', 'Çukurova', 'Sarıçam', 'Ceyhan', 'İmamoğlu', 'Karataş', 'Feke', 'Tufanbeyli', 'Aladağ'],
            'Konya' => ['Selçuklu', 'Meram', 'Karatay', 'Beyşehir', 'Ilgın', 'Akşehir', 'Cihanbeyli', 'Seydişehir', 'Taşkent', 'Kadınhanı'],
            'Gaziantep' => ['Şahinbey', 'Şehitkamil', 'Oğuzeli', 'Nurdağı', 'Nizip', 'Yavuzeli', 'Araban', 'Karkamış', 'İslahiye', 'Karkamış'],
            'Kayseri' => ['Melikgazi', 'Kocasinan', 'Talas', 'Develi', 'İncesu', 'Bünyan', 'Pınarbaşı', 'Sarıoğlan', 'Felahiye', 'Yeşilhisar'],
            'Samsun' => ['İlkadım', 'Atakum', 'Canik', 'Kadıköy', 'Bafra', 'Çarşamba', 'Vezirköprü', 'Havza', 'Ondokuzmayıs', 'Terme'],
            'Mersin' => ['Yenişehir', 'Akdeniz', 'Mezitli', 'Toroslar', 'Erdemli', 'Tarsus', 'Silifke', 'Mut', 'Anamur', 'Gülnar'],
            'Diyarbakır' => ['Bağlar', 'Kayapınar', 'Sur', 'Yenişehir', 'Suriçi', 'Bismil', 'Çüngüş', 'Kulp', 'Silvan', 'Hazro'],
            'Eskişehir' => ['Odunpazarı', 'Tepebaşı', 'Seyitgazi', 'Çifteler', 'Mihalıççık', 'Alpu', 'Sarıcakaya', 'Günyüzü', 'Mahmudiye', 'Mihalgazi'],
            'Tekirdağ' => ['Çorlu', 'Süleymanpaşa', 'Malkara', 'Muratlı', 'Çerkezköy', 'Kapaklı', 'Ergene', 'Şarköy', 'Hayrabolu', 'Marmaraereğlisi'],
            'Muğla' => ['Bodrum', 'Marmaris', 'Fethiye', 'Datça', 'Ortaca', 'Ula', 'Yatağan', 'Köyceğiz', 'Milas', 'Dalaman'],
            'Çanakkale' => ['Eceabat', 'Gelibolu', 'Lapseki', 'Bayramiç', 'Biga', 'Ezine', 'Çan', 'Gökçeada', 'Ayvacık', 'Bozcaada'],
            'Kocaeli' => ['İzmit', 'Gebze', 'Darıca', 'Çayırova', 'Dilovası', 'Körfez', 'Gölcük', 'Kartepe', 'Başiskele', 'Kandıra'],
            'Sakarya' => ['Adapazarı', 'Serdivan', 'Erenler', 'Arifiye', 'Karasu', 'Hendek', 'Sapanca', 'Akyazı', 'Pamukova', 'Geyve'],
            'Trabzon' => ['Ortahisar', 'Akçaabat', 'Araklı', 'Maçka', 'Of', 'Vakfıkebir', 'Tonya', 'Çarşıbaşı', 'Sürmene', 'Beşikdüzü'],
            'Aydın' => ['Efeler', 'Nazilli', 'Kuşadası', 'Söke', 'Didim', 'Buharkent', 'Çine', 'Koçarlı', 'Karpuzlu', 'İncirliova'],
        ];

        $cityIds = [];

        foreach ($cities as $name => $districts) {
            $cityIds[$name] = DB::table('cities')->insertGetId([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $counties = [];

        foreach ($cities as $name => $districts) {
            foreach ($districts as $district) {
                $counties[] = [
                    'city_id' => $cityIds[$name],
                    'name' => $district,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('counties')->insert($counties);
    }
}
