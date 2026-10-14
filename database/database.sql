-- MariaDB : à lancer avec la base cible sélectionnée
USE my_database;

DROP TABLE IF EXISTS comments, favorites, events, users;
 
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    pseudo        VARCHAR(25)  NOT NULL UNIQUE,
    email         VARCHAR(100) NOT NULL UNIQUE,
    role          ENUM('guest', 'artist') NOT NULL DEFAULT 'guest',
    password      VARCHAR(255) NOT NULL, 
    date_creation DATE NOT NULL DEFAULT CURRENT_DATE,
    bio           VARCHAR(500)
);
 
CREATE TABLE events (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    id_role        INT          NOT NULL, 
    titre          VARCHAR(50)  NOT NULL,
    description    VARCHAR(500),
    date_evenement DATE         NOT NULL,
    ville          VARCHAR(50)  NOT NULL,
    lieu           VARCHAR(50)  NOT NULL,
    date_creation  DATE         NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_role) REFERENCES users(id) ON DELETE CASCADE
);
 
CREATE TABLE favorites (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT  NOT NULL,
    event_id   INT  NOT NULL,
    created_at DATE NOT NULL DEFAULT CURRENT_DATE,
    UNIQUE (user_id, event_id),
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
 
CREATE TABLE comments (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT          NOT NULL,
    event_id   INT          NOT NULL,
    content    VARCHAR(300) NOT NULL,
    created_at DATE         NOT NULL DEFAULT CURRENT_DATE,
    updated_at DATE,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
