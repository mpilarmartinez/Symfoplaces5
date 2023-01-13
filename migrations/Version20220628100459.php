<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628100459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, lugar_id INT DEFAULT NULL, user_id INT DEFAULT NULL, fecha DATETIME DEFAULT NULL, texto LONGTEXT DEFAULT NULL, INDEX IDX_4B91E702B5A3803B (lugar_id), INDEX IDX_4B91E702A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foto (id INT AUTO_INCREMENT NOT NULL, lugar_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha DATE DEFAULT NULL, archivo VARCHAR(255) DEFAULT NULL, INDEX IDX_EADC3BE5B5A3803B (lugar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lugar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nombre VARCHAR(128) NOT NULL, pais VARCHAR(128) NOT NULL, descripcion VARCHAR(255) NOT NULL, tipo VARCHAR(128) NOT NULL, valoracion VARCHAR(128) NOT NULL, INDEX IDX_4974AAACA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, displayname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702B5A3803B FOREIGN KEY (lugar_id) REFERENCES lugar (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE foto ADD CONSTRAINT FK_EADC3BE5B5A3803B FOREIGN KEY (lugar_id) REFERENCES lugar (id)');
        $this->addSql('ALTER TABLE lugar ADD CONSTRAINT FK_4974AAACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702B5A3803B');
        $this->addSql('ALTER TABLE foto DROP FOREIGN KEY FK_EADC3BE5B5A3803B');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702A76ED395');
        $this->addSql('ALTER TABLE lugar DROP FOREIGN KEY FK_4974AAACA76ED395');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('DROP TABLE foto');
        $this->addSql('DROP TABLE lugar');
        $this->addSql('DROP TABLE user');
    }
}
