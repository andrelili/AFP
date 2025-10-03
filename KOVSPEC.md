# Követelmény specifikáció

## Áttekintés
Az alkalmazás célja egy modern, reszponzív online bútorwebshop létrehozása, amely egyszerűen használható a vásárlók számára. Az oldalon böngészhetnek különböző bútor kategóriák között (pl. nappali, hálószoba, fürdőszoba), részletes termékleírásokat és képeket tekinthetnek meg, kosárba helyezhetik a termékeket, majd rendelést adhatnak le.  

A projekt két fázisban valósul meg:  
1. **Kis projekt (prototípus)** – kosár működésének megvalósítása adatbázis nélkül.  
2. **Teljes webshop** – adatbázisra épülő, felhasználói fiókokkal és admin felülettel rendelkező rendszer.  

---

## A jelenlegi helyzet leírása
A webshop ötletét a fejlesztőcsapat kapta megbízásként azzal a céllal, hogy egy korszerű és felhasználóbarát online áruházat hozzanak létre. A jelenlegi piacon több nagy szereplő is kínál bútorokat weben keresztül, azonban a felhasználók gyakran tapasztalnak átláthatatlan kezelőfelületet és lassú működést. A cél egy olyan webshop létrehozása, amely letisztult, gyors, egyszerű és minden modern igénynek megfelel.  

---

## Vágyalomrendszer
A végső cél egy **minden eszközről elérhető, reszponzív és biztonságos** bútorwebshop.  
- **Technológiák**: Frontend (HTML, CSS, JavaScript), Backend (PHP), Adatbázis (MySQL).  
- **Platformfüggetlenség**: böngészőből telepítés nélkül elérhető.  
- **Felhasználói szerepkörök**:  
  - **Admin** – termékek, kategóriák, rendelések és felhasználók kezelése.  
  - **Vásárló** – regisztráció után kosárba tehet termékeket és rendelést adhat le.  
  - **Látogató** – böngészhet, de vásárláshoz be kell jelentkeznie.  

---

## A jelenlegi üzleti folyamatok modellje
- **Kosár működése**: a felhasználó böngészés közben kosárba tudja helyezni a termékeket, majd mennyiséget módosítani vagy törölni azokat.  
- **Statikus terméklista**: az első fázisban előre megadott termékek listájából választhatnak a látogatók.  
- **Egyszerű rendelés gomb**: jelezni lehet a vásárlási szándékot, de tényleges rendelés feldolgozás még nincs.  

---

## Igényelt üzleti folyamatok modellje
- **Felhasználói fiókok kezelése**: regisztráció, bejelentkezés, profil adatok módosítása.  
- **Kosár és rendelés**: termékek kosárba helyezése, kosár mentése adatbázisba, rendelés leadása.  
- **Értékelési rendszer**: vásárlók a megvásárolt termékeket 0–5 csillaggal és szöveges kommenttel értékelhetik.  
- **Admin funkciók**: új termékek és kategóriák felvétele, készletmódosítás, rendelések státuszának kezelése.  
- **Keresés és szűrés**: kategória, ár és népszerűség alapján.  

---

## Követelménylista

| Id  | Modul          | Név                  | Leírás |
|-----|----------------|----------------------|--------|
| K1  | Felület        | Termékek listázása   | A felhasználók kategóriák szerint böngészhetik a termékeket, megtekinthetik részletes leírásukat és képeiket. |
| K2  | Felület        | Kosár                | Termékek kosárba helyezése, mennyiség növelése/csökkentése, törlés, végösszeg megtekintése. |
| K3  | Felület        | Rendelés leadása     | A kosár tartalmának rögzítése, rendelés elküldése (adatbázisba mentve a 2. fázisban). |
| K4  | Felület        | Regisztráció         | Vásárlók regisztrációja a rendszerbe felhasználónév, jelszó és e-mail segítségével. |
| K5  | Felület        | Bejelentkezés        | A vásárlók bejelentkezhetnek a saját fiókjukba, hogy rendelést adhassanak le. |
| K6  | Felület        | Profil               | A felhasználók saját adataikat és korábbi rendeléseiket megtekinthetik és szerkeszthetik. |
| K7  | Modifikáció    | Jelszókezelés        | Elfelejtett jelszó esetén jelszó visszaállítás, jelszó módosítása. |
| K8  | Funkcionalitás | Értékelés            | A vásárlók csillagos értékelést és szöveges visszajelzést adhatnak a termékekhez. |
| K9  | Funkcionalitás | Keresés és szűrés    | Termékek keresése név alapján, szűrés kategória, ár vagy népszerűség szerint. |
| K10 | Jogosultság    | Admin felület        | Adminisztrátorok hozzáférése termékek, kategóriák, felhasználók és rendelések kezeléséhez. |

---

## Fogalomtár
- **KOSÁR** – ide gyűjtik a felhasználók a megvásárolni kívánt termékeket.  
- **RENDELÉS** – a kosár tartalmának véglegesítése és elküldése az adminisztrátor számára feldolgozásra.  
- **ADMIN** – az oldal tartalmát kezelő felhasználó (termékek, kategóriák, felhasználók, rendelések).  
- **VÁSÁRLÓ** – regisztrált felhasználó, aki rendelést adhat le.  
- **LÁTOGATÓ** – regisztráció nélküli felhasználó, aki csak böngészhet.  
- **ÉRTÉKELÉS** – vásárlók által adott csillagos és szöveges visszajelzés egy termékről.  
- **KATEGÓRIA** – a termékek logikai csoportosítása (pl. nappali, hálószoba, fürdőszoba).  

---

### Ábra – Use-case diagram
<img width="487" height="708" alt="Image" src="https://github.com/user-attachments/assets/9e78404b-4cf6-4773-a84d-ed350a311c81" />
