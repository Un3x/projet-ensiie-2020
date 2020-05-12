--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2
-- Dumped by pg_dump version 12.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: composition; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.composition (
    id integer NOT NULL,
    compo text
);


ALTER TABLE public.composition OWNER TO postgres;

--
-- Name: espace_com_joueur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.espace_com_joueur (
    id integer NOT NULL,
    id_joueur integer,
    id_posteur integer,
    dateheure_post timestamp with time zone,
    dateheure_edition timestamp with time zone,
    contenu text
);


ALTER TABLE public.espace_com_joueur OWNER TO postgres;

--
-- Name: espace_com_tactique; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.espace_com_tactique (
    id integer NOT NULL,
    id_tactique integer,
    id_posteur integer,
    dateheure_post timestamp with time zone,
    dateheure_edition timestamp with time zone,
    contenu text
);


ALTER TABLE public.espace_com_tactique OWNER TO postgres;

--
-- Name: f_categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.f_categories (
    id integer NOT NULL,
    nom text
);


ALTER TABLE public.f_categories OWNER TO postgres;

--
-- Name: f_messages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.f_messages (
    id integer NOT NULL,
    id_topic integer,
    id_posteur integer,
    dateheure_post timestamp with time zone,
    dateheure_edition timestamp with time zone,
    meilleur_reponse integer,
    contenu text
);


ALTER TABLE public.f_messages OWNER TO postgres;

--
-- Name: f_souscategories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.f_souscategories (
    id integer NOT NULL,
    id_cate integer,
    nom text
);


ALTER TABLE public.f_souscategories OWNER TO postgres;

--
-- Name: f_topics; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.f_topics (
    id integer NOT NULL,
    id_createur integer,
    sujet text,
    contenu text,
    dateheure_creat timestamp with time zone,
    resolu integer
);


ALTER TABLE public.f_topics OWNER TO postgres;

--
-- Name: f_topicscate; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.f_topicscate (
    id_topicscate integer NOT NULL,
    id_topic integer,
    id_cate integer,
    id_souscate integer
);


ALTER TABLE public.f_topicscate OWNER TO postgres;

--
-- Name: joueurs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.joueurs (
    id integer NOT NULL,
    nom text,
    prenom text,
    age integer,
    nation_id integer,
    poste text,
    attaque integer,
    defense integer,
    technique integer,
    note double precision,
    valeur double precision,
    note_utilisateur double precision
);


ALTER TABLE public.joueurs OWNER TO postgres;

--
-- Name: membre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.membre (
    id integer NOT NULL,
    nom text,
    prenom text,
    pseudo text,
    mail text,
    club text,
    m_version text,
    motdepasse text,
    m_admin integer
);


ALTER TABLE public.membre OWNER TO postgres;

--
-- Name: nation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nation (
    id integer NOT NULL,
    nom text
);


ALTER TABLE public.nation OWNER TO postgres;

--
-- Name: tactique; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tactique (
    id integer NOT NULL,
    nom text,
    id_membre integer,
    equipe text,
    composition integer,
    commentaire text,
    dateheure_creat timestamp with time zone,
    joueur1 text,
    joueur2 text,
    joueur3 text,
    joueur4 text,
    joueur5 text,
    joueur6 text,
    joueur7 text,
    joueur8 text,
    joueur9 text,
    joueur10 text,
    joueur11 text
);


ALTER TABLE public.tactique OWNER TO postgres;

--
-- Name: tactique_nom_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tactique_nom_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tactique_nom_seq OWNER TO postgres;

--
-- Name: tactique_nom_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tactique_nom_seq OWNED BY public.tactique.nom;


--
-- Data for Name: composition; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.composition VALUES (1, '4-2-3-1');
INSERT INTO public.composition VALUES (2, '4-3-3');
INSERT INTO public.composition VALUES (3, '4-2-4');
INSERT INTO public.composition VALUES (4, '5-2-2-1');
INSERT INTO public.composition VALUES (5, '3-4-3');


--
-- Data for Name: espace_com_joueur; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.espace_com_joueur VALUES (1, 1, 6, '2020-05-11 15:15:45.612484+02', '2020-05-11 15:15:45.612484+02', '                  k      
                    ');


--
-- Data for Name: espace_com_tactique; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: f_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.f_categories VALUES (1, 'Football Manager 2020');
INSERT INTO public.f_categories VALUES (2, 'Football Manager 2021');
INSERT INTO public.f_categories VALUES (3, 'Football');
INSERT INTO public.f_categories VALUES (4, 'Annonces');


--
-- Data for Name: f_messages; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.f_messages VALUES (1, 1, 6, '2020-05-11 14:26:03.864409+02', '2020-05-11 14:26:03.864409+02', 0, '                       
                    rr');
INSERT INTO public.f_messages VALUES (2, 1, 6, '2020-05-11 14:30:35.323618+02', '2020-05-11 14:30:35.323618+02', 0, '                       
                    tr');
INSERT INTO public.f_messages VALUES (3, 1, 6, '2020-05-11 14:30:50.305618+02', '2020-05-11 14:30:50.305618+02', 0, '                       
                    gregergergeg');
INSERT INTO public.f_messages VALUES (4, 1, 6, '2020-05-11 14:33:50.13101+02', '2020-05-11 14:33:50.13101+02', 0, '                       
                    Ezetrol® (10 mg d’ézétimibe par comprimé) est indiqué comme traitement adjuvant au régime chez les patients ayant une hypercholestérolémie primaire (familiale ou non) ou une dyslipidémie mixte, lorsque ces patients ne sont pas contrôlés de façon appropriée par une statine seule, ou lorsqu’un traitement par statine est inapproprié ou mal toléré. Ezetrol® est aussi indiqué chez les patients ayant une sitostérolémie homozygote. Il n’a pas d’action sur les triglycérides. Dans l’hypercholestérolémie primaire, Ezetrol® apporte une ASMR modérée (niveau III) par rapport à la colestyramine.
Lorsqu’il est opportun d’associer l’ézétimibe à une statine, il est possible d’utiliser l’association fixe ézétimibe-simvastatine (Inegy®) pour simplifier la prise du traitement. Inegy® (10 mg d’ézétimibe et 20 ou 40 mg de simvastatine par comprimé) est indiqué comme traitement adjuvant au régime chez les patients ayant une hypercholestérolémie primaire (familiale ou non) ou une dyslipidémie mixte et qui ne sont pas contrôlés de façon appropriée par une statine seule, ou chez les patients qui reçoivent déjà une statine et de l’ézétimibe. Comme l’ensemble des associations fixes, Inegy® n’apporte pas d’ASMR par rapport à la prise séparée des deux principes actifs.
 

Autres caractéristiques à retenir :
Pas d’étude de morbimortalité à ce jour pour l’ézétimibe.
Plusieurs statines ont montré qu’elles réduisent le risque d’événements cardiovasculaires, mais l’ézétimibe n’a pas à ce jour démontré ce type d’effet (des études évaluant son efficacité dans la prévention des complications de l’athérosclérose sont en cours). Il n’y a donc pas lieu de prescrire Ezetrol® ou Inegy® avant d’avoir éprouvé l’efficacité et la tolérance d’une statine en monothérapie, si besoin à la plus forte dose autorisée. On préférera les statines ayant prouvé leur efficacité sur la morbimortalité cardiovasculaire, en ayant recours parmi elles, si nécessaire, aux molécules les plus puissantes sur la baisse du LDL-C.

Le risque musculaire existe.
Des observations d’atteinte musculaire grave avec l’association ézétimibe-statine et même avec l’ézétimibe seul ont été rapportées. L’Afssaps a mis en place un suivi national des données de pharmacovigilance sur cette molécule.');


--
-- Data for Name: f_souscategories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.f_souscategories VALUES (1, 1, 'Discussion générale');
INSERT INTO public.f_souscategories VALUES (2, 1, 'Conseil Tactique');
INSERT INTO public.f_souscategories VALUES (3, 1, 'Conseil Joueur');
INSERT INTO public.f_souscategories VALUES (4, 1, 'Rejoindre un serveur');
INSERT INTO public.f_souscategories VALUES (5, 1, 'Créer un serveur');
INSERT INTO public.f_souscategories VALUES (6, 2, 'Discussion générale');
INSERT INTO public.f_souscategories VALUES (7, 2, 'Infos');
INSERT INTO public.f_souscategories VALUES (8, 3, 'Infos');
INSERT INTO public.f_souscategories VALUES (9, 3, 'Equipes');
INSERT INTO public.f_souscategories VALUES (10, 3, 'Joueurs');
INSERT INTO public.f_souscategories VALUES (11, 1, 'Tournoi');
INSERT INTO public.f_souscategories VALUES (12, 3, 'Transfert');
INSERT INTO public.f_souscategories VALUES (13, 3, 'Supporters');
INSERT INTO public.f_souscategories VALUES (14, 4, 'Admin');


--
-- Data for Name: f_topics; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.f_topics VALUES (1, 6, 'rr', 'rrre', '2020-05-11 14:25:25.74806+02', 0);


--
-- Data for Name: f_topicscate; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.f_topicscate VALUES (1, 1, 1, 3);


--
-- Data for Name: joueurs; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.joueurs VALUES (1, 'Messi', 'Lionel', 32, 10, 'ATT', 20, 11, 18, 4.5, 120, 0);
INSERT INTO public.joueurs VALUES (2, 'Ronaldo', 'Cristiano', 35, 9, 'ATT', 20, 12, 17, 4.5, 120, 0);
INSERT INTO public.joueurs VALUES (3, 'Ter', 'Stegen', 38, 7, 'GK', 4, 18, 7, 4.5, 120, 0);


--
-- Data for Name: membre; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.membre VALUES (3, 's', 'c', 'b', 'b@b.com', 'om', 'FM20', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 0);
INSERT INTO public.membre VALUES (5, 'd', 'd', 'admin', 'admin@admin.com', 'd', 'FM20', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 1);
INSERT INTO public.membre VALUES (6, NULL, NULL, 'sam', 's@gmail.com', NULL, NULL, 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 1);


--
-- Data for Name: nation; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.nation VALUES (1, 'Sri lanka');
INSERT INTO public.nation VALUES (2, 'France');
INSERT INTO public.nation VALUES (3, 'Maroc');
INSERT INTO public.nation VALUES (4, 'Angleterre');
INSERT INTO public.nation VALUES (5, 'USA');
INSERT INTO public.nation VALUES (6, 'Allemagne');
INSERT INTO public.nation VALUES (7, 'Pays Bas');
INSERT INTO public.nation VALUES (8, 'Espagne');
INSERT INTO public.nation VALUES (9, 'Portugal');
INSERT INTO public.nation VALUES (10, 'Argentine');
INSERT INTO public.nation VALUES (11, 'Serbie');
INSERT INTO public.nation VALUES (12, 'Ecosse');
INSERT INTO public.nation VALUES (13, 'Bresil');
INSERT INTO public.nation VALUES (14, 'Italie');
INSERT INTO public.nation VALUES (15, 'Algerie');
INSERT INTO public.nation VALUES (16, 'Cote d''ivoire');
INSERT INTO public.nation VALUES (17, 'Norvege');
INSERT INTO public.nation VALUES (18, 'Belgique');


--
-- Data for Name: tactique; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.tactique VALUES (2, 'd', 5, 'dd', 1, 'd', '2020-05-11 01:11:16.489446+02', 'Stegen Ter', 'Stegen Ter', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi');
INSERT INTO public.tactique VALUES (3, 'dee', 5, 'ddee', 1, 'deded', '2020-05-11 01:43:23.032533+02', 'Stegen Ter', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Lionel Messi', 'Cristiano Ronaldo', 'Lionel Messi', 'Lionel Messi');


--
-- Name: tactique_nom_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tactique_nom_seq', 1, false);


--
-- Name: composition composition_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.composition
    ADD CONSTRAINT composition_pkey PRIMARY KEY (id);


--
-- Name: espace_com_joueur espace_com_joueur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.espace_com_joueur
    ADD CONSTRAINT espace_com_joueur_pkey PRIMARY KEY (id);


--
-- Name: espace_com_tactique espace_com_tactique_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.espace_com_tactique
    ADD CONSTRAINT espace_com_tactique_pkey PRIMARY KEY (id);


--
-- Name: f_categories f_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.f_categories
    ADD CONSTRAINT f_categories_pkey PRIMARY KEY (id);


--
-- Name: f_messages f_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.f_messages
    ADD CONSTRAINT f_messages_pkey PRIMARY KEY (id);


--
-- Name: f_souscategories f_souscategories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.f_souscategories
    ADD CONSTRAINT f_souscategories_pkey PRIMARY KEY (id);


--
-- Name: f_topics f_topic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.f_topics
    ADD CONSTRAINT f_topic_pkey PRIMARY KEY (id);


--
-- Name: f_topicscate f_topicscate_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.f_topicscate
    ADD CONSTRAINT f_topicscate_pkey PRIMARY KEY (id_topicscate);


--
-- Name: joueurs joueurs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.joueurs
    ADD CONSTRAINT joueurs_pkey PRIMARY KEY (id);


--
-- Name: membre membre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.membre
    ADD CONSTRAINT membre_pkey PRIMARY KEY (id);


--
-- Name: nation nation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nation
    ADD CONSTRAINT nation_pkey PRIMARY KEY (id);


--
-- Name: tactique tactique_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tactique
    ADD CONSTRAINT tactique_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

