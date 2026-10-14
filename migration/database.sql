-- Proximusic : schema MySQL / MariaDB

CREATE DATABASE database_db;

CREATE TYPE user_role AS ENUM ('guest', 'artist');

CREATE TABLE users (
    id            SERIAL PRIMARY KEY,
    pseudo        VARCHAR(25)  NOT NULL UNIQUE,
    email         VARCHAR(100) NOT NULL UNIQUE,
    role          user_role    NOT NULL DEFAULT 'guest',
    password      VARCHAR(255) NOT NULL, 
    date_creation DATE         NOT NULL DEFAULT CURRENT_DATE,
    bio           VARCHAR(500)
);

CREATE TABLE events (
    id             SERIAL PRIMARY KEY,
    id_role        INT          NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    titre          VARCHAR(50)  NOT NULL,
    description    VARCHAR(500),
    date_evenement DATE         NOT NULL,
    ville          VARCHAR(50)  NOT NULL,
    lieu           VARCHAR(50)  NOT NULL,
    date_creation  DATE         NOT NULL DEFAULT CURRENT_DATE
);

CREATE TABLE favorites (
    id         SERIAL PRIMARY KEY,
    user_id    INT  NOT NULL REFERENCES users(id)  ON DELETE CASCADE,
    event_id   INT  NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    created_at DATE NOT NULL DEFAULT CURRENT_DATE,
    UNIQUE (user_id, event_id)
);

CREATE TABLE comments (
    id         SERIAL PRIMARY KEY,
    user_id    INT          NOT NULL REFERENCES users(id)  ON DELETE CASCADE,
    event_id   INT          NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    content    VARCHAR(300) NOT NULL,
    created_at DATE         NOT NULL DEFAULT CURRENT_DATE,
    updated_at DATE
);
