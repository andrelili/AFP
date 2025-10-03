# Funkcionális specifikáció

## Jelenlegi helyzet leírása
A fejlesztőcsapat megbízást kapott egy korszerű, letisztult és könnyen használható online bútorwebshop létrehozására.  
A jelenlegi piacon több nagy szereplő is kínál bútorokat online, azonban ezek sok esetben lassúak, átláthatatlanok, és nem minden eszközről kényelmes a használatuk.  
A cél egy modern, reszponzív, gyors működésű rendszer, amely egyszerűen elérhető böngészőből telepítés nélkül.  

A projekt *két fázisban* kerül megvalósításra:
1. **Kis projekt (prototípus)** – adatbázis nélküli kosárfunkció.
2. **Teljes webshop** – adatbázissal, felhasználói fiókokkal és admin felülettel.

---

## Vágyalomrendszer leírása
A végső rendszer egy lokális gépen futó, böngészőből elérhető bútorwebshop, amely reszponzív és biztonságos működést biztosít. A rendszer telepítéséhez XAMPP (Apache + MySQL + PHP) szükséges, amelyen keresztül a webshop futtatható.

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Adatbázis:** MySQL (XAMPP + phpMyAdmin) 

### Szerepkörök
- **Admin** – termékek, kategóriák, rendelések és felhasználók kezelése  
- **Vásárló** – regisztráció után kosárba tehet termékeket és rendelést adhat le  
- **Látogató** – böngészhet, de rendeléshez be kell jelentkeznie  

A rendszer célja, hogy:
- reszponzív legyen (minden eszközön kényelmesen használható),  
- biztonságos legyen (jelszóhash, HTTPS),  
- bővíthető és fenntartható architektúrára épüljön.  

---

## Jelenlegi üzleti folyamatok modellje
- Termékek böngészése statikus listából  
- Kosár működése (hozzáadás, mennyiség módosítás, törlés)  
- „Rendelés leadása” gomb – csak jelzés, nincs feldolgozás  

---

## Igényelt üzleti folyamatok modellje
- **Felhasználói fiókok:** regisztráció, bejelentkezés, profilkezelés  
- **Kosár és rendelés:** kosár mentése adatbázisba, rendelés leadása  
- **Értékelés:** 0–5 csillag és szöveges komment termékekhez  
- **Admin funkciók:** új termék/kategória hozzáadása, készletmódosítás, rendelés státusz kezelése  
- **Keresés és szűrés:** kategória, ár és népszerűség alapján  

---

## Követelménylista
| Id  | Modul        | Név                | Leírás                                                                 |
|-----|--------------|--------------------|------------------------------------------------------------------------|
| K1  | Felület      | Termékek listázása | Termékek böngészése kategóriák szerint, részletes leírással és képpel. |
| K2  | Felület      | Kosár              | Termékek kosárba helyezése, mennyiség módosítás, törlés, végösszeg.    |
| K3  | Felület      | Rendelés leadása   | A kosár tartalmának mentése és rendelés elküldése (adatbázisban).      |
| K4  | Felület      | Regisztráció       | Vásárlói fiók létrehozása felhasználónév, jelszó, e-mail alapján.      |
| K5  | Felület      | Bejelentkezés      | Felhasználók beléphetnek saját fiókjukba a rendeléshez.                |
| K6  | Felület      | Profil             | Adatok és korábbi rendelések megtekintése, szerkesztése.               |
| K7  | Modifikáció  | Jelszókezelés      | Elfelejtett jelszó, jelszó módosítása.                                 |
| K8  | Funkcionalitás | Értékelés        | Csillagos értékelés és szöveges visszajelzés termékekhez.              |
| K9  | Funkcionalitás | Keresés és szűrés| Termékek keresése és szűrése kategória, ár, népszerűség alapján.       |
| K10 | Jogosultság  | Admin felület      | Adminisztrátorok kezelik a termékeket, kategóriákat, felhasználókat.   |

---

## Használati esetek
### Admin
- Termékek és kategóriák hozzáadása, módosítása, törlése  
- Rendelések státuszának kezelése  
- Felhasználók és jogosultságok kezelése  
- Értékelések moderálása  

### Vásárló
- Regisztráció és bejelentkezés  
- Termékek böngészése, kosárba helyezés, mennyiség módosítás  
- Rendelés leadása és korábbi rendelések megtekintése  
- Értékelések írása a megvásárolt termékekhez  

### Látogató
- Termékek és kategóriák böngészése  
- Kosárba helyezhet terméket, de rendeléshez be kell jelentkeznie  

---

## Megfeleltetés – követelmények és funkciók
- **K1 + K2 + K3:** biztosítja a teljes vásárlási folyamatot  
- **K4 + K5 + K6 + K7:** felhasználói fiók kezeléséhez szükséges funkciók  
- **K8:** értékelési funkció, vásárlói visszajelzések gyűjtése  
- **K9:** keresési és szűrési lehetőségek, jobb felhasználói élményért  
- **K10:** admin funkciók, a webshop karbantartása és kezelése  

---

## Forgatókönyvek
### 1. Alap forgatókönyv – Vásárlás
- Látogató megnyitja a webshopot → böngészik a kategóriák között  
- Termékeket kosárba tesz → megtekinti a kosár tartalmát  
- „Rendelés leadása” gomb megnyomásakor → rendszer kéri a bejelentkezést  
- Bejelentkezett vásárló esetén → a rendelés rögzül az adatbázisban  

### 2. Admin forgatókönyv
- Admin bejelentkezik → eléri az admin felületet  
- Új termék vagy kategória felvétele, készlet módosítása  
- Rendelések státuszának átállítása (pl. PENDING → SHIPPED)  

---

## Funkció – követelmény megfeleltetése
| Követelmény | Funkció |
|-------------|----------|
| K1          | Termékek listázása kategóriánként, leírással és képekkel |
| K2          | Kosár műveletek: hozzáadás, törlés, mennyiség módosítás |
| K3          | Rendelés mentése és elküldése adatbázisba |
| K4–K7       | Felhasználói fiókok kezelése (regisztráció, belépés, profil, jelszó) |
| K8          | Értékelési rendszer (0–5 csillag + komment) |
| K9          | Keresés és szűrés funkció |
| K10         | Admin felület, teljes jogosultságkezelés |

---
