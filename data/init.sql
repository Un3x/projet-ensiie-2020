CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    pass VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    slogan VARCHAR NOT NULL DEFAULT '',
    descript VARCHAR NOT NULL DEFAULT '',
    inactive BOOLEAN DEFAULT false,
    is_admin BOOLEAN default false,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('Coco', '$2y$10$yk2c6EyDbcfsjvFO5fWqheaReREUqNqKJncP2wk9YPe9ltkvaiOWC','coco@virus.fr', 'Je suis là...', 'Distanciation physique !',NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, inactive, created_at)  VALUES ('Drive',  '$2y$10$O7lTqP/ytQNaV0nQplDFw.0U6u5zMfaRz4cWMvBH0V9LEYXG/Osna','durra@yeuve.com', 'Courrier ?', 'Oh un colis !', true, NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('César',  '$2y$10$fTzr0r/Y1vEIb5k63QwsKuDCMnok1A6J0Q1nb9PdaguPXCXBtWiAC','jule@cesar.com', 'Vous là !', 'VenIIE, vidIIE, vicIIE',NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('Mitei',  '$2y$10$Y4wC6FAWypNcItfFbYgVlejxdkPA.aNUmZ548QSP9ptxYER.xQVDC','mitmit@pyro.loc', 'Je veux manger...', '... surtout du chocolat',NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('Eniris',  '$2y$10$QdgaWPvO3ISSRmJKNKbvYutsdH/6mEYf8qiH2dFzwXU9yeRw3HWeK','eninilajolie@ensiie.fr', 'Dodo', 'Dodo...',NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, is_admin, created_at)  VALUES ('admin',  '$2y$10$WqALBs/e5.XOVHsTilWnauK.FT8pIdK2lx1P2EpJAB98CKTr9pJwK','root@ensiie.gr', 'Je suis la racine mouhaha', 'J aime le chocolat', true,NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('Maru',  '$2y$10$TfjJEGUZvptMQLDLOFfENOeCJI.87jtnqR7eYcJd07SlPEZcCLIRy','mama@ruru.lumieres', 'C est pas Versailles ici', '... !',NOW());
INSERT INTO "user" (username, pass, email, slogan, descript, created_at)  VALUES ('Groot',  '$2y$10$A/QTAFx//uVuCxMXeQmJLeVzu3flajNFz/OuXM9f23zQWXkKccEs6','i@am.groot', 'Je s appelle Groot', 'Je s appelle Groot',NOW());


CREATE TABLE "post" (
    id SERIAL PRIMARY KEY,
    content VARCHAR NOT NULL,
    like_count BIGINT DEFAULT 0,
    created_at TIMESTAMP WITH TIME ZONE,
    author_id BIGINT
);

INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Hâte de venir passer mes vacances ici l an prochain !', -1, NOW(), 1);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Ou cet été...', 1, NOW(), 1);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('J aime pas FacebIIkE', -7, NOW(), 5);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('J etais caché !', 0, NOW(), 2);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Nostalgique de mon bel empire...', -1, NOW(), 3);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Laissez moi dans le noir toute seule !', 2, NOW(), 7);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Je s appelle Groot !', +1, NOW(), 8);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Fetchez la vache !', 0, NOW(), 4);
INSERT INTO "post" (content, like_count, created_at, author_id)  VALUES ('Hâte de commencer mon nouveau travail de "aministrateur" chez FacebIIkE !', 0, NOW(), 6);


CREATE TABLE "comment" (
    id SERIAL PRIMARY KEY,
    content VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    author_id BIGINT,
    post_id BIGINT
);

INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Ah non pas encore toi', NOW(), 7, 1);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je plussoie', NOW(), 2, 4);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je s appelle Groot', NOW(), 8, 7);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je s appelle Groot', NOW(), 8, 7);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je s appelle Drive', NOW(), 2, 7);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je s appelle Groot', NOW(), 8, 7);
INSERT INTO "comment" (content, created_at, author_id, post_id)  VALUES ('Je s appelle Groot', NOW(), 8, 7);

CREATE TABLE "friendship" (
    id_user1 BIGINT,
    id_user2 BIGINT,
    status INT,
    status_date TIMESTAMP WITH TIME ZONE,
    PRIMARY KEY (id_user1, id_user2)
);

INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (5, 7, 1, NOW());
INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (4, 7, 1, NOW());
INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (1, 7, 1, NOW());
INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (4, 5, 0, NOW());
INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (4, 8, 1, NOW());

INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (2, 8, 1, NOW());
