<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315191157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cat_portfolio (id INT AUTO_INCREMENT NOT NULL, name_fr VARCHAR(255) NOT NULL, name_en VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galery_portfolio (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, file VARCHAR(255) NOT NULL, caption_fr VARCHAR(255) NOT NULL, caption_en VARCHAR(255) NOT NULL, INDEX IDX_2CD77DF1B96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, images VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, description_fr VARCHAR(255) NOT NULL, description_en VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, title_fr VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, text_fr LONGTEXT DEFAULT NULL, text_en LONGTEXT DEFAULT NULL, description_fr VARCHAR(255) NOT NULL, description_en VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, title_fr VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, description_fr LONGTEXT NOT NULL, description_en LONGTEXT NOT NULL, link VARCHAR(255) DEFAULT NULL, cover_image VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_cat_portfolio (portfolio_id INT NOT NULL, cat_portfolio_id INT NOT NULL, INDEX IDX_6C5403B6B96B5643 (portfolio_id), INDEX IDX_6C5403B61870A21D (cat_portfolio_id), PRIMARY KEY(portfolio_id, cat_portfolio_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, title_fr VARCHAR(255) NOT NULL, title_en VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_en LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, roles_fr VARCHAR(255) NOT NULL, roles_en VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galery_portfolio ADD CONSTRAINT FK_2CD77DF1B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_cat_portfolio ADD CONSTRAINT FK_6C5403B6B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_cat_portfolio ADD CONSTRAINT FK_6C5403B61870A21D FOREIGN KEY (cat_portfolio_id) REFERENCES cat_portfolio (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galery_portfolio DROP FOREIGN KEY FK_2CD77DF1B96B5643');
        $this->addSql('ALTER TABLE portfolio_cat_portfolio DROP FOREIGN KEY FK_6C5403B6B96B5643');
        $this->addSql('ALTER TABLE portfolio_cat_portfolio DROP FOREIGN KEY FK_6C5403B61870A21D');
        $this->addSql('DROP TABLE cat_portfolio');
        $this->addSql('DROP TABLE galery_portfolio');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE meta');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE portfolio_cat_portfolio');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
