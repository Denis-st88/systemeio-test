<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250409083046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new table "coupon". Insert data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE coupon (
                id SERIAL PRIMARY KEY,
                code CHAR(1) NOT NULL,
                type VARCHAR(100) NOT NULL,
                discount NUMERIC(5,2) NOT NULL
            )
        ');

        $coupons = [
            ['code' => 'P', 'type' => 'fix', 'discount' => 100],
            ['code' => 'P', 'type' => 'percent', 'discount' => 10],
            ['code' => 'P', 'type' => 'fix', 'discount' => 100],
            ['code' => 'P', 'type' => 'percent', 'discount' => 20],
        ];

        foreach ($coupons as $coupon) {
            $this->addSql(
                'INSERT INTO coupon (code, type, discount)
                VALUES
                (:code, :type, :discount)',
                [
                    'code' => $coupon['code'],
                    'type' => $coupon['type'],
                    'discount' => $coupon['discount']
                ]
            );
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE coupon');
    }
}
