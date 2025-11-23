
## Authors

[@RudisLV2006](https://github.com/RudisLV2006)


# Datoru būvēšanas sistēma

Datora būvēšanas sistēma ir tīmekļa lietotne, kas palīdz lietotājiem izveidot un pielāgot savu datoru komplektāciju. Sistēma ļauj izvēlēties savietojamas komponentes (procesoru, videokarti, mātesplati, operatīvo atmiņu, datu glabātuvi, barošanas bloku un korpusu), automātiski pārbaudot to saderību.


## Prasības

Pirms uzstādīšanas pārliecinies, ka datorā ir uzstādīts

- PHP 8.2+  
- Composer  
- Git
- Node JS
- CSS
  
## Instalēšana

Instalēt projektu lokāli
```bash
  git clone https://github.com/RudisLV2006/Computer-Building-System.git
  cd Computer-Building-System
  cd Building-System
```

Instalēt 

```bash
  composer install
```

Izveidot .env failu

```bash
  cp .env.example .env
```

Instalēt vizuālo
```bash
  npm install
```

Ģenerēt lietotnes atslēgu
```bash
  php artisan key:generate
```

Palaist migrāciju ar sēklu
```bash
  php artisan migrate --seed
```

    
## Run Locally

Palaist Laravel serveri

```bash
  php artisan serve
```
```bash
  npm run dev
```

Apmeklēt pārlūkā [http://localhost:8000](http://localhost:8000)
