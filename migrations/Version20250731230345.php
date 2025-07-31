<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731230345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__photos AS SELECT id, album_id FROM photos');
        $this->addSql('DROP TABLE photos');
        $this->addSql('CREATE TABLE photos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, album_id INTEGER NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INTEGER DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_876E0D91137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO photos (id, album_id) SELECT id, album_id FROM __temp__photos');
        $this->addSql('DROP TABLE __temp__photos');
        $this->addSql('CREATE INDEX IDX_876E0D91137ABCF ON photos (album_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__photos AS SELECT id, album_id FROM photos');
        $this->addSql('DROP TABLE photos');
        $this->addSql('CREATE TABLE photos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, album_id INTEGER NOT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_876E0D91137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO photos (id, album_id) SELECT id, album_id FROM __temp__photos');
        $this->addSql('DROP TABLE __temp__photos');
        $this->addSql('CREATE INDEX IDX_876E0D91137ABCF ON photos (album_id)');
    }
}
