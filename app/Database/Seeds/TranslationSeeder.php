<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_SUCCESSFULLY_MESSAGE",
                "value" => "İşlem başarıyla tamamlandı!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UNSUCCESSFULLY_MESSAGE",
                "value" => "İşlem başarısız oldu!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_CREATE_SUCCESSFULLY_MESSAGE",
                "value" => "Kayıt başarıyla oluşturuldu!",
                "status_code" => "201"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UPDATE_SUCCESSFULLY_MESSAGE",
                "value" => "Güncelleme başarıyla yapıldı!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UPDATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Güncelleme başarısız oldu!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_DELETE_SUCCESSFULLY_MESSAGE",
                "value" => "Silme işlemi başarıyla yapıldı!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_DELETE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Silme işlemi başarısız oldu!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_VALIDATION_SUCCESSFULLY_MESSAGE",
                "value" => "Doğrulama başarıyla tamamlandı!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_VALIDATION_UNSUCCESSFULLY_MESSAGE",
                "value" => "Doğrulama başarısız oldu!",
                "status_code" => "422"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UNAUTHORIZED_UNSUCCESSFULLY_MESSAGE",
                "value" => "Yetkisiz erişim!",
                "status_code" => "403"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_BLACKLIST_UNSUCCESSFULLY_MESSAGE",
                "value" => "IP adresiniz kara listede!",
                "status_code" => "403"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_TOKEN_NOT_FIND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token bulunamadı!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_EXPIRED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token süresi dolmuş!",
                "status_code" => "401"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_MALFORMED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Geçersiz token!",
                "status_code" => "401"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_INVALID_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token geçersiz!",
                "status_code" => "401"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_IP_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "IP adresi bulunamadı!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_TOO_MANY_REQUEST_UNSUCCESSFULLY_MESSAGE",
                "value" => "Çok fazla istek yapıldı!",
                "status_code" => "429"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_REGISTER_SUCCESSFULLY_MESSAGE",
                "value" => "Kayıt başarıyla oluşturuldu!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_REGISTER_UNSUCCESSFULLY_MESSAGE",
                "value" => "Kayıt oluşturulamadı!",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_LOGIN_SUCCESSFULLY_MESSAGE",
                "value" => "Giriş başarıyla yapıldı!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_LOGIN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Giriş başarısız oldu!",
                "status_code" => "401"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_SUCCESSFULLY_MESSAGE",
                "value" => "Operation completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Operation failed!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_CREATE_SUCCESSFULLY_MESSAGE",
                "value" => "Record created successfully!",
                "status_code" => "201"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UPDATE_SUCCESSFULLY_MESSAGE",
                "value" => "Update completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UPDATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Update failed!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_DELETE_SUCCESSFULLY_MESSAGE",
                "value" => "Deletion completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_DELETE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Deletion failed!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_VALIDATION_SUCCESSFULLY_MESSAGE",
                "value" => "Validation completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_VALIDATION_UNSUCCESSFULLY_MESSAGE",
                "value" => "Validation failed!",
                "status_code" => "422"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UNAUTHORIZED_UNSUCCESSFULLY_MESSAGE",
                "value" => "Unauthorized access!",
                "status_code" => "403"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_BLACKLIST_UNSUCCESSFULLY_MESSAGE",
                "value" => "Your IP is blacklisted!",
                "status_code" => "403"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_TOKEN_NOT_FIND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token not found!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_EXPIRED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token expired!",
                "status_code" => "401"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_MALFORMED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Malformed token!",
                "status_code" => "401"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_INVALID_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Invalid token!",
                "status_code" => "401"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_IP_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "IP not found!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_TOO_MANY_REQUEST_UNSUCCESSFULLY_MESSAGE",
                "value" => "Too many requests!",
                "status_code" => "429"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_REGISTER_SUCCESSFULLY_MESSAGE",
                "value" => "Registration completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_REGISTER_UNSUCCESSFULLY_MESSAGE",
                "value" => "Registration failed!",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_LOGIN_SUCCESSFULLY_MESSAGE",
                "value" => "Login completed successfully!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_LOGIN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Login failed!",
                "status_code" => "401"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_SUCCESSFULLY_MESSAGE",
                "value" => "Vorgang erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Vorgang fehlgeschlagen!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_CREATE_SUCCESSFULLY_MESSAGE",
                "value" => "Datensatz erfolgreich erstellt!",
                "status_code" => "201"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UPDATE_SUCCESSFULLY_MESSAGE",
                "value" => "Aktualisierung erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UPDATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Aktualisierung fehlgeschlagen!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_DELETE_SUCCESSFULLY_MESSAGE",
                "value" => "Löschen erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_DELETE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Löschen fehlgeschlagen!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_VALIDATION_SUCCESSFULLY_MESSAGE",
                "value" => "Validierung erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_VALIDATION_UNSUCCESSFULLY_MESSAGE",
                "value" => "Validierung fehlgeschlagen!",
                "status_code" => "422"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UNAUTHORIZED_UNSUCCESSFULLY_MESSAGE",
                "value" => "Unbefugter Zugriff!",
                "status_code" => "403"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_BLACKLIST_UNSUCCESSFULLY_MESSAGE",
                "value" => "Ihre IP ist auf der schwarzen Liste!",
                "status_code" => "403"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_TOKEN_NOT_FIND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token nicht gefunden!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_EXPIRED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Token abgelaufen!",
                "status_code" => "401"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_MALFORMED_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Fehlerhaftes Token!",
                "status_code" => "401"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_INVALID_TOKEN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Ungültiges Token!",
                "status_code" => "401"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_IP_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "IP nicht gefunden!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_TOO_MANY_REQUEST_UNSUCCESSFULLY_MESSAGE",
                "value" => "Zu viele Anfragen!",
                "status_code" => "429"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_REGISTER_SUCCESSFULLY_MESSAGE",
                "value" => "Registrierung erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_REGISTER_UNSUCCESSFULLY_MESSAGE",
                "value" => "Registrierung fehlgeschlagen!",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_LOGIN_SUCCESSFULLY_MESSAGE",
                "value" => "Anmeldung erfolgreich abgeschlossen!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_LOGIN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Anmeldung fehlgeschlagen!",
                "status_code" => "401"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_CREATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Veri oluşturma başarısız!",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_CREATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Data creation unsuccessful!",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_CREATE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Daten erstellen fehlgeschlagen!",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Kayıt bulunamadı!",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Record not found!",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Datensatz nicht gefunden!",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_NEED_DATA_UNSUCCESSFULLY_MESSAGE",
                "value" => "Veri gerekli",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_NEED_DATA_UNSUCCESSFULLY_MESSAGE",
                "value" => "Data needed",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_NEED_DATA_UNSUCCESSFULLY_MESSAGE",
                "value" => "Daten erforderlich",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_EMAIL_ADDED_QUEUE_UNSUCCESSFULLY_MESSAGE",
                "value" => "E-posta başarıyla kuyruğa alındı.",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_EMAIL_ADDED_QUEUE_UNSUCCESSFULLY_MESSAGE",
                "value" => "The email has been successfully queued.",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_EMAIL_ADDED_QUEUE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Die E-Mail wurde erfolgreich in die Warteschlange gestellt.",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_LANGUAGE_NOT_SET_UNSUCCESSFULLY_MESSAGE",
                "value" => "Dil ayarlanamadı.",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_LANGUAGE_NOT_SET_UNSUCCESSFULLY_MESSAGE",
                "value" => "The language could not be set.",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_LANGUAGE_NOT_SET_UNSUCCESSFULLY_MESSAGE",
                "value" => "Die Sprache konnte nicht eingestellt werden.",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UNSUPPORTED_LANGUAGE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Desteklenmeyen Dil",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UNSUPPORTED_LANGUAGE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Unsupported Language",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UNSUPPORTED_LANGUAGE_UNSUCCESSFULLY_MESSAGE",
                "value" => "Nicht unterstützte Sprache",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_UPDATE_ALREADY_EXISTS_UNSUCCESSFULLY_MESSAGE",
                "value" => "Bütün veriler zaten güncel",
                "status_code" => "422"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_UPDATE_ALREADY_EXISTS_UNSUCCESSFULLY_MESSAGE",
                "value" => "All data is already up to date",
                "status_code" => "422"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_UPDATE_ALREADY_EXISTS_UNSUCCESSFULLY_MESSAGE",
                "value" => "Alle Daten sind bereits aktuell",
                "status_code" => "422"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_LOGOUT_SUCCESSFULLY_MESSAGE",
                "value" => "Başarıyla çıkış yaptınız.",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_LOGOUT_SUCCESSFULLY_MESSAGE",
                "value" => "Successfully logged out.",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_LOGOUT_SUCCESSFULLY_MESSAGE",
                "value" => "Erfolgreich abgemeldet.",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_LOGOUT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Çıkış yapma başarısız.",
                "status_code" => "401"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_LOGOUT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Logout unsuccessful.",
                "status_code" => "401"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_LOGOUT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Abmeldung fehlgeschlagen.",
                "status_code" => "401"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_DEFAULT_ERROR_MESSAGE",
                "value" => "Hata oluştu, lütfen daha sonra tekrar deneyin.",
                "status_code" => "500"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_DEFAULT_ERROR_MESSAGE",
                "value" => "An error occurred, please try again later.",
                "status_code" => "500"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_DEFAULT_ERROR_MESSAGE",
                "value" => "Ein Fehler ist aufgetreten, bitte versuchen Sie es später erneut.",
                "status_code" => "500"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_FRIEND_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Kullanıcı arkadaş listenizde bulunamadı.",
                "status_code" => "404"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_FRIEND_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "User not found in your friend list.",
                "status_code" => "404"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_FRIEND_NOT_FOUND_UNSUCCESSFULLY_MESSAGE",
                "value" => "Benutzer wurde nicht in deiner Freundesliste gefunden.",
                "status_code" => "404"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_SELF_REQUEST_DENIED_UNSUCCESSFULLY_MESSAGE",
                "value" => "Kendinize arkadaşlık isteği gönderemezsiniz.",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_SELF_REQUEST_DENIED_UNSUCCESSFULLY_MESSAGE",
                "value" => "You cannot send a friendship request to yourself.",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_SELF_REQUEST_DENIED_UNSUCCESSFULLY_MESSAGE",
                "value" => "Du kannst keine Freundschaftsanfrage an dich selbst senden.",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_SUCCESSFULLY_MESSAGE",
                "value" => "Arkadaşlık isteğiniz başarıyla gönderildi!",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_SUCCESSFULLY_MESSAGE",
                "value" => "Your friendship request has been successfully sent!",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_SUCCESSFULLY_MESSAGE",
                "value" => "Ihre Freundschaftsanfrage wurde erfolgreich gesendet!",
                "status_code" => "200"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Arkadaşlık isteği gönderilirken bir hata oluştu.",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "An error occurred while sending the friendship request.",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Beim Senden der Freundschaftsanfrage ist ein Fehler aufgetreten.",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_ALREADY_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Arkadaşlık isteğiniz zaten gönderildi.",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_ALREADY_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Your friendship request has already been sent.",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_FRIENDSHIP_REQUEST_ALREADY_SENT_UNSUCCESSFULLY_MESSAGE",
                "value" => "Ihre Freundschaftsanfrage wurde bereits gesendet.",
                "status_code" => "400"
            ],

            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_TASK_ASSIGN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Görev ataması başarısız oldu.",
                "status_code" => "400"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_TASK_ASSIGN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Task assignment failed.",
                "status_code" => "400"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_TASK_ASSIGN_UNSUCCESSFULLY_MESSAGE",
                "value" => "Aufgabenzuweisung fehlgeschlagen.",
                "status_code" => "400"
            ],
            [
                "language_code" => "tr",
                "key_name" => "RESPONSE_TASK_ASSIGN_SUCCESSFULLY_MESSAGE",
                "value" => "Görev başarıyla atandı.",
                "status_code" => "200"
            ],
            [
                "language_code" => "en",
                "key_name" => "RESPONSE_TASK_ASSIGN_SUCCESSFULLY_MESSAGE",
                "value" => "Task assigned successfully.",
                "status_code" => "200"
            ],
            [
                "language_code" => "de",
                "key_name" => "RESPONSE_TASK_ASSIGN_SUCCESSFULLY_MESSAGE",
                "value" => "Aufgabe erfolgreich zugewiesen.",
                "status_code" => "200"
            ],
        ];

        $this->db->table('translations')->insertBatch($data);
    }
}
