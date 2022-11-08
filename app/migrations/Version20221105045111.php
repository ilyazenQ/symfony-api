<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221105045111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_report (id INT AUTO_INCREMENT NOT NULL, orders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', title VARCHAR(255) DEFAULT NULL, total_count INT DEFAULT NULL, total_price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE monthly_report (id INT AUTO_INCREMENT NOT NULL, orders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', title VARCHAR(255) DEFAULT NULL, total_count INT DEFAULT NULL, total_price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, products JSON DEFAULT NULL, approved TINYINT(1) NOT NULL, price INT DEFAULT NULL, total_count INT DEFAULT NULL, approved_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weekly_report (id INT AUTO_INCREMENT NOT NULL, orders LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', title VARCHAR(255) DEFAULT NULL, total_count INT DEFAULT NULL, total_price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE daily_report');
        $this->addSql('DROP TABLE monthly_report');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE weekly_report');
    }
}
