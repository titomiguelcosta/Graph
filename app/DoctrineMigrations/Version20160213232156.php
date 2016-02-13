<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160213232156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE edge (id VARCHAR NOT NULL, from_id VARCHAR NOT NULL, to_id VARCHAR NOT NULL, graph_id VARCHAR NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7506D36678CED90B ON edge (from_id)');
        $this->addSql('CREATE INDEX IDX_7506D36630354A65 ON edge (to_id)');
        $this->addSql('CREATE INDEX IDX_7506D36699134837 ON edge (graph_id)');
        $this->addSql('CREATE TABLE node (id VARCHAR NOT NULL, graph_id VARCHAR NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_857FE84599134837 ON node (graph_id)');
        $this->addSql('CREATE TABLE graph (id VARCHAR NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D36678CED90B FOREIGN KEY (from_id) REFERENCES node (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D36630354A65 FOREIGN KEY (to_id) REFERENCES node (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE edge ADD CONSTRAINT FK_7506D36699134837 FOREIGN KEY (graph_id) REFERENCES graph (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE84599134837 FOREIGN KEY (graph_id) REFERENCES graph (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE edge DROP CONSTRAINT FK_7506D36678CED90B');
        $this->addSql('ALTER TABLE edge DROP CONSTRAINT FK_7506D36630354A65');
        $this->addSql('ALTER TABLE edge DROP CONSTRAINT FK_7506D36699134837');
        $this->addSql('ALTER TABLE node DROP CONSTRAINT FK_857FE84599134837');
        $this->addSql('DROP TABLE edge');
        $this->addSql('DROP TABLE node');
        $this->addSql('DROP TABLE graph');
    }
}