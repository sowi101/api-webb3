# Projekt i Webbutveckling III (DT173G) webbtjänst/API
I detta respitory finns flera API byggt i PHP som har skapats under projektarbetet i kursen Webbutveckling III på Mittuniversitetet. API:na kan användas för att hantera menyer och bokningar för en restaurang samt kontrollera inloggning. För meny och bokningar finns funktionalitet för CRUD, det vill säga skapa, läsa, uppdatera och radera.

## Länkar till existerande versioner
Meny-API: [https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php](https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/menuapi.php)

Boknings-API: [https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php](https://studenter.miun.se/~sowi2102/writeable/dt173g/projekt/webservice/bookingapi.php)

Login används bara för att kontrollera inloggning och innehåller därför inget visuellt att visa.

## Installation
För att börja använda API:et behöver filerna kopieras till en webbserver. Kör sedan installationsscripten i filen install.php för att skapa de tabeller som API:na behöver för att kunna användas. För att kunna använda API:et login behöver användarnamn och ett hashat lösenord läggas in via phpmyadmin manuellt.

| Tabellnamn| Fält |
| ----------- | ----------- |
| menu | **id** (int(11)), **name** (varchar(70)), **price** (int(4)), **description** (text), **category** (varchar(50)), **subcategory** (varchar(50)) |
| bookings | **id** (int(11)), **firstname** (varchar(50)), **lastname** (varchar(50)), **email** (varchar(70)), **phonenum** (varchar(20)), **request** (text), **date** (varchar(20)), **time** (varchar(10)), **guests** (int(11)), **saved** (timestamp, current_timestamp) |
| user | **id** (int(11)), **username** (varchar(70)), **lastname** (varchar(256)) |


## Klasser och metoder

### Menu
#### Properties
- **db**: MySQLi-anslutning
- **name**: namn på rätt/dryck
- **price**: pris på rätt/dryck
- **description**: beskrivning av rätt/dryckcategory: rätt eller dryck
- **subcategory**: typ av rätt/dryck

#### Metoder
- **constructor**: etablering av databasanslutning.
- **setMenuItem** (string name, int price, string description, string category, string subcategory): set-metod som saniterar, kontrollerar och binder inkommande data till ett objekt.
- **getMenuItems**: array - get-metod som hämtar alla rader i tabellen.
- **getMenuItemById** (int id): array - get-metod som hämtar en angiven rad i tabellen.
- **saveMenuItem**: bool - metod som lagrar rad i tabellen.
- **updateMenuItem** (int id): bool - metod som uppdaterar angiven rad i tabellen.
- **deleteMenuItem** (int id): bool - metod som raderar angiven rad från tabellen.
- **destructor**: stänger databasanslutningen.


### Booking
#### Properties
- **db**: MySQLi-anslutning
- **firstname**: förnamn på den som bokar.
- **lastname**: efternamn på den som bokar.
- **email**: email till den som bokar.
- **phonenum**: telefonnummer till den som bokar.
- **request**: allergier eller önskemål den som bokar vill informera om.
- **date**: datum för önskad bokning.
- **time**: tid för önskad bokning.
- **guests**: antal gäster för bokningen.

#### Metoder
- **constructor**: etablering av databasanslutning.
- **setBooking** (string firstname, string lastname, string email, string phonenum, string request, string date, string time, int guests): bool - set-metod som saniterar, kontrollerar och binder inkommande data till ett objekt.
- **getBookings**: array - get-metod som hämtar alla rader i tabellen.
- **getBookingById** (int id): array - get-metod som hämtar en angiven rad i tabellen.
- **saveBooking**: bool - metod som lagrar rad i tabellen.
- **updateBooking** (int id): bool - metod som uppdaterar angiven rad i tabellen.
- **deleteBooking** (int id): bool - metod som raderar angiven rad från tabellen.
- **destructor**: stänger databasanslutningen.

### User
#### Properties
- **db**: MySQLi-anslutning
- **username**: användarnamn
- **password**: lösenord

#### Metoder
- **constructor**: etablering av databasanslutning.
- **setUser** (string username, string password: bool - set-metod som saniterar, kontrollerar och binder inkommande data till ett objekt.
- **logIn**: bool - metod som jämför angivet användarnamn och lösenord med de rader som finns sparade i tabellen.
- **destructor**: stänger databasanslutningen.

## Användning

### menuapi.php
| Metod | Ändpunkt | Beskrivning |
| ----------- | ----------- | ----------- |
| GET | /menuapi.php | Hämtar alla rätter och drycker. |
| GET | /menuapi.php?id=[id] | Hämtar rätt/dryck med angivet ID. |
| POST | /menuapi.php | Lagrar ny rätt/dryck, ett menyobjekt måste skickas med. |
| PUT | /menuapi.php?id=[id] | Uppdaterar existerande rätt/dryck med angivet ID, ett menyobjekt måste skickas med. |
| DELETE | /menuapi.php?id=[id] | Raderar rätt/dryck med angivet ID. |

Ett menyobjekt skickas eller returneras på följande sätt:

```json
{
  "name": "Laxsoppa",
  "price": 175,
  "description": "Lax, potatis, morötter, grädde, tomat, grädde",
  "category": "Maträtt",
  "subcategory": "Huvudrätt"
}
```

### bookingapi.php
| Metod | Ändpunkt | Beskrivning |
| ----------- | ----------- | ----------- |
| GET | /bookingapi.php | Hämtar alla bokningar. |
| GET | /bookingapi.php?id=[id] | Hämtar bokning med angivet ID. |
| POST | /bookingapi.php | Lagrar ny bokning, ett bokningsobjekt måste skickas med. |
| PUT | /bookingapi.php?id=[id] | Uppdaterar existerande bokning med angivet ID, ett bokningsobjekt måste skickas med. |
| DELETE | /bookingapi.php?id=[id] | Raderar bokning med angivet ID. |

Ett bokningsobjekt skickas eller returneras på följande sätt:

```json
{
  "firstname": "Anna",
  "lastname": "Andersson",
  "email": "anna.anderson@live.com",
  "phonenum": "0700000000",
  "request": "Vill sitta vid fönster.",
  "date": "2022-06-02",
  "time": "19:00",
  "guests": 4
}
```

### login.php
| Metod | Ändpunkt | Beskrivning |
| ----------- | ----------- | ----------- |
| POST | /login.php | Kontrollerar inloggning, ett användarobjekt måste skickas med.|

Ett användarobjekt skickas på följande sätt:

```json
{
  "username": "Användarnamn",
  "password": "lösenord",
}
```

Vid korrekt inloggning skickar API:et en respons i form av en array innehållandes nyckeln user_correct och boolvärdet true. Vid inkorrekt inloggning skickar API:et en respons i form av en array innehållande nyckel message och ett meddelande som kan skrivas ut. 
