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
