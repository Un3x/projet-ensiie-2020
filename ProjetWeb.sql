PGDMP     3    
                x         	   ProjetWeb    12.2    12.2                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16393 	   ProjetWeb    DATABASE     �   CREATE DATABASE "ProjetWeb" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Chinese (Simplified)_China.936' LC_CTYPE = 'Chinese (Simplified)_China.936';
    DROP DATABASE "ProjetWeb";
                postgres    false            �            1259    16469    bateau    TABLE     �   CREATE TABLE public.bateau (
    objet text NOT NULL,
    description text,
    owner text NOT NULL,
    email text,
    address text,
    date text,
    bid integer NOT NULL
);
    DROP TABLE public.bateau;
       public         heap    postgres    false            �            1259    16508    bateau_bid_seq    SEQUENCE     �   CREATE SEQUENCE public.bateau_bid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.bateau_bid_seq;
       public          postgres    false    203                       0    0    bateau_bid_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.bateau_bid_seq OWNED BY public.bateau.bid;
          public          postgres    false    204            �            1259    16453    member    TABLE     �   CREATE TABLE public.member (
    id integer NOT NULL,
    name text NOT NULL,
    pwd text NOT NULL,
    email text,
    address text
);
    DROP TABLE public.member;
       public         heap    postgres    false            �
           2604    16510 
   bateau bid    DEFAULT     h   ALTER TABLE ONLY public.bateau ALTER COLUMN bid SET DEFAULT nextval('public.bateau_bid_seq'::regclass);
 9   ALTER TABLE public.bateau ALTER COLUMN bid DROP DEFAULT;
       public          postgres    false    204    203            	          0    16469    bateau 
   TABLE DATA           V   COPY public.bateau (objet, description, owner, email, address, date, bid) FROM stdin;
    public          postgres    false    203   �                 0    16453    member 
   TABLE DATA           ?   COPY public.member (id, name, pwd, email, address) FROM stdin;
    public          postgres    false    202   j                  0    0    bateau_bid_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.bateau_bid_seq', 15, true);
          public          postgres    false    204            �
           2606    16518    bateau bateau_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY public.bateau
    ADD CONSTRAINT bateau_pkey PRIMARY KEY (bid);
 <   ALTER TABLE ONLY public.bateau DROP CONSTRAINT bateau_pkey;
       public            postgres    false    203            �
           2606    16460    member test_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.member
    ADD CONSTRAINT test_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.member DROP CONSTRAINT test_pkey;
       public            postgres    false    202            	   q   x���/M-R(�SHJ,IM,��S(H-UHI���̂���<��`� C����"C��������\΀Ģ�b��ļ�TNCc]S]# ��9#�(9�H���a�	W� G8i         Z   x�3�v2�442615�,-N-2tH�M���K���H,�,�Qp+J�KN�2+6BVl�S�1gJjn>Lmq^P�I���BQi*W� 9�&�     