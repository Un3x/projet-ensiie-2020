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
    nom integer NOT NULL,
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
-- Name: tactique nom; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tactique ALTER COLUMN nom SET DEFAULT nextval('public.tactique_nom_seq'::regclass);


--
-- Data for Name: composition; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.composition (id, compo) FROM stdin;
1	4-2-3-1
2	4-3-3
3	4-2-4
4	5-2-2-1
5	3-4-3
\.


--
-- Data for Name: espace_com_joueur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.espace_com_joueur (id, id_joueur, id_posteur, dateheure_post, dateheure_edition, contenu) FROM stdin;
\.


--
-- Data for Name: espace_com_tactique; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.espace_com_tactique (id, id_tactique, id_posteur, dateheure_post, dateheure_edition, contenu) FROM stdin;
\.


--
-- Data for Name: f_categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.f_categories (id, nom) FROM stdin;
1	Football Manager 2020
2	Football Manager 2021
3	Football
4	Annonces
\.


--
-- Data for Name: f_messages; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.f_messages (id, id_topic, id_posteur, dateheure_post, dateheure_edition, meilleur_reponse, contenu) FROM stdin;
\.


--
-- Data for Name: f_souscategories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.f_souscategories (id, id_cate, nom) FROM stdin;
1	1	Discussion générale
2	1	Conseil Tactique
3	1	Conseil Joueur
4	1	Rejoindre un serveur
5	1	Créer un serveur
6	2	Discussion générale
7	2	Infos
8	3	Infos
9	3	Equipes
10	3	Joueurs
11	1	Tournoi
12	3	Transfert
13	3	Supporters
14	4	Admin
\.


--
-- Data for Name: f_topics; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.f_topics (id, id_createur, sujet, contenu, dateheure_creat, resolu) FROM stdin;
\.


--
-- Data for Name: f_topicscate; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.f_topicscate (id_topicscate, id_topic, id_cate, id_souscate) FROM stdin;
\.


--
-- Data for Name: joueurs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.joueurs (id, nom, prenom, age, nation_id, poste, attaque, defense, technique, note, valeur, note_utilisateur) FROM stdin;
1	Messi	Lionel	32	10	ATT	20	11	18	4.5	120	0
2	Ronaldo	Cristiano	35	9	ATT	20	12	17	4.5	120	0
\.


--
-- Data for Name: membre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.membre (id, nom, prenom, pseudo, mail, club, m_version, motdepasse, m_admin) FROM stdin;
2	\N	\N	sam	a@gmail.com	\N	\N	dc76e9f0c0006e8f919e0c515c66dbba3982f785	0
4	dd	c	cd	c@b.com	ff	FM20	84a516841ba77a5b4648de2cd0dfcb30ea46dbb4	0
3	s	c	b	b@b.com	om	FM20	e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98	0
5	\N	\N	admin	admin@admin.com	\N	\N	dc76e9f0c0006e8f919e0c515c66dbba3982f785	1
\.


--
-- Data for Name: nation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nation (id, nom) FROM stdin;
1	Sri lanka
2	France
3	Maroc
4	Angleterre
5	USA
6	Allemagne
7	Pays Bas
8	Espagne
9	Portugal
10	Argentine
11	Serbie
12	Ecosse
13	Bresil
14	Italie
15	Algerie
16	Cote d'ivoire
17	Norvege
18	Belgique
\.


--
-- Data for Name: tactique; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tactique (id, nom, id_membre, equipe, composition, commentaire, dateheure_creat, joueur1, joueur2, joueur3, joueur4, joueur5, joueur6, joueur7, joueur8, joueur9, joueur10, joueur11) FROM stdin;
\.


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

