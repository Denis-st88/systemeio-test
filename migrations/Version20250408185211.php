<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250408185211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table "product". Insert data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE product (id serial PRIMARY KEY, name VARCHAR(255) NOT NULL, price NUMERIC NOT NULL)
        ');

        $this->addSql('CREATE UNIQUE INDEX product_name_unq ON product (name)');

        $this->addSql('
            INSERT INTO product (name, price) VALUES (\'Iphone\', 100), (\'Наушники\', 20), (\'Чехол\', 10)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product');
    }
}
