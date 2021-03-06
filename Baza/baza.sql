
CREATE TABLE [Administrator]
( 
	[IdKorisnik]         integer  NOT NULL ,
	CONSTRAINT [XPKAdministrator] PRIMARY KEY  CLUSTERED ([IdKorisnik] ASC)
)
go

CREATE TABLE [Drzava]
( 
	[IdDrzava]           integer  NOT NULL ,
	[Naziv]              varchar(20)  NULL ,
	CONSTRAINT [XPKDrzava] PRIMARY KEY  CLUSTERED ([IdDrzava] ASC)
)
go

CREATE TABLE [Grad]
( 
	[IdDrzava]           integer  NOT NULL ,
	[IdGrad]             integer  NOT NULL ,
	[Naziv]              varchar(20)  NULL ,
	CONSTRAINT [XPKGrad] PRIMARY KEY  CLUSTERED ([IdGrad] ASC)
)
go

CREATE TABLE [Gurman]
( 
	[IdKorisnik]         integer  NOT NULL ,
	[Ime]                varchar(20)  NULL ,
	[Prezime]            varchar(20)  NULL ,
	[Pol]                char  NULL 
	CONSTRAINT [Ogranicenje_Pol_996175236]
		CHECK  ( [Pol]='M' OR [Pol]='Z' ),
	[IdSlika]            integer  NOT NULL ,
	CONSTRAINT [XPKGurman] PRIMARY KEY  CLUSTERED ([IdKorisnik] ASC)
)
go

CREATE TABLE [Ima_Sastojak]
( 
	[IdJelo]             integer  NOT NULL ,
	[IdSastojak]         integer  NOT NULL ,
	CONSTRAINT [XPKIma_Sastojak] PRIMARY KEY  CLUSTERED ([IdJelo] ASC,[IdSastojak] ASC)
)
go

CREATE TABLE [Jelo]
( 
	[Naziv]              varchar(30)  NULL ,
	[Opis]               varchar(250)  NULL ,
	[IdJelo]             integer  NOT NULL ,
	[IdKorisnik]         integer  NOT NULL ,
	[IdSlika]            integer  NOT NULL ,
	[Pregledano]         char  NULL 
	CONSTRAINT [Ogranicenje_Pregledano_2057014714]
		CHECK  ( [Pregledano]='P' OR [Pregledano]='N' ),
	CONSTRAINT [XPKJelo] PRIMARY KEY  CLUSTERED ([IdJelo] ASC)
)
go

CREATE TABLE [Korisnik]
( 
	[IdKorisnik]         integer  NOT NULL ,
	[KorisnickoIme]      varchar(20)  NULL ,
	[Lozinka]            varchar(20)  NULL ,
	[Email]              varchar(30)  NULL ,
	CONSTRAINT [XPKKorisnik] PRIMARY KEY  CLUSTERED ([IdKorisnik] ASC)
)
go

CREATE TABLE [Recenzija]
( 
	[IdKorisnik]         integer  NOT NULL ,
	[Ocena]              integer  NULL 
	CONSTRAINT [Ogranicenje_Ocena_734976756]
		CHECK  ( Ocena BETWEEN 1 AND 5 ),
	[Komentar]           varchar(250)  NULL ,
	[IdJelo]             integer  NOT NULL ,
	[Pregledano]         char  NULL 
	CONSTRAINT [Ogranicenje_Pregledano_268628333]
		CHECK  ( [Pregledano]='P' OR [Pregledano]='N' ),
	CONSTRAINT [XPKRecenzija] PRIMARY KEY  CLUSTERED ([IdJelo] ASC,[IdKorisnik] ASC)
)
go

CREATE TABLE [Restoran]
( 
	[IdKorisnik]         integer  NOT NULL ,
	[Telefon]            varchar(20)  NULL ,
	[Naziv]              varchar(30)  NULL ,
	[Adresa]             varchar(30)  NULL ,
	[IdGrad]             integer  NOT NULL ,
	[IdSlika]            integer  NOT NULL ,
	[RadnoVreme]         varchar(200)  NULL ,
	[Pregledano]         char  NULL 
	CONSTRAINT [Ogranicenje_Pregledano_233966035]
		CHECK  ( [Pregledano]='P' OR [Pregledano]='N' ),
	CONSTRAINT [XPKRestoran] PRIMARY KEY  CLUSTERED ([IdKorisnik] ASC)
)
go

CREATE TABLE [Sastojak]
( 
	[IdSastojak]         integer  NOT NULL ,
	[Naziv]              varchar(20)  NULL ,
	CONSTRAINT [XPKSastojak] PRIMARY KEY  CLUSTERED ([IdSastojak] ASC)
)
go

CREATE TABLE [Slika]
( 
	[IdSlika]            integer  NOT NULL ,
	[Putanja]            varchar(300)  NULL ,
	CONSTRAINT [XPKSlika] PRIMARY KEY  CLUSTERED ([IdSlika] ASC)
)
go


ALTER TABLE [Administrator]
	ADD CONSTRAINT [R_3] FOREIGN KEY ([IdKorisnik]) REFERENCES [Korisnik]([IdKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Grad]
	ADD CONSTRAINT [R_9] FOREIGN KEY ([IdDrzava]) REFERENCES [Drzava]([IdDrzava])
		ON DELETE NO ACTION
		ON UPDATE CASCADE
go


ALTER TABLE [Gurman]
	ADD CONSTRAINT [R_2] FOREIGN KEY ([IdKorisnik]) REFERENCES [Korisnik]([IdKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Gurman]
	ADD CONSTRAINT [R_12] FOREIGN KEY ([IdSlika]) REFERENCES [Slika]([IdSlika])
		ON DELETE SET NULL
		ON UPDATE CASCADE
go


ALTER TABLE [Ima_Sastojak]
	ADD CONSTRAINT [R_14] FOREIGN KEY ([IdJelo]) REFERENCES [Jelo]([IdJelo])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Ima_Sastojak]
	ADD CONSTRAINT [R_15] FOREIGN KEY ([IdSastojak]) REFERENCES [Sastojak]([IdSastojak])
		ON DELETE NO ACTION
		ON UPDATE CASCADE
go


ALTER TABLE [Jelo]
	ADD CONSTRAINT [R_5] FOREIGN KEY ([IdKorisnik]) REFERENCES [Restoran]([IdKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Jelo]
	ADD CONSTRAINT [R_13] FOREIGN KEY ([IdSlika]) REFERENCES [Slika]([IdSlika])
		ON DELETE SET NULL
		ON UPDATE CASCADE
go


ALTER TABLE [Recenzija]
	ADD CONSTRAINT [R_7] FOREIGN KEY ([IdKorisnik]) REFERENCES [Gurman]([IdKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Recenzija]
	ADD CONSTRAINT [R_8] FOREIGN KEY ([IdJelo]) REFERENCES [Jelo]([IdJelo])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go


ALTER TABLE [Restoran]
	ADD CONSTRAINT [R_1] FOREIGN KEY ([IdKorisnik]) REFERENCES [Korisnik]([IdKorisnik])
		ON DELETE CASCADE
		ON UPDATE CASCADE
go

ALTER TABLE [Restoran]
	ADD CONSTRAINT [R_10] FOREIGN KEY ([IdGrad]) REFERENCES [Grad]([IdGrad])
		ON DELETE NO ACTION
		ON UPDATE CASCADE
go

ALTER TABLE [Restoran]
	ADD CONSTRAINT [R_11] FOREIGN KEY ([IdSlika]) REFERENCES [Slika]([IdSlika])
		ON DELETE SET NULL
		ON UPDATE CASCADE
go
