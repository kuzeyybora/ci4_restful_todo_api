# CodeIgniter 4 Restful Todo Api Project ( TR )
CodeIgniter 4 ile geliştirilmiş bu Restful Todo API projesi, kullanıcıların görevlerini yönetebileceği, arkadaşlarına görev atayabileceği ve arkadaşlık ilişkilerini yönetebileceği bir platform sunmaktadır. Kullanıcılar, birbirlerine arkadaşlık isteği gönderebilir, bu isteği kabul edebilir veya reddedebilirler. Projeye Shield kullanılarak kimlik doğrulama eklenmiştir ve uygulama Türkçe, İngilizce ve Almanca dillerini desteklemektedir. Hızlı erişim sağlamak amacıyla, Queue sistemi ve multilingual destek Redis'te saklanmaktadır. Ayrıca, API üzerinde Rate Limiting uygulanmış ve tüm bu veriler Redis üzerinde tutulmaktadır. Admin paneli, kullanıcıların verileri yönetmesini ve e-posta gönderimlerini gerçekleştirmesini sağlar. Admin panelinde yapılan her işlem, Observer Design Pattern kullanılarak MongoDB'ye kaydedilen bir event sistemiyle izlenir. Projede ayrıca, meydana gelen hatalar da MongoDB'ye log olarak eklenir. Migration ve Seeder dosyaları tamamlanmış, veri tabanı yapıları hazır hale getirilmiştir. Nesne oluşturma süreci için Factory Design Pattern, kaynak yönetimi ve bağımlılıklar için ise Singleton Design Pattern kullanılmıştır.

## İçindekiler
1. Proje Özeti
2. İçindekiler
3. Proje Yapısı
   * Proje Durumu
   * Genel Bakış
   * Kullanılan Teknolojiler
   * Design Patterns
4. Veritabanı Yapısı Genel Özeti
5. Kurulum
   * Gereksinimler
   * Bağımlılıkların Kurulumu
   * Konfigürasyon Ayarları
   * Migration ve Seeder Çalıştırma
6. API Kullanımı
   * API Uç Noktaları
7. Örnek İstekler
8. Projeyi Çoklu Dilli Kullanma
9. Redisin Projedeki Yeri
10. Lisans

## Proje Yapısı

#### Proje Durumu
- [x] Kullanıcı Yönetimi
- [x] Görev Yönetimi
- [x] Arkadaşlık Sistemi
- [x] Multilingual Destek
- [x] Queue Sistemi
- [x] Rate Limiting
- [x] Admin Paneli ve Yetkilendirme
- [x] Kullanıcı Yetkilendirmesi ve Rol Yönetimi
- [x] Event Sistemi
- [ ] Testing 

#### Genel Bakış
- **Kullanıcı Yönetimi**: Kullanıcılar, **register**, **login** ve **logout** işlemleri yaparak sisteme kayıt olabilir, giriş yapabilir veya çıkış yapabilir. Kimlik doğrulama için Shield kullanılmıştır, böylece kullanıcı bilgileri güvenli bir şekilde doğrulanır. Giriş yapan kullanıcılar görevlerini yönetebilir ve arkadaşlık ilişkilerini sürdürebilir.
- **Görev Yönetimi**: Kullanıcılar, oluşturdukları görevleri listeleyebilir, yeni görevler ekleyebilir, var olan görevleri düzenleyebilir ve görevleri arkadaşlarına atayabilir. Her kullanıcı sadece kendi görevlerini görebilir, ancak görevler atandığında görev sahipliği, belirtilen arkadaşla paylaşılır. Görevler RESTful API uç noktaları üzerinden yönetilir.
- **Arkadaşlık Sistemi**: Kullanıcılar birbirlerine arkadaşlık isteği gönderebilir. Gelen arkadaşlık isteklerini kabul veya reddedebilirler. Arkadaşlık isteği gönderme, gelen istekleri listeleme, kabul etme ve reddetme işlemleri, ilgili API uç noktaları üzerinden yapılır. Kullanıcılar yalnızca arkadaş oldukları kişilere görev atama yetkisine sahiptir.
- **Multilingual Destek**: Proje **Türkçe**, **İngilizce** ve **Almanca** dillerini destekler. Kullanıcılar, uygulama dilini tercihlerine göre değiştirebilir. Dil çevirileri Redis kullanılarak hızlı bir şekilde erişilebilir ve yönetilebilir.
- **Queue Sistemi**: Arka planda işlem yapabilmek için bir Queue sistemi kullanılmıştır. Queue'ya veri eklemek ve bu verileri yönetmek için Redis kullanılır. Bu, e-posta gönderimi, bildirimler ve diğer arka plan görevlerinin hızlı ve verimli bir şekilde işlenmesini sağlar. Admin paneli üzerinden Queue'ya veri ekleme işlemleri yapılabilir.
- **Rate Limiting**: API'ye yapılan isteklerin sıklığını sınırlamak için Rate Limiting uygulanır. Redis ile bu sınırlama yapılır ve API'yi aşırı yükten korur. Bu özellik, sistemin güvenliğini artırır ve istekleri düzenler.
- **Admin Paneli ve Yetkilendirme**: Admin kullanıcıları, sisteme tam erişim hakkına sahip olup, tüm kullanıcılar, görevler, arkadaşlıklar, loglar, kuyruklar ve çeviriler üzerinde işlem yapabilir. Admin paneli üzerinden tüm veriler görülebilir, kuyruklar yönetilebilir, çeviriler düzenlenebilir ve sistemin genel durumu izlenebilir. Admin yetkisi, roleFilter aracılığıyla kontrol edilir ve sadece admin rolüne sahip kullanıcılar bu paneli kullanabilir. Admin işlemleri de **Observer Design Pattern** ile MongoDB'ye kaydedilir.
- **Kullanıcı Yetkilendirmesi ve Rol Yönetimi**: Kullanıcılar sisteme giriş yaptıktan sonra, kimlik doğrulaması ve yetkilendirmeleri API Auth ve roleFilter middleware'leri ile kontrol edilir. Her kullanıcının erişim yetkileri, hangi işlemleri yapabileceği ve hangi verilere ulaşabileceği belirli bir role göre yönetilir. Adminler, tüm verilere erişebilirken, normal kullanıcılar yalnızca kendilerine ait verilere erişebilir ve yalnızca arkadaşlarına görev atayabilir.
- **Event Sistemi**: Projede **Observer Design Pattern** kullanılarak, yapılan işlemler MongoDB’ye kaydedilen bir event sistemi aracılığıyla izlenir. Bu, sistemdeki her önemli değişikliği ve hatayı takip etmemizi sağlar. Ayrıca, oluşan hatalar MongoDB'ye log olarak kaydedilir.

#### Kullanılan Teknolojiler
* PHP 8.1
* CodeIgniter 4 (Framework)
* Shield (Kimlik Doğrulama ve Yetkilendirme)
* MongoDB (Loglar için Veritabanı)
* Redis (Queue yönetimi, Rate Limiting, Hızlı Veri Erişimi)
* Predis (Redis istemcisi)
* Queue (İşlem Kuyruğu Teknolojisi)

#### Design Patterns
* Observer Design Pattern (İşlem Takibi ve Hata Loglama)
* Factory Design Pattern (Nesne Yönetimi)
* Singleton Design Pattern (Bağımlılık Yönetimi ve Kaynak Kontrolü)

## Veritabanları Yapısı Genel Özeti
1. **Mysql**: Yetkiler, Kullanıcılar, görevler, arkadaşlıklar, Migrationlar, Başarısız Queuelar, Çeviriler gibi veriler saklanır.
2. **Redis**: Hızlı veri erişimi ve geçici veriler için kullanılır. Rate limiting, kuyruk yönetimi, Kullanılacak Dil Verileri.
3. **MongoDB**: Loglar ve Hatalar için kullanılır.

## Kurulum
Proje çalıştırılmadan önce aşağıdaki gereksinimlerin sisteminizde yüklü olması gerekmektedir:
* PHP 8.1 veya daha yeni bir sürüm
* MongoDB (Veritabanı için)
* Redis (Queue ve cache için)
* Composer (PHP bağımlılık yönetimi için)

## Bağımlılıkların Kurulumu
Projeyi başlatmadan önce gerekli bağımlılıkları yüklemek için aşağıdaki adımları izleyin:
1. Projeyi Klonlayın:
```
git clone https://github.com/kuzeyybora/ci4_restful_todo_api
cd ci4_restful_todo_api
```
2. Composer ile bağımlılıkları Yükleyin:
```
composer install
```
## Konfigürasyon Ayarları
Projenin çalışabilmesi için bazı temel konfigürasyon ayarlarını yapmanız gerekmektedir. Bu ayarlar genellikle .env dosyasında yer alır.

1. .env dosyasını kopyalayın ve düzenleyin:
```
cp .env.example .env
```
2. Veritabanı ve diğer sistem ayarlarını .env dosyasındaki ilgili kısımlarda düzenleyin:

## Migration ve Seeder Çalıştırma
1. Migration: Veritabanı tablolarını oluşturur.
```
php spark migrate --all
```
2. Seeder: Varsayılan test verilerini veritabanına ekler.
```
php spark db:seed UserSeeder
```
Bu komutlar veritabanı yapısını ve başlangıç verilerini hazır hale getirecektir.


## Api Kullanımı

##### Kullanıcı İşlemleri
| HTTP Metodu | Endpoint Adı |    URL    |    Body Parametreleri     | Token | Yetki   |
|:-----------:|:------------:|:---------:|:-------------------------:|:-----:|---------|
|    POST     |  Giriş Yap   |  /login   |      Email, Password      |   ❌   | Misafir |
|    POST     |   Kayıt Ol   | /register | Username, Email, password |   ❌   | Üye     |
|    POST     |  Çıkış Yap   |  /logout  |                           |   ✅   | Üye     |

##### Görev İşlemleri

| HTTP Metodu |        Endpoint Adı        |         URL         |      Body Parametreleri      | Token | Yetki |
|:-----------:|:--------------------------:|:-------------------:|:----------------------------:|:-----:|-------|
|     GET     |     Görevleri Listele      |       /tasks        |                              |   ✅   | Üye   |
|     GET     |  Idye göre Görevi listele  |     /tasks/$id      |                              |   ✅   | Üye   |
|     GET     | Görevleri Paginate Listele | /tasks/:limit/:page |                              |   ✅   | Üye   |
|    POST     |       Görev Oluştur        |       /tasks        |  title, description, status  |   ✅   | Üye   |
|    POST     |    Görevi Arkadaşa Ata     |  /tasks/assignTask  | task_id(int), friend_id(int) |   ✅   | Üye   |
|     PUT     |  Idye Göre Görev Güncelle  |     /tasks/$id      |  title, description, status  |   ✅   | Üye   |
|     DEL     |    Idye Gore Görev Sil     |     /tasks/$id      |                              |   ✅   | Üye   |

##### Arkadaşlık İşlemleri

| HTTP Metodu |         Endpoint Adı         |                   URL                   | Token | Yetki |
|:-----------:|:----------------------------:|:---------------------------------------:|:-----:|-------|
|    POST     |   Arkadaşlık İsteği Gönder   |        /friends/send-request/$id        |   ✅   | Üye   |
|     GET     |        Gelen İstekler        |       /friends/requests/incoming        |   ✅   | Üye   |
|     GET     |   Gelen İstekler Paginate    | /friends/requests/incoming/:limit/:page |   ✅   | Üye   |
|    POST     |       İsteği Kabul Et        |      /friends/requests/accept/$id       |   ✅   | Üye   |
|    POST     |        İsteği Reddet         |      /friends/requests/reject/$id       |   ✅   | Üye   |
|     GET     |     Arkadaşları Listele      |              /friends/list              |   ✅   | Üye   |
|     GET     | Arkadaşları Paginate Listele |       /friends/list/:limit/:page        |   ✅   | Üye   |

##### Admin İşlemleri

| HTTP Metodu |         Endpoint Adı         |              URL               | Token | Yetki |
|:-----------:|:----------------------------:|:------------------------------:|:-----:|-------|
|     GET     |    Kullanıcıları Listele     |          /admin/users          |   ✅   | Admin |
|     GET     |       Logları Listele        |          /admin/logs           |   ✅   | Admin |
|     GET     |    Arkadaşlıkları Listele    |       /admin/friendships       |   ✅   | Admin |
|     GET     |      Görevleri Listele       |          /admin/tasks          |   ✅   | Admin |
|     GET     | Görevlere Atananları Listele |       /admin/task-users        |   ✅   | Admin |
|     GET     | Çeviri Anahtarlarını Listele | /admin/translations/(tr,en,de) |   ✅   | Admin |
|     GET     |        Sırayı Listele        |       /admin/queue/list        |   ✅   | Admin |
|    POST     |       Sıraya veri ekle       |        /admin/queue/add        |   ✅   | Admin |



## Örnek İstekler

Login Endpointi için örnek istek ve cevapları:
> 
> İstek: 
> ```json
> {
>   "email":"kuzeybora@gitgit.com",
>   "password":"123123"
> }
> ```
> Başarılı Cevap: 200 OK
> ```json
> {
>   "status": true,
>   "message": "Giriş başarıyla yapıldı!",
>   "data": {
>       "token": "f9f0f7e287a8f9de952e1bf0e0f4c5bdefd7b3f467f9c79201c3e88740382773"
>   }
> }
> ```
> Başarısız Cevap: 401 Unauthorized
> ```json
> {
>   "status": false,
>   "message": "Giriş Başarısız Oldu!",
>   "data": null
> }
> ```

Görev Oluşturma Endpointi için örnek istek ve cevapları
>
> İstek:
> ```json
> {
>   "title": "PDOException: SQLSTATE[HY000]: General error",
>   "description": "Veritabanıyla olan ilişki kopmuş gibi görünüyor. 'Benimle düzgün konuş, neden böyle yapıyorsun?' diyor PDO.",
>   "status":"pending"
> }
> ```
> Başarılı Cevap: 201 Created
> ```php 
> {
>   "status": true,
>   "message": "Kayıt Başarıyla Oluşturuldu!",
>   "data": null
> }
> ```
> Başarısız Cevap: 400 Bad Request
> ```php
> {
>   "status": false,
>   "message": "Veri oluşturma başarısız!",
>   "data": null
> }
> ```
## Projeyi Çoklu dilli Kullanma

Projeyi farklı bir dilde kullanmak istiyorsanız, userLanguage adında bir HTTP başlığı göndermeniz gerekir. Bu başlık, tr (Türkçe), en (İngilizce) veya de (Almanca) değerlerinden birini alabilir.
```json
{
   "headers": {
      "userLanguage": "en"
   }
}
```

## Redisin Projedeki Yeri

Proje, Türkçe (TR), İngilizce (EN) ve Almanca (DE) olmak üzere çok dilli destek sağlar.
Redis, bu dillerin çevrim içi çeviri anahtarlarını veya metinlerini önbellekte tutar. Bu sayede, her dil çevirisi için veritabanına sorgu yapılması engellenir.

## Lisans
Proje, MIT Lisansı ile lisanslanmıştır. Daha fazla bilgi için LICENSE dosyasını inceleyebilirsiniz.
- - -
# CodeIgniter 4 Restful Todo Api Project ( EN )
This Restful Todo API project, developed with CodeIgniter 4, provides a platform where users can manage their tasks, assign tasks to their friends, and manage friendship relationships. Users can send friend requests to each other, and they can accept or reject these requests. Authentication has been added to the project using Shield, and the application supports Turkish, English, and German languages. To provide quick access, the Queue system and multilingual support are stored in Redis. Additionally, Rate Limiting has been implemented on the API, and all these data are stored in Redis. The admin panel allows users to manage data and send emails. Every action taken in the admin panel is monitored with an event system, which is saved to MongoDB using the Observer Design Pattern. Errors occurring in the project are also logged to MongoDB. Migration and Seeder files are complete, and database structures are ready. The Factory Design Pattern has been used for object creation processes, and the Singleton Design Pattern has been used for resource management and dependencies.

## Table of Contents
1. Project Summary 
2. Table of Contents
3. Project Structure
   * Project Status
   * General Overview
   * Technologies Used
   * Design Patterns
4. Database Structure Overview
5. Installation
   * Requirements
   * Installing Dependencies
   * Configuration Settings
   * Running Migrations and Seeders
6. API Usage
   * API Endpoints
7. Example Requests
8. Using the Project with Multiple Languages
9. The Role of Redis in the Project
10. License

## Proje Yapısı
#### Project Status
- [x] User Management
- [x] Task Management
- [x] Friendship System
- [x] Multilingual Support
- [x] Queue System
- [x] Rate Limiting
- [x] Admin Panel and Authorization
- [x] User Authorization and Role Management
- [x] Event System
- [ ] Testing
#### General Overview
- **User Management**: Users can **register**, **log in**, and **log out** by performing register, login, and logout actions. Shield is used for authentication, ensuring secure verification of user information. Logged-in users can manage their tasks and maintain their friendship relationships.
- **Task Management**: Users can list tasks they create, add new tasks, edit existing ones, and assign tasks to their friends. Each user can only view their own tasks, but when tasks are assigned, the task ownership is shared with the designated friend. Tasks are managed via RESTful API endpoints.
- **Friendship System**: Users can send friendship requests to each other. They can accept or reject incoming friendship requests. Sending a friendship request, listing incoming requests, accepting, and rejecting requests are all done via the relevant API endpoints. Users can only assign tasks to people they are friends with.
- **Multilingual Support**: The project supports **Turkish**, **English**, and **German** languages. Users can change the application language according to their preferences. Language translations are stored in Redis for quick access and management.
- **Queue System**: A Queue system is used for processing tasks in the background. Redis is used to add and manage data in the Queue. This allows email sending, notifications, and other background tasks to be processed quickly and efficiently. Data can be added to the Queue via the admin panel.
- **Rate Limiting**: Rate Limiting is applied to limit the frequency of requests to the API. This limiting is done with Redis and protects the API from overload. This feature enhances the security of the system and organizes requests.
- **Admin Panel and Authorization**: Admin users have full access to the system, allowing them to perform operations on all users, tasks, friendships, logs, queues, and translations. All data can be viewed through the admin panel, queues can be managed, translations can be edited, and the system's overall status can be monitored. Admin access is controlled through roleFilter, and only users with the admin role can use this panel. Admin actions are also logged in MongoDB using **the Observer Design Pattern**.
- **User Authorization and Role Management**: After logging in, users' authentication and authorization are controlled by the API Auth and roleFilter middleware. Each user's access rights, what actions they can perform, and what data they can access are managed according to a specific role. Admins can access all data, while normal users can only access their own data and can only assign tasks to their friends.
- **Event System**: **The Observer Design Pattern** is used to monitor operations via an event system that is logged into MongoDB. This allows us to track every significant change and error in the system. Additionally, errors that occur are logged into MongoDB.
#### Technologies Used
   * PHP 8.1
   * CodeIgniter 4 (Framework)
   * Shield (Authentication and Authorization)
   * MongoDB (Database for Logs)
   * Redis (Queue Management, Rate Limiting, Fast Data Access)
   * Predis (Redis Client)
   * Queue (Task Queue Technology)
#### Design Patterns
* Observer Design Pattern (Process Tracking and Error Logging)
* Factory Design Pattern (Object Management)
* Singleton Design Pattern (Dependency Management and Resource Control)
## Database Structure Overview
1. **Mysql**: Data such as permissions, users, tasks, friendships, migrations, failed queues, and translations are stored.
2. **Redis**: Used for fast data access and temporary data. Rate limiting, queue management, and language data are stored.
3. **MongoDB**: Used for logs and errors.
## Installation
#### Requirements
Before running the project, the following requirements must be installed on your system:
* PHP 8.1 or a newer version
* MongoDB (for the database)
* Redis (for queue and cache)
* Composer (for PHP dependency management)
#### Installing Dependencies
Follow the steps below to install the required dependencies before starting the project:
1. Clone The Project:
```
git clone https://github.com/kuzeyybora/ci4_restful_todo_api
cd ci4_restful_todo_api
```
2. Install dependencies with Composer:
```
composer install
```
#### Configuration Settings
To run the project, you need to make some basic configuration settings. These settings are typically found in the .env file.
1. Copy and edit the .env file:
```
cp .env.example .env
```
2. Adjust the database and other system settings in the relevant sections of the .env file:
#### Running Migrations and Seeders
1. Migration: Creates the database tables.
```
php spark migrate --all
```
2. Seeder: Adds default data to the database.
```
php spark db:seed UserSeeder
```
These commands will set up the database structure and initial data.
## API Usage
##### User Operations
| HTTP Method | Endpoint Name |    URL    |      Body Parameters      | Token | Authorization |
|:-----------:|:-------------:|:---------:|:-------------------------:|:-----:|---------------|
|    POST     |     Login     |  /login   |      Email, Password      |   ❌   | Guest         |
|    POST     |   Register    | /register | Username, Email, password |   ❌   | Member        |
|    POST     |    Log out    |  /logout  |                           |   ✅   | Member        |
##### Task Operations
| HTTP Method |     Endpoint Name     |         URL         |       Body Parameters        | Token | Authorization |
|:-----------:|:---------------------:|:-------------------:|:----------------------------:|:-----:|---------------|
|     GET     |      List Tasks       |       /tasks        |                              |   ✅   | Member        |
|     GET     |    List Task by Id    |     /tasks/$id      |                              |   ✅   | Member        |
|     GET     |  Paginate List Tasks  | /tasks/:limit/:page |                              |   ✅   | Member        |
|    POST     |      Create Task      |       /tasks        |  title, description, status  |   ✅   | Member        |
|    POST     | Assign Task to Friend |  /tasks/assignTask  | task_id(int), friend_id(int) |   ✅   | Member        |
|     PUT     |   Update Task by Id   |     /tasks/$id      |  title, description, status  |   ✅   | Member        |
|     DEL     |   Delete Task by Id   |     /tasks/$id      |                              |   ✅   | Member        |
##### Friendship Operations
| HTTP Method |       Endpoint Name        |                   URL                   | Token | Authorization |
|:-----------:|:--------------------------:|:---------------------------------------:|:-----:|---------------|
|    POST     |  Send Friendship Request   |        /friends/send-request/$id        |   ✅   | Member        |
|     GET     |     Incoming Requests      |       /friends/requests/incoming        |   ✅   | Member        |
|     GET     | Paginate Incoming Requests | /friends/requests/incoming/:limit/:page |   ✅   | Member        |
|    POST     |      Accept Requests       |      /friends/requests/accept/$id       |   ✅   | Member        |
|    POST     |      Reject Requests       |      /friends/requests/reject/$id       |   ✅   | Member        |
|     GET     |        List Friends        |              /friends/list              |   ✅   | Member        |
|     GET     |   Paginate List Friends    |       /friends/list/:limit/:page        |   ✅   | Member        |
##### Admin Operations
| HTTP Method |        Endpoint Name         |              URL               | Token | Authorization |
|:-----------:|:----------------------------:|:------------------------------:|:-----:|---------------|
|     GET     |          List Users          |          /admin/users          |   ✅   | Admin         |
|     GET     |          List Logs           |          /admin/logs           |   ✅   | Admin         |
|     GET     |       List Friendships       |       /admin/friendships       |   ✅   | Admin         |
|     GET     |          List Tasks          |          /admin/tasks          |   ✅   | Admin         |
|     GET     | List Assigned Users to Tasks |       /admin/task-users        |   ✅   | Admin         |
|     GET     |    List Translation Keys     | /admin/translations/(tr,en,de) |   ✅   | Admin         |
|     GET     |          List Queue          |       /admin/queue/list        |   ✅   | Admin         |
|    POST     |      Add Data to Queue       |        /admin/queue/add        |   ✅   | Admin         |
## Example Requests
Login Endpoint example request and response:
> Request:
> ```json
> {
>   "email":"kuzeybora@gitgit.com",
>   "password":"123123"
> }
> ```
> Successful Response: 200 OK
> ```json
> {
>   "status": true,
>   "message": "Login completed successfully!",
>   "data": {
>       "token": "f9f0f7e287a8f9de952e1bf0e0f4c5bdefd7b3f467f9c79201c3e88740382773"
>   }
> }
> ```
> Unsuccessful Response: 401 Unauthorized
> ```json
> {
>   "status": false,
>   "message": "Login failed!",
>   "data": null
> }
> ```
Create Task Endpoint example request and response:
> Request:
> ```json
> {
>   "title": "500 Internal Server Error",
>   "description": "The server's having an existential crisis. It needs a moment to figure out its purpose in life..",
>   "status":"pending"
> }
> ```
> Successful Response: 201 Created
> ```json
> {
>   "status": true,
>   "message": "Record created successfully!",
>   "data": null
> }
> ```
> Unsuccessful Response: 400 Bad Request
> ```json
> {
>   "status": false,
>   "message": "Data creation unsuccessful!",
>   "data": null
> }
> ```
## Using the Project with Multiple Languages
If you want to use the project in a different language, you need to send an HTTP header called userLanguage. This header can take one of the following values: tr (Turkish), en (English), or de (German).
```json
{
   "headers": {
      "userLanguage": "en"
   }
}
```
## The Role of Redis in the Project
The project provides multilingual support in Turkish (TR), English (EN), and German (DE).
Redis stores the online translation keys or texts for these languages in the cache, preventing the need to query the database for each language translation.
## License
The project is licensed under the MIT License. For more information, please refer to the LICENSE file.
