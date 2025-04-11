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
            CREATE TABLE product (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) UNIQUE NOT NULL,
                price NUMERIC NOT NULL CHECK (price > 0)
            )
        ');

        $products = [
            ['name' => 'Iphone', 'price' => 100],
            ['name' => 'Наушники', 'price' => 20],
            ['name' => 'Чехол', 'price' => 10],
            ['name' => 'Колонки', 'price' => 100010],
        ];

        foreach ($products as $product) {
            $this->addSql('
            INSERT INTO product (name, price)
            VALUES
            (:name, :price)',
            [
                'name' => $product['name'],
                'price' => $product['price']
            ]
        );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product');
    }
}
