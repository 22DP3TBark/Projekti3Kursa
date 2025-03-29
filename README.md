Nekustamo īpašumu sistēma 

Lietoju Vue js 3 un laravel 11

Izdarīts:

  Api:
  Uztaisiti 3 api: login, register un logout, kas ari tikka iztestēti ar postman.
  
  Registrācija:
    ir uztaisīta reģistrācija, kas savienojas ar Backend. Backend uztaisita funkcija kas valide ierakstitos datus, hasho paraoli un uztaisa lietotāju, kas talak tiek aizsūtīts uz mysql datu bāzi 
    izmantojot Xampp. FrontEnd izmanto axios, lai izmantotu api.
    
  Login:
    Uztaisīts login, kas savienojas ar backend, kur parbauda vai lietotajs eksistē un ari autorizē lietotāju, izmantojot bearer token. 
    Token uztaisa backend un frontend.Kad lietotajs uzspiež login, websites paraledejas
    un aisuta vinu uz home page, kur var navbar redzet ielogotā lietotaja username, profile sekciju ar visu lietotāja info un logout pogu.
    
  Logout:
    Uzpiežot pogu, lietotajs tiek logouts arā no sava konta, tiek nonemts token gan no frontend gan no BackEnd. Arī ir logout api uztaisits backend.
    
  Users profile:
    Kad uzspiež uz user pogu navbar, lietotājs var redzet visu savu infomaciju. Esošo lietotaja info saglabā kad viņs ielogojas ar login funkciju FrontEnd.
    Pievienota funkcionalitāte ka lietotajs var parmainit savu informaciju un paroli.
    
  Ir uztaisits listing page, bet pagaidam ir tikai ielikts parasts ierakts, vajag uztaisit dartubazes tabulu ar ipasumu info, un seedot vinu ar laravel faker.

  AdminDashBoard:
    Uztaisīts admin dashboard kur admin ar admin role tikai var redzet, iekša ir 2 tabulas, lietotāju tabula un Īpašumu tabula, abiem ir search function iespeja uztaisīta
    



TESTCASES 10
  Bilde kura var redzet tabulu ar 10 test cases
![image](https://github.com/user-attachments/assets/0dcda2d6-304c-48e0-b775-e8ba0f256108)


