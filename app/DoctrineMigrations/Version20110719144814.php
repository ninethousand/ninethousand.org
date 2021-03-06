<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20110719144814 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE jobqueue_history (id INT AUTO_INCREMENT NOT NULL, job INT DEFAULT NULL, timestamp DATE DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, severity VARCHAR(255) DEFAULT NULL, active INT NOT NULL, INDEX IDX_90001CF3FBD8E0F8 (job), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_param (id INT AUTO_INCREMENT NOT NULL, job INT NOT NULL, param_name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, retry INT NOT NULL, cooldown INT NOT NULL, max_retries INT NOT NULL, attempts INT NOT NULL, executable LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, create_date DATETIME NOT NULL, last_run DATETIME DEFAULT NULL, active INT NOT NULL, schedule VARCHAR(255) DEFAULT NULL, parent INT NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_job_param (job_id INT NOT NULL, param_id INT NOT NULL, INDEX IDX_CDBE7F80BE04EA9 (job_id), UNIQUE INDEX UNIQ_CDBE7F805647C863 (param_id), PRIMARY KEY(job_id, param_id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_job_arg (job_id INT NOT NULL, arg_id INT NOT NULL, INDEX IDX_BE468A3BE04EA9 (job_id), UNIQUE INDEX UNIQ_BE468A3CE891D6B (arg_id), PRIMARY KEY(job_id, arg_id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_job_tag (job_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_70E648AABE04EA9 (job_id), UNIQUE INDEX UNIQ_70E648AABAD26311 (tag_id), PRIMARY KEY(job_id, tag_id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_arg (id INT AUTO_INCREMENT NOT NULL, job INT NOT NULL, value VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE jobqueue_tag (id INT AUTO_INCREMENT NOT NULL, job INT NOT NULL, value VARCHAR(255) NOT NULL, active INT NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE jobqueue_history ADD FOREIGN KEY (job) REFERENCES jobqueue_job(id)");
        $this->addSql("ALTER TABLE jobqueue_job_param ADD FOREIGN KEY (job_id) REFERENCES jobqueue_job(id)");
        $this->addSql("ALTER TABLE jobqueue_job_param ADD FOREIGN KEY (param_id) REFERENCES jobqueue_param(id)");
        $this->addSql("ALTER TABLE jobqueue_job_arg ADD FOREIGN KEY (job_id) REFERENCES jobqueue_job(id)");
        $this->addSql("ALTER TABLE jobqueue_job_arg ADD FOREIGN KEY (arg_id) REFERENCES jobqueue_arg(id)");
        $this->addSql("ALTER TABLE jobqueue_job_tag ADD FOREIGN KEY (job_id) REFERENCES jobqueue_job(id)");
        $this->addSql("ALTER TABLE jobqueue_job_tag ADD FOREIGN KEY (tag_id) REFERENCES jobqueue_tag(id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE jobqueue_job_param DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_history DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_job_param DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_job_arg DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_job_tag DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_job_arg DROP FOREIGN KEY ");
        $this->addSql("ALTER TABLE jobqueue_job_tag DROP FOREIGN KEY ");
        $this->addSql("DROP TABLE jobqueue_history");
        $this->addSql("DROP TABLE jobqueue_param");
        $this->addSql("DROP TABLE jobqueue_job");
        $this->addSql("DROP TABLE jobqueue_job_param");
        $this->addSql("DROP TABLE jobqueue_job_arg");
        $this->addSql("DROP TABLE jobqueue_job_tag");
        $this->addSql("DROP TABLE jobqueue_arg");
        $this->addSql("DROP TABLE jobqueue_tag");
    }
}
