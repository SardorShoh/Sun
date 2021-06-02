<?php
declare(strict_types=1);
namespace lib;

use \lib\{Views, ErrorHandler};

class Config {

  public bool $case_sensitive  = false; //Router nomining harflarini katta yoki kichik ekanligini farqlash
  public string $server_header = ''; //Headerda server nomini yuborish
  public bool $strict_routing  = false; // /login va /login/ route lar boshqa-boshqa hisoblanadi
  public bool $immutable       = false;
  public bool $unescape_path   = false;
  public bool $etag            = false; //Headerda ETAG ni yuborish
  public int $body_limit       = 4 * 1024 * 1024; //Ma'lumotlarni yuborish hajmi
  public int $concurrency      = 256 * 1024; //Bir vaqtning o'zida nechtagacha concurrent ulanish bo'lishi. keyinchalik ishlanadi
  public Views $views; //templating uchun view lar bilan ishlash classi. keyinchalik ishlanadi
  public int $read_timeout; //kelgan ma'lumotni o'qishga qo'yilgan timeout. sekundda
  public int $write_timeout; //yuboriladigan ma'lumotlarni yozishga qo'yilgan timeout. sekundda
  public int $read_buffer_size = 4096; //Har bir connectionda kelgan ma'lumotlarni buferga olish hajmi
  public int $write_buffer_size= 4096; //Har bir connection bilan yuboriladigan ma'lumotlarning buferga yozish hajmi
  public string $proxy_header  = 'X-Forwarded-For'; //foydalanuvchining ip manzilini olish uchun qaysi headerdan foydalanish
  public bool $get_only        = false; //Faqat get so'rovlarini amalga oshirish uchun. Bu serverni anti-DOS himoyasi uchun. GET dan boshqa so'rovlar avtomatik tarzda bekor qilinadi
  public ErrorHandler $error_handler; //Error yuz berganda qanaqa javob qayatarish.
  public bool $disable_keepalive = false; //Keep-Alive connectionni o'chirib qo'yish
  public bool $disable_default_date = false; //odatiy kunni o'chirib qo'yish. bu foydalanuvchiga javob yuborilganda ishlatiladi
  public bool $disable_default_content_type = false; //odatiy Content-Type ni o'rnatish
  public bool $disable_header_normalizing = false; //header kalitlarini normal holatga keltirishni yoqish. Masalan: conTenT-TyPE => Content-Type
  public bool $disable_startup_message = false; //Startup messageni o'chirib qo'yish


}