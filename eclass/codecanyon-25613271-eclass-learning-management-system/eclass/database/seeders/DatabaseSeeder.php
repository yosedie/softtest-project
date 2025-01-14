<?php
namespace Database\Seeders;

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
        $this->call(AllcitiesTableSeeder::class);
        $this->call(AllcountryTableSeeder::class);
        $this->call(AllstatesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(AboutsTableSeeder::class);
        $this->call(CareersTableSeeder::class);
        $this->call(ColorOptionsTableSeeder::class);
        $this->call(InvoiceDesignSeeder::class);
        $this->call(PlayerSettingsTableSeeder::class);
        $this->call(AffiliateTableSeeder::class);
        $this->call(WidgetSettingsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(AdmincustomisationsTableSeeder::class);
        $this->call(ServicesettingsTableSeeder::class);
        $this->call(MobileSettingsTableSeeder::class);
        $this->call(DownloadqrsTableSeeder::class);
        $this->call(FeaturesettingsTableSeeder::class);
        $this->call(UpisTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(CustomizedRoleHasPermissionsTableSeeder::class);
    }
}