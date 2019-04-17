
CREATE TABLE Administrator
(
	IdKorisnik           INTEGER NOT NULL,
	CONSTRAINT XPKAdministrator PRIMARY KEY (IdKorisnik)
);

CREATE TABLE Drzava
(
	IdDrzava             INTEGER NOT NULL,
	Naziv                VARCHAR(20) NULL,
	CONSTRAINT XPKDrzava PRIMARY KEY (IdDrzava)
);

CREATE TABLE Grad
(
	IdDrzava             INTEGER NOT NULL,
	IdGrad               INTEGER NOT NULL,
	Naziv                VARCHAR(20) NULL,
	CONSTRAINT XPKGrad PRIMARY KEY (IdGrad)
);

CREATE TABLE Gurman
(
	IdKorisnik           INTEGER NOT NULL,
	Ime                  VARCHAR(20) NULL,
	Prezime              VARCHAR(20) NULL,
	Pol                  CHAR NULL CHECK ( Pol IN ('M', 'Z') ),
	IdSlika              INTEGER NOT NULL,
	CONSTRAINT XPKGurman PRIMARY KEY (IdKorisnik)
);

CREATE TABLE Ima_Sastojak
(
	IdJelo               INTEGER NOT NULL,
	IdSastojak           INTEGER NOT NULL,
	CONSTRAINT XPKIma_Sastojak PRIMARY KEY (IdJelo,IdSastojak)
);

CREATE TABLE Jelo
(
	Naziv                VARCHAR(30) NULL,
	Opis                 VARCHAR(250) NULL,
	IdJelo               INTEGER NOT NULL,
	IdKorisnik           INTEGER NOT NULL,
	IdSlika              INTEGER NOT NULL,
	Pregledano           CHAR NULL CHECK ( Pregledano IN ('P', 'N') ),
	CONSTRAINT XPKJelo PRIMARY KEY (IdJelo)
);

CREATE TABLE Korisnik
(
	IdKorisnik           INTEGER NOT NULL,
	KorisnickoIme        VARCHAR(20) NULL,
	Lozinka              VARCHAR(20) NULL,
	Email                VARCHAR(30) NULL,
	CONSTRAINT XPKKorisnik PRIMARY KEY (IdKorisnik)
);

CREATE TABLE Recenzija
(
	IdKorisnik           INTEGER NOT NULL,
	Ocena                INTEGER NULL CHECK ( Ocena BETWEEN 1 AND 5 ),
	Komentar             VARCHAR(250) NULL,
	IdJelo               INTEGER NOT NULL,
	Pregledano           CHAR NULL CHECK ( Pregledano IN ('P', 'N') ),
	CONSTRAINT XPKRecenzija PRIMARY KEY (IdJelo,IdKorisnik)
);

CREATE TABLE Restoran
(
	IdKorisnik           INTEGER NOT NULL,
	Telefon              VARCHAR(20) NULL,
	Naziv                VARCHAR(30) NULL,
	Adresa               VARCHAR(30) NULL,
	IdGrad               INTEGER NOT NULL,
	IdSlika              INTEGER NOT NULL,
	RadnoVreme           VARCHAR(200) NULL,
	Pregledano           CHAR NULL CHECK ( Pregledano IN ('P', 'N') ),
	CONSTRAINT XPKRestoran PRIMARY KEY (IdKorisnik)
);

CREATE TABLE Sastojak
(
	IdSastojak           INTEGER NOT NULL,
	Naziv                VARCHAR(20) NULL,
	CONSTRAINT XPKSastojak PRIMARY KEY (IdSastojak)
);

CREATE TABLE Slika
(
	IdSlika              INTEGER NOT NULL,
	Putanja              varchar(300) NULL,
	CONSTRAINT XPKSlika PRIMARY KEY (IdSlika)
);

ALTER TABLE Administrator
ADD CONSTRAINT R_3 FOREIGN KEY (IdKorisnik) REFERENCES Korisnik (IdKorisnik)
		ON DELETE CASCADE;

ALTER TABLE Grad
ADD CONSTRAINT R_9 FOREIGN KEY (IdDrzava) REFERENCES Drzava (IdDrzava);

ALTER TABLE Gurman
ADD CONSTRAINT R_2 FOREIGN KEY (IdKorisnik) REFERENCES Korisnik (IdKorisnik)
		ON DELETE CASCADE;

ALTER TABLE Gurman
ADD CONSTRAINT R_12 FOREIGN KEY (IdSlika) REFERENCES Slika (IdSlika);

ALTER TABLE Ima_Sastojak
ADD CONSTRAINT R_14 FOREIGN KEY (IdJelo) REFERENCES Jelo (IdJelo)
		ON DELETE CASCADE;

ALTER TABLE Ima_Sastojak
ADD CONSTRAINT R_15 FOREIGN KEY (IdSastojak) REFERENCES Sastojak (IdSastojak)
		ON DELETE CASCADE;

ALTER TABLE Jelo
ADD CONSTRAINT R_5 FOREIGN KEY (IdKorisnik) REFERENCES Restoran (IdKorisnik);

ALTER TABLE Jelo
ADD CONSTRAINT R_13 FOREIGN KEY (IdSlika) REFERENCES Slika (IdSlika);

ALTER TABLE Recenzija
ADD CONSTRAINT R_7 FOREIGN KEY (IdKorisnik) REFERENCES Gurman (IdKorisnik);

ALTER TABLE Recenzija
ADD CONSTRAINT R_8 FOREIGN KEY (IdJelo) REFERENCES Jelo (IdJelo);

ALTER TABLE Restoran
ADD CONSTRAINT R_1 FOREIGN KEY (IdKorisnik) REFERENCES Korisnik (IdKorisnik)
		ON DELETE CASCADE;

ALTER TABLE Restoran
ADD CONSTRAINT R_10 FOREIGN KEY (IdGrad) REFERENCES Grad (IdGrad);

ALTER TABLE Restoran
ADD CONSTRAINT R_11 FOREIGN KEY (IdSlika) REFERENCES Slika (IdSlika);
