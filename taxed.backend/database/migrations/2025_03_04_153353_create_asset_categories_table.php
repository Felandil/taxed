<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// https://www.bundesfinanzministerium.de/Content/DE/Standardartikel/Themen/Steuern/Weitere_Steuerthemen/Betriebspruefung/AfA-Tabellen/AfA-Tabelle_Forstwirtschaft.html

class CreateAssetCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asset_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->unsignedInteger('useful_life')->nullable();
            $table->decimal('depreciation_rate', 5, 2)->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('asset_categories')->onDelete('cascade');
            $table->timestamps();
        });

        $now = now();

        /*
         * Gruppe 1: Baulichkeiten
         */
        $group1 = DB::table('asset_categories')->insertGetId([
            'code'             => '1',
            'name'             => 'Baulichkeiten',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        $group1_1 = DB::table('asset_categories')->insertGetId([
            'code'             => '1.1',
            'name'             => 'Schutzhütten und Zelte',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        $group1_2 = DB::table('asset_categories')->insertGetId([
            'code'             => '1.2',
            'name'             => 'Sonstige Gebäude (wie nicht branchengebunden)',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        /*
         * Gruppe 2: Wege- und Brückenbauten
         */
        $group2 = DB::table('asset_categories')->insertGetId([
            'code'             => '2',
            'name'             => 'Wege- und Brückenbauten',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.1 Wege und Straßen
        $group2_1 = DB::table('asset_categories')->insertGetId([
            'code'             => '2.1',
            'name'             => 'Wege und Straßen',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.1.1 Fahrwege
        $group2_1_1 = DB::table('asset_categories')->insertGetId([
            'code'             => '2.1.1',
            'name'             => 'Fahrwege',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group2_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.1.1.1: mit wassergebundener Decke
        DB::table('asset_categories')->insert([
            'code'             => '2.1.1.1',
            'name'             => 'mit wassergebundener Decke',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group2_1_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.1.1.2: mit Bitumen-, Asphalt- oder Betondecke
        DB::table('asset_categories')->insert([
            'code'             => '2.1.1.2',
            'name'             => 'mit Bitumen-, Asphalt- oder Betondecke',
            'useful_life'      => 15,
            'depreciation_rate'=> 7.00,
            'parent_id'        => $group2_1_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.1.2 Maschinenwege
        DB::table('asset_categories')->insert([
            'code'             => '2.1.2',
            'name'             => 'Maschinenwege',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group2_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.2 Brücken
        $group2_2 = DB::table('asset_categories')->insertGetId([
            'code'             => '2.2',
            'name'             => 'Brücken',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.2.1: aus Beton oder Mauerwerk
        DB::table('asset_categories')->insert([
            'code'             => '2.2.1',
            'name'             => 'aus Beton oder Mauerwerk',
            'useful_life'      => 40,
            'depreciation_rate'=> 2.50,
            'parent_id'        => $group2_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.2.2: aus Eisen oder Stahl
        DB::table('asset_categories')->insert([
            'code'             => '2.2.2',
            'name'             => 'aus Eisen oder Stahl',
            'useful_life'      => 25,
            'depreciation_rate'=> 4.00,
            'parent_id'        => $group2_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 2.2.3: aus Holz
        DB::table('asset_categories')->insert([
            'code'             => '2.2.3',
            'name'             => 'aus Holz',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group2_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        /*
         * Gruppe 3: Be- und Entwässerungsanlagen
         */
        $group3 = DB::table('asset_categories')->insertGetId([
            'code'             => '3',
            'name'             => 'Be- und Entwässerungsanlagen',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.1 Gräben
        $group3_1 = DB::table('asset_categories')->insertGetId([
            'code'             => '3.1',
            'name'             => 'Gräben',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.1.1: befestigte Gräben
        DB::table('asset_categories')->insert([
            'code'             => '3.1.1',
            'name'             => 'befestigte Gräben',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group3_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.1.2: Massivbau Gräben
        DB::table('asset_categories')->insert([
            'code'             => '3.1.2',
            'name'             => 'Massivbau Gräben',
            'useful_life'      => 20,
            'depreciation_rate'=> 5.00,
            'parent_id'        => $group3_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.2 Stauanlagen und Sammler
        $group3_2 = DB::table('asset_categories')->insertGetId([
            'code'             => '3.2',
            'name'             => 'Stauanlagen und Sammler',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.2.1: aus Beton oder Mauerwerk
        DB::table('asset_categories')->insert([
            'code'             => '3.2.1',
            'name'             => 'aus Beton oder Mauerwerk',
            'useful_life'      => 33,
            'depreciation_rate'=> 3.00,
            'parent_id'        => $group3_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.2.2: aus Eisen oder Stahl
        DB::table('asset_categories')->insert([
            'code'             => '3.2.2',
            'name'             => 'aus Eisen oder Stahl',
            'useful_life'      => 25,
            'depreciation_rate'=> 4.00,
            'parent_id'        => $group3_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.2.3: aus Holz
        DB::table('asset_categories')->insert([
            'code'             => '3.2.3',
            'name'             => 'aus Holz',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group3_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.3 Drainagen und Leitungen
        $group3_3 = DB::table('asset_categories')->insertGetId([
            'code'             => '3.3',
            'name'             => 'Drainagen und Leitungen',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.3.1: aus Beton oder Mauerwerk
        DB::table('asset_categories')->insert([
            'code'             => '3.3.1',
            'name'             => 'aus Beton oder Mauerwerk',
            'useful_life'      => 33,
            'depreciation_rate'=> 3.00,
            'parent_id'        => $group3_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.3.2: aus Ton
        DB::table('asset_categories')->insert([
            'code'             => '3.3.2',
            'name'             => 'aus Ton',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group3_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.3.3: aus Holz
        DB::table('asset_categories')->insert([
            'code'             => '3.3.3',
            'name'             => 'aus Holz',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group3_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.3.4: aus Kunststoff
        DB::table('asset_categories')->insert([
            'code'             => '3.3.4',
            'name'             => 'aus Kunststoff',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group3_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.4 Beregnungsanlagen
        $group3_4 = DB::table('asset_categories')->insertGetId([
            'code'             => '3.4',
            'name'             => 'Beregnungsanlagen',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.4.1: Berieselungsanlagen für Rundholzplatz
        DB::table('asset_categories')->insert([
            'code'             => '3.4.1',
            'name'             => 'Berieselungsanlagen für Rundholzplatz',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group3_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 3.4.2: sonstige Beregnungsanlagen
        DB::table('asset_categories')->insert([
            'code'             => '3.4.2',
            'name'             => 'sonstige Beregnungsanlagen',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group3_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        /*
         * Gruppe 4: Maschinen und Geräte
         */
        $group4 = DB::table('asset_categories')->insertGetId([
            'code'             => '4',
            'name'             => 'Maschinen und Geräte',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1: Rodung, Bodenbearbeitung, Düngung, Bestandesbegründung
        $group4_1 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.1',
            'name'             => 'Rodung, Bodenbearbeitung, Düngung, Bestandesbegründung',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.1: Rodungsgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.1.1',
            'name'             => 'Rodungsgeräte',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.2: Bodenbearbeitungsgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.1.2',
            'name'             => 'Bodenbearbeitungsgeräte',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.3: Düngungsgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.1.3',
            'name'             => 'Düngungsgeräte',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.4: Schlagräumgeräte, Mulchgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.1.4',
            'name'             => 'Schlagräumgeräte, Mulchgeräte',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.5: Pflanzmaschinen
        DB::table('asset_categories')->insert([
            'code'             => '4.1.5',
            'name'             => 'Pflanzmaschinen',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.1.6: Pflanzschulgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.1.6',
            'name'             => 'Pflanzschulgeräte',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group4_1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.2: Forst- und Holzschutz
        $group4_2 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.2',
            'name'             => 'Forst- und Holzschutz',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.2.1: Geräte zur Brand- und Schädlingsbekämpfung
        DB::table('asset_categories')->insert([
            'code'             => '4.2.1',
            'name'             => 'Geräte zur Brand- und Schädlingsbekämpfung',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.2.2: Kulturzäune
        DB::table('asset_categories')->insert([
            'code'             => '4.2.2',
            'name'             => 'Kulturzäune',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group4_2,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.3: Holzernte und Bestandespflege
        $group4_3 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.3',
            'name'             => 'Holzernte und Bestandespflege',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.1: Motorsägen
        DB::table('asset_categories')->insert([
            'code'             => '4.3.1',
            'name'             => 'Motorsägen',
            'useful_life'      => 3,
            'depreciation_rate'=> 33.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.2: Holzernte- und Entrindungsmaschinen
        DB::table('asset_categories')->insert([
            'code'             => '4.3.2',
            'name'             => 'Holzernte- und Entrindungsmaschinen',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.3: Rückeschlepper, Zug- und Trägerfahrzeuge
        DB::table('asset_categories')->insert([
            'code'             => '4.3.3',
            'name'             => 'Rückeschlepper, Zug- und Trägerfahrzeuge',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.4: Motorwinden, Anbauwinden, Seilanlagen
        DB::table('asset_categories')->insert([
            'code'             => '4.3.4',
            'name'             => 'Motorwinden, Anbauwinden, Seilanlagen',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.5: Rückewagen, Rückeanhänger
        DB::table('asset_categories')->insert([
            'code'             => '4.3.5',
            'name'             => 'Rückewagen, Rückeanhänger',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.6: Freischneidegeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.3.6',
            'name'             => 'Freischneidegeräte',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.3.7: Motorgetriebene Ästungsgeräte
        DB::table('asset_categories')->insert([
            'code'             => '4.3.7',
            'name'             => 'Motorgetriebene Ästungsgeräte',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_3,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.4: Wegebau, Wegeunterhaltung, Transport
        $group4_4 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.4',
            'name'             => 'Wegebau, Wegeunterhaltung, Transport',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.1: Planierraupen
        DB::table('asset_categories')->insert([
            'code'             => '4.4.1',
            'name'             => 'Planierraupen',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.2: Bagger
        DB::table('asset_categories')->insert([
            'code'             => '4.4.2',
            'name'             => 'Bagger',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.3: Wegehobel, Walzen
        DB::table('asset_categories')->insert([
            'code'             => '4.4.3',
            'name'             => 'Wegehobel, Walzen',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.4: Transportanhänger
        DB::table('asset_categories')->insert([
            'code'             => '4.4.4',
            'name'             => 'Transportanhänger',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.5: Kipper
        DB::table('asset_categories')->insert([
            'code'             => '4.4.5',
            'name'             => 'Kipper',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.6: Bankettfräsmaschinen
        DB::table('asset_categories')->insert([
            'code'             => '4.4.6',
            'name'             => 'Bankettfräsmaschinen',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.4.7: Grabenfräsmaschinen
        DB::table('asset_categories')->insert([
            'code'             => '4.4.7',
            'name'             => 'Grabenfräsmaschinen',
            'useful_life'      => 6,
            'depreciation_rate'=> 17.00,
            'parent_id'        => $group4_4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.5: Jagdwirtschaft
        $group4_5 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.5',
            'name'             => 'Jagdwirtschaft',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.1: Waffen und optische Geräte
        DB::table('asset_categories')->insert([
            'code'             => '4.5.1',
            'name'             => 'Waffen und optische Geräte',
            'useful_life'      => 20,
            'depreciation_rate'=> 5.00,
            'parent_id'        => $group4_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.2: Fütterungsanlagen
        DB::table('asset_categories')->insert([
            'code'             => '4.5.2',
            'name'             => 'Fütterungsanlagen',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.3: Wildgatter
        DB::table('asset_categories')->insert([
            'code'             => '4.5.3',
            'name'             => 'Wildgatter',
            'useful_life'      => 15,
            'depreciation_rate'=> 7.00,
            'parent_id'        => $group4_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.4: Wildgatter beweglich
        DB::table('asset_categories')->insert([
            'code'             => '4.5.4',
            'name'             => 'Wildgatter beweglich',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.5: Kanzeln (geschlossene Hochsitze)
        $group4_5_5 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.5.5',
            'name'             => 'Kanzeln (geschlossene Hochsitze)',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.5.1: aus Holz
        DB::table('asset_categories')->insert([
            'code'             => '4.5.5.1',
            'name'             => 'aus Holz',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_5_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.5.5.2: aus Stahl
        DB::table('asset_categories')->insert([
            'code'             => '4.5.5.2',
            'name'             => 'aus Stahl',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_5_5,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.6: Arbeits- und Katastrophenschutz
        $group4_6 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.6',
            'name'             => 'Arbeits- und Katastrophenschutz',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.6.1: Waldarbeiterschutzwagen
        DB::table('asset_categories')->insert([
            'code'             => '4.6.1',
            'name'             => 'Waldarbeiterschutzwagen',
            'useful_life'      => 10,
            'depreciation_rate'=> 10.00,
            'parent_id'        => $group4_6,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.6.2: Betriebsfunkanlagen
        DB::table('asset_categories')->insert([
            'code'             => '4.6.2',
            'name'             => 'Betriebsfunkanlagen',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group4_6,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // 4.7: Rohholzaufbereitung
        $group4_7 = DB::table('asset_categories')->insertGetId([
            'code'             => '4.7',
            'name'             => 'Rohholzaufbereitung',
            'useful_life'      => null,
            'depreciation_rate'=> null,
            'parent_id'        => $group4,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.7.1: Spezial-Lkw zur Anlieferung von Holz in langer und kurzer Form
        DB::table('asset_categories')->insert([
            'code'             => '4.7.1',
            'name'             => 'Spezial-Lkw zur Anlieferung von Holz in langer und kurzer Form',
            'useful_life'      => 5,
            'depreciation_rate'=> 20.00,
            'parent_id'        => $group4_7,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
        // 4.7.2: Rohholzaufbereitungsanlagen (insbes. Entastungsanlagen, Restholzhacker, Kappsägen, Vermessungsanlagen, stationäre Förder- und Sortierungsgeräte)
        DB::table('asset_categories')->insert([
            'code'             => '4.7.2',
            'name'             => 'Rohholzaufbereitungsanlagen (insbes. Entastungsanlagen, Restholzhacker, Kappsägen, Vermessungsanlagen, stationäre Förder- und Sortierungsgeräte)',
            'useful_life'      => 8,
            'depreciation_rate'=> 12.00,
            'parent_id'        => $group4_7,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('asset_categories');
    }
}
