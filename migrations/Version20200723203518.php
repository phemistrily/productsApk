<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723203518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_product_owner (product_id INT NOT NULL, product_owner_id INT NOT NULL, INDEX IDX_B4D181D24584665A (product_id), INDEX IDX_B4D181D2B58C0B6E (product_owner_id), PRIMARY KEY(product_id, product_owner_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_product_owner ADD CONSTRAINT FK_B4D181D24584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_owner ADD CONSTRAINT FK_B4D181D2B58C0B6E FOREIGN KEY (product_owner_id) REFERENCES product_owner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_stock ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_EA6A2D3C4584665A ON product_stock (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_product_owner');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4584665A');
        $this->addSql('DROP INDEX IDX_EA6A2D3C4584665A ON product_stock');
        $this->addSql('ALTER TABLE product_stock DROP product_id');
    }
}
