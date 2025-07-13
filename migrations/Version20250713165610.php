<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713165610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, tittle VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, introduction LONGTEXT NOT NULL, content LONGTEXT NOT NULL, conver_image VARCHAR(255) NOT NULL, rooms INT NOT NULL, INDEX IDX_F65593E5F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, booker_id INT NOT NULL, booking_annonce_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', comment LONGTEXT DEFAULT NULL, INDEX IDX_E00CEDDE8B7E4006 (booker_id), INDEX IDX_E00CEDDE119FC85E (booking_annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) NOT NULL, INDEX IDX_C53D045F8805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, introduction VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8B7E4006 FOREIGN KEY (booker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE119FC85E FOREIGN KEY (booking_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5F675F31B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8B7E4006');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE119FC85E');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8805AB2F');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
