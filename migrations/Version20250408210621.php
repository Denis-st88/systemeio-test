<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250408210621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table "tax_rules". Insert data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE tax_rules (
                id SERIAL PRIMARY KEY,
                country_code CHAR(2) UNIQUE NOT NULL,
                country_name VARCHAR(100) NOT NULL,
                tax_rate NUMERIC(5,2) NOT NULL,
                tax_number_pattern VARCHAR(255) NOT NULL
            )
        ');

        $rules = [
            ['code' => 'DE', 'name' => 'Германия', 'rate' => 19, 'pattern' => '^DE\d{9}$'],
            ['code' => 'IT', 'name' => 'Италия', 'rate' => 22, 'pattern' => '^IT\d{11}$'],
            ['code' => 'GR', 'name' => 'Греция', 'rate' => 24, 'pattern' => '^GR\d{9}$'],
            ['code' => 'FR', 'name' => 'Франция', 'rate' => 20, 'pattern' => '^FR[A-Z]{2}\d{9}$'],
        ];

        foreach ($rules as $rule) {
            $this->addSql(
                'INSERT INTO tax_rules (country_code, country_name, tax_rate, tax_number_pattern)
                VALUES
                (:code, :name, :rate, :pattern)',
                [
                    'code' => $rule['code'],
                    'name' => $rule['name'],
                    'rate' => $rule['rate'],
                    'pattern' => $rule['pattern'],
                ]
            );
        }

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE tax_rules');
    }
}
