<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221020000757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE attendance_record (id VARCHAR(255) NOT NULL, student_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, attended TINYINT(1) NOT NULL, INDEX IDX_311E8495CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id VARCHAR(255) NOT NULL, matriculation_number VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance_record ADD CONSTRAINT FK_311E8495CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE attendance_record DROP FOREIGN KEY FK_311E8495CB944F1A');
        $this->addSql('DROP TABLE attendance_record');
        $this->addSql('DROP TABLE student');
    }
}
