-- Script de creation de la base de donnees
-- Projet : Gestion des rendez-vous d'un cabinet medical

CREATE DATABASE IF NOT EXISTS gestion_rdv_medical
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gestion_rdv_medical;

-- Table des praticiens du cabinet
CREATE TABLE IF NOT EXISTS praticien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table des patients
CREATE TABLE IF NOT EXISTS patient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- Table des rendez-vous
-- Un rendez-vous relie un patient a un praticien a une date/heure donnee
CREATE TABLE IF NOT EXISTS rendezvous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    praticien_id INT NOT NULL,
    date_rdv DATE NOT NULL,
    heure_rdv TIME NOT NULL,
    motif VARCHAR(255),
    statut ENUM('en_attente', 'confirme', 'annule') NOT NULL DEFAULT 'en_attente',
    CONSTRAINT fk_rdv_patient FOREIGN KEY (patient_id) REFERENCES patient(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_rdv_praticien FOREIGN KEY (praticien_id) REFERENCES praticien(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
