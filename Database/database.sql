-- Proximusic : schema MySQL / MariaDB
CREATE DATABASE IF NOT EXISTS my_database;
USE my_database;

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('guest', 'artist', 'admin') NOT NULL DEFAULT 'guest',
    password VARCHAR(255) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    bio VARCHAR(500) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
);

CREATE TABLE events (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    artist_id INT UNSIGNED NOT NULL,
    titre VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    date_evenement DATETIME NOT NULL,
    ville VARCHAR(50) NOT NULL,
    lieu VARCHAR(50) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_events_artist (artist_id),
    KEY idx_events_date (date_evenement),
    CONSTRAINT fk_events_artist FOREIGN KEY (artist_id)
        REFERENCES users (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE TABLE favorites (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    event_id INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_favorites_user_event (user_id, event_id),
    KEY idx_favorites_event (event_id),
    CONSTRAINT fk_favorites_user FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE RESTRICT,
    CONSTRAINT fk_favorites_event FOREIGN KEY (event_id)
        REFERENCES events (id) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE comments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    event_id INT UNSIGNED NOT NULL,
    content VARCHAR(300) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_comments_user (user_id),
    KEY idx_comments_event (event_id),
    CONSTRAINT fk_comments_user FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE ON UPDATE RESTRICT,
    CONSTRAINT fk_comments_event FOREIGN KEY (event_id)
        REFERENCES events (id) ON DELETE CASCADE ON UPDATE RESTRICT
);
