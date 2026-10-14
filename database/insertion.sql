INSERT INTO users (pseudo, email, role, password, bio) VALUES
    ('alice', 'alice@example.com', 'guest',  'hash_alice', NULL),
    ('bob',   'bob@example.com',   'artist', 'hash_bob',   'Guitariste à Lausanne');

INSERT INTO events (id_role, titre, description, date_evenement, ville, lieu) VALUES
    (2, 'Concert acoustique', 'Soirée guitare et voix', '2026-11-20', 'Lausanne', 'Café du Grütli'),
    (2, 'Jam session',        'Scène ouverte',          '2026-12-05', 'Yverdon-les-Bains', 'Salle Cinétoile');

INSERT INTO favorites (user_id, event_id) VALUES
    (1, 1),
    (1, 2);

INSERT INTO comments (user_id, event_id, content) VALUES
    (1, 1, 'Hâte de y être !'),
    (1, 2, 'Super idée, je viens.');
