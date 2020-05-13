--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2
-- Dumped by pg_dump version 12.2

-- Started on 2020-05-13 01:29:15

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 211 (class 1259 OID 24712)
-- Name: commentaire; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commentaire (
    commentaire text,
    id integer NOT NULL,
    id_personne integer,
    id_trajet integer
);


ALTER TABLE public.commentaire OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 24710)
-- Name: commentaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.commentaire_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.commentaire_id_seq OWNER TO postgres;

--
-- TOC entry 2884 (class 0 OID 0)
-- Dependencies: 210
-- Name: commentaire_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.commentaire_id_seq OWNED BY public.commentaire.id;


--
-- TOC entry 207 (class 1259 OID 16601)
-- Name: mairie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mairie (
    id_lieu integer NOT NULL,
    nom_lieu character varying
);


ALTER TABLE public.mairie OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 16599)
-- Name: mairie_id_lieu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.mairie_id_lieu_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mairie_id_lieu_seq OWNER TO postgres;

--
-- TOC entry 2885 (class 0 OID 0)
-- Dependencies: 206
-- Name: mairie_id_lieu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.mairie_id_lieu_seq OWNED BY public.mairie.id_lieu;


--
-- TOC entry 205 (class 1259 OID 16579)
-- Name: pwdReset; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."pwdReset" (
    "idReset" integer NOT NULL,
    "resetEmail" character varying,
    "resetSelector" character varying,
    "resetToken" character varying,
    "resetExpires" character varying
);


ALTER TABLE public."pwdReset" OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 16577)
-- Name: pwdReset_idReset_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."pwdReset_idReset_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."pwdReset_idReset_seq" OWNER TO postgres;

--
-- TOC entry 2886 (class 0 OID 0)
-- Dependencies: 204
-- Name: pwdReset_idReset_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."pwdReset_idReset_seq" OWNED BY public."pwdReset"."idReset";


--
-- TOC entry 213 (class 1259 OID 24723)
-- Name: reservation_trajet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservation_trajet (
    id_reservation integer NOT NULL,
    id_conducteur integer,
    id_passager integer,
    id_trajet integer,
    nombre_place_reserve integer,
    trajet_key character varying,
    confirm_trajet character varying
);


ALTER TABLE public.reservation_trajet OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 24721)
-- Name: reservation_trajet_id_reservation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reservation_trajet_id_reservation_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reservation_trajet_id_reservation_seq OWNER TO postgres;

--
-- TOC entry 2887 (class 0 OID 0)
-- Dependencies: 212
-- Name: reservation_trajet_id_reservation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reservation_trajet_id_reservation_seq OWNED BY public.reservation_trajet.id_reservation;


--
-- TOC entry 208 (class 1259 OID 24668)
-- Name: trajet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.trajet (
    ville_depart character varying,
    ville_arrivee character varying,
    adresse_depart character varying,
    adresse_arrivee character varying,
    longitude_depart character varying,
    longitude_arrivee character varying,
    lattitude_depart character varying,
    lattitude_arrivee character varying,
    id_conducteur integer,
    type character varying,
    jour_depart character varying,
    mois_depart character varying,
    annee_depart character varying,
    heure_depart character varying,
    minute_depart character varying,
    cp_arrivee character varying,
    cp_depart character varying,
    id_trajet integer NOT NULL,
    nombre_place integer,
    nombre_place_validee integer
);


ALTER TABLE public.trajet OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 24687)
-- Name: trajet_idTrajet_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."trajet_idTrajet_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."trajet_idTrajet_seq" OWNER TO postgres;

--
-- TOC entry 2888 (class 0 OID 0)
-- Dependencies: 209
-- Name: trajet_idTrajet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public."trajet_idTrajet_seq" OWNED BY public.trajet.id_trajet;


--
-- TOC entry 202 (class 1259 OID 16557)
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utilisateur (
    nom character varying NOT NULL,
    prenom character varying,
    tel character varying,
    mail character varying,
    pwd character varying,
    id_utilisateur integer NOT NULL,
    droit integer,
    modele_voiture character varying,
    profil character varying
);


ALTER TABLE public.utilisateur OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 16565)
-- Name: utilisateur_id_utilisateur_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.utilisateur_id_utilisateur_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_id_utilisateur_seq OWNER TO postgres;

--
-- TOC entry 2889 (class 0 OID 0)
-- Dependencies: 203
-- Name: utilisateur_id_utilisateur_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.utilisateur_id_utilisateur_seq OWNED BY public.utilisateur.id_utilisateur;


--
-- TOC entry 2727 (class 2604 OID 24715)
-- Name: commentaire id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commentaire ALTER COLUMN id SET DEFAULT nextval('public.commentaire_id_seq'::regclass);


--
-- TOC entry 2725 (class 2604 OID 16604)
-- Name: mairie id_lieu; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mairie ALTER COLUMN id_lieu SET DEFAULT nextval('public.mairie_id_lieu_seq'::regclass);


--
-- TOC entry 2724 (class 2604 OID 16582)
-- Name: pwdReset idReset; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."pwdReset" ALTER COLUMN "idReset" SET DEFAULT nextval('public."pwdReset_idReset_seq"'::regclass);


--
-- TOC entry 2728 (class 2604 OID 24726)
-- Name: reservation_trajet id_reservation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation_trajet ALTER COLUMN id_reservation SET DEFAULT nextval('public.reservation_trajet_id_reservation_seq'::regclass);


--
-- TOC entry 2726 (class 2604 OID 24689)
-- Name: trajet id_trajet; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.trajet ALTER COLUMN id_trajet SET DEFAULT nextval('public."trajet_idTrajet_seq"'::regclass);


--
-- TOC entry 2723 (class 2604 OID 16567)
-- Name: utilisateur id_utilisateur; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur ALTER COLUMN id_utilisateur SET DEFAULT nextval('public.utilisateur_id_utilisateur_seq'::regclass);


--
-- TOC entry 2876 (class 0 OID 24712)
-- Dependencies: 211
-- Data for Name: commentaire; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.commentaire (commentaire, id, id_personne, id_trajet) FROM stdin;
est-ce que vous réalisez toujours le trajet ?	57	40	52
\.


--
-- TOC entry 2872 (class 0 OID 16601)
-- Dependencies: 207
-- Data for Name: mairie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mairie (id_lieu, nom_lieu) FROM stdin;
1	mairie
2	La poste
3	Boulangerie
\.


--
-- TOC entry 2870 (class 0 OID 16579)
-- Dependencies: 205
-- Data for Name: pwdReset; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."pwdReset" ("idReset", "resetEmail", "resetSelector", "resetToken", "resetExpires") FROM stdin;
5	miccicheluca@live.fr	bafda4066c19e06c	$2y$10$2FVKEibl9FHPkGy/1h5iiOr4uR4h4j74isA0GEwEEhE0HdmUaMVOy	1589202908
\.


--
-- TOC entry 2878 (class 0 OID 24723)
-- Dependencies: 213
-- Data for Name: reservation_trajet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservation_trajet (id_reservation, id_conducteur, id_passager, id_trajet, nombre_place_reserve, trajet_key, confirm_trajet) FROM stdin;
55	39	40	52	2	E!Pp	\N
56	39	40	52	1	BgQn	\N
57	40	39	54	1	oqaV	\N
58	39	40	53	2	\N	\N
\.


--
-- TOC entry 2873 (class 0 OID 24668)
-- Dependencies: 208
-- Data for Name: trajet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.trajet (ville_depart, ville_arrivee, adresse_depart, adresse_arrivee, longitude_depart, longitude_arrivee, lattitude_depart, lattitude_arrivee, id_conducteur, type, jour_depart, mois_depart, annee_depart, heure_depart, minute_depart, cp_arrivee, cp_depart, id_trajet, nombre_place, nombre_place_validee) FROM stdin;
ECROUVES	Nancy	81 rue jean moulin	place stanislas	5.8701143	6.183286148848685	48.6738881	48.69352445	40	proposition	14	5	2020	12	00	54000	54120	54	1	0
ECROUVES	Nancy	81 rue jean moulin	rue gambetta	5.8701143	6.1800115	48.6738881	48.692054	40	demande	12	6	2021	13	00	54000	54120	53	0	\N
Sens	Nancy	14 boulevard du centenaire	rue gambetta	3.2773664	6.1800115	48.2033168	48.692054	39	proposition	17	12	2020	20	00	54000	89100 	58	1	0
Sens	Sens	14 boulevard du centenaire	14 boulevard du centenaire	3.2773664	3.2773664	48.2033168	48.2033168	2	proposition	16	12	2020	17	30	89100	89100	51	2	0
Sens	Nailly	14 boulevard du centenaire	2 grande rue	3.2773664	3.2212379	48.2033168	48.2234801	40	demande	13	10	2020	14	00	89100	89100 	55	1	\N
Nailly	Sens	2 grande rue	14 boulevard du centenaire	3.2212379	3.2773664	48.2234801	48.2033168	40	proposition	16	5	2020	16	00	89100 	89100	56	2	0
Nailly	Sens	2 grande rue	14 boulevard du centenaire	3.2212379	3.2773664	48.2234801	48.2033168	39	proposition	16	5	2020	16	00	89100 	89100	57	2	0
Sens	Nailly	14 boulevard du centenaire	2 grande rue 	3.2773664	3.2212379	48.2033168	48.2234801	39	proposition	16	11	2020	11	00	89100 	89100 	52	1	0
\.


--
-- TOC entry 2867 (class 0 OID 16557)
-- Dependencies: 202
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.utilisateur (nom, prenom, tel, mail, pwd, id_utilisateur, droit, modele_voiture, profil) FROM stdin;
Micciche	Luca	0687216695	allezretourevry@gmail.com	$2y$10$rzUCAXJH3.DbWwVcCW8GKOL7o8o9rbOrUsLPb7gLiTqndJKcdxm/.	40	1	\N	vide
Micciche	Luca	0687216695	admin@gmail.com	$2y$10$.iREjLj5p6wLQoKV.y6Jze5l2PeshQASTlS/eATZFJTEiAc9JNmFy	39	3	\N	vide
\.


--
-- TOC entry 2890 (class 0 OID 0)
-- Dependencies: 210
-- Name: commentaire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.commentaire_id_seq', 57, true);


--
-- TOC entry 2891 (class 0 OID 0)
-- Dependencies: 206
-- Name: mairie_id_lieu_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.mairie_id_lieu_seq', 3, true);


--
-- TOC entry 2892 (class 0 OID 0)
-- Dependencies: 204
-- Name: pwdReset_idReset_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."pwdReset_idReset_seq"', 5, true);


--
-- TOC entry 2893 (class 0 OID 0)
-- Dependencies: 212
-- Name: reservation_trajet_id_reservation_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reservation_trajet_id_reservation_seq', 58, true);


--
-- TOC entry 2894 (class 0 OID 0)
-- Dependencies: 209
-- Name: trajet_idTrajet_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."trajet_idTrajet_seq"', 58, true);


--
-- TOC entry 2895 (class 0 OID 0)
-- Dependencies: 203
-- Name: utilisateur_id_utilisateur_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.utilisateur_id_utilisateur_seq', 40, true);


--
-- TOC entry 2738 (class 2606 OID 24720)
-- Name: commentaire commentaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commentaire
    ADD CONSTRAINT commentaire_pkey PRIMARY KEY (id);


--
-- TOC entry 2734 (class 2606 OID 16606)
-- Name: mairie mairie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mairie
    ADD CONSTRAINT mairie_pkey PRIMARY KEY (id_lieu);


--
-- TOC entry 2730 (class 2606 OID 16576)
-- Name: utilisateur pk_id; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT pk_id PRIMARY KEY (id_utilisateur);


--
-- TOC entry 2736 (class 2606 OID 24697)
-- Name: trajet pkey_trajet; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.trajet
    ADD CONSTRAINT pkey_trajet PRIMARY KEY (id_trajet);


--
-- TOC entry 2732 (class 2606 OID 16584)
-- Name: pwdReset pwdReset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."pwdReset"
    ADD CONSTRAINT "pwdReset_pkey" PRIMARY KEY ("idReset");


--
-- TOC entry 2740 (class 2606 OID 24728)
-- Name: reservation_trajet reservation_trajet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation_trajet
    ADD CONSTRAINT reservation_trajet_pkey PRIMARY KEY (id_reservation);


-- Completed on 2020-05-13 01:29:15

--
-- PostgreSQL database dump complete
--

