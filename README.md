# Nekustamo Īpašumu Sistēma

Šī ir nekustamo īpašumu pārvaldības sistēma, kas izstrādāta ar **Vue.js 3** (FrontEnd) un **Laravel 11** (BackEnd).

---

## Tehnoloģijas

- **Frontend:** Vue.js 3
- **Backend:** Laravel 11
- **Datu bāze:** MySQL (caur XAMPP)
- **API komunikācija:** Axios
- **Autentifikācija:** Bearer Token

---

## Funkcionalitāte

### 1. Autentifikācija un Autorizācija

- **Reģistrācija**
  - Lietotājs var reģistrēties, aizpildot formu.
  - Backend validē datus, hash-o paroli un saglabā lietotāju datu bāzē.
  - Frontend izmanto Axios, lai nosūtītu datus uz API.

- **Pieteikšanās (Login)**
  - Lietotājs piesakās ar e-pastu un paroli.
  - Backend pārbauda lietotāja esamību un ģenerē Bearer token.
  - Pēc veiksmīgas pieteikšanās lietotājs tiek novirzīts uz sākumlapu.
  - Navbar tiek attēlots lietotāja vārds, profila sadaļa un izrakstīšanās poga.

- **Izrakstīšanās (Logout)**
  - Lietotājs var izrakstīties, kas noņem token gan frontend, gan backend pusē.
  - Ir izveidots atsevišķs logout API.

### 2. Lietotāja Profils

- Lietotājs var skatīt un rediģēt savu informāciju.
- Pieejama iespēja mainīt paroli.
- Lietotāja dati tiek ielādēti pēc pieteikšanās.

### 3. Īpašumu Saraksts

- Izveidota īpašumu saraksta lapa (listing page).
- Pašlaik ir tikai statisks ieraksts.
- Plānots izveidot datu bāzes tabulu īpašumu informācijai un aizpildīt to ar Laravel Faker.

### 4. Administrācijas Panelis

- Pieejams tikai lietotājiem ar "admin" lomu.
- Divas tabulas: lietotāju tabula un īpašumu tabula.
- Abām tabulām ir meklēšanas funkcionalitāte.

---

## API Pārskats

- **POST /api/register** — lietotāja reģistrācija
- **POST /api/login** — lietotāja pieteikšanās
- **POST /api/logout** — lietotāja izrakstīšanās

---

## Testēšana

- API testēti ar Postman.
- Izveidoti 10 testgadījumi (skatīt attēlu zemāk).

---

## Testgadījumu Tabula

![Testgadījumu tabula](https://github.com/user-attachments/assets/0dcda2d6-304c-48e0-b775-e8ba0f256108)

---

## Plānotie Uzlabojumi

- Izveidot īpašumu datu bāzes tabulu un aizpildīt ar Faker datiem.
- Paplašināt īpašumu saraksta funkcionalitāti.
- Uzlabot lietotāja profila iespējas.

---

## Autors

- Projekta autors: *[Jūsu vārds]*


