CREATE TABLE RSS (
    id integer primary key autoincrement,
    titre varchar(255),
    url varchar(255),
    date timestamp
);

CREATE TABLE nouvelle (
    id integer primary key autoincrement,
    date datetime,
    titre varchar(255),
    description varchar(1024),
    url varchar(255),
    urlImage varchar(80),
    RSS_id integer
);

CREATE TABLE utilisateur (
    login varchar(80) primary key,
    mp varchar(8)
);

CREATE TABLE abonnement (
    utilisateur_login varchar(10),
    RSS_id integer,
    nom varchar(40),
    categorie varchar(40),
    primary key (utilisateur_login,RSS_id)
);