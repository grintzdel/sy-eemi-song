<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251113140624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums (id VARCHAR(36) NOT NULL, author_id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, category_id VARCHAR(36) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE categories (id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CATEGORY_NAME ON categories (name)');
        $this->addSql('CREATE TABLE songs (id VARCHAR(36) NOT NULL, artist_id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, category_id VARCHAR(36) NOT NULL, tag VARCHAR(100) DEFAULT NULL, duration INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE song_albums (song_id VARCHAR(36) NOT NULL, album_id VARCHAR(36) NOT NULL, PRIMARY KEY (song_id, album_id))');
        $this->addSql('CREATE INDEX IDX_F29956C5A0BDB2F3 ON song_albums (song_id)');
        $this->addSql('CREATE INDEX IDX_F29956C51137ABCF ON song_albums (album_id)');
        $this->addSql('ALTER TABLE song_albums ADD CONSTRAINT FK_F29956C5A0BDB2F3 FOREIGN KEY (song_id) REFERENCES songs (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE song_albums ADD CONSTRAINT FK_F29956C51137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE song_albums DROP CONSTRAINT FK_F29956C5A0BDB2F3');
        $this->addSql('ALTER TABLE song_albums DROP CONSTRAINT FK_F29956C51137ABCF');
        $this->addSql('DROP TABLE albums');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE songs');
        $this->addSql('DROP TABLE song_albums');
    }
}
