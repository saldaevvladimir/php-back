<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203070814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects ADD project_group_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN projects.project_group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4C31A529C FOREIGN KEY (project_group_id) REFERENCES projects_groups (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5C93B3A4C31A529C ON projects (project_group_id)');
        $this->addSql('ALTER TABLE tasks ADD project_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN tasks.project_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_50586597166D1F9C ON tasks (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE projects DROP CONSTRAINT FK_5C93B3A4C31A529C');
        $this->addSql('DROP INDEX IDX_5C93B3A4C31A529C');
        $this->addSql('ALTER TABLE projects DROP project_group_id');
        $this->addSql('ALTER TABLE tasks DROP CONSTRAINT FK_50586597166D1F9C');
        $this->addSql('DROP INDEX IDX_50586597166D1F9C');
        $this->addSql('ALTER TABLE tasks DROP project_id');
    }
}
