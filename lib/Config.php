<?php

namespace lib;

use \lib\{Views, ErrorHandler};

class Config {

  public bool $caseSensitive = false;
  public string $serverHeader;
  public bool $strictRouting = false;
  public bool $immutable = false;
  public bool $unescapePath = false;
  public bool $etag = false;
  public int $bodyLimit = 4 * 1024 * 1024;
  public int $concurrency = 256 * 1024; //Bir vaqtning o'zida nechtagacha concurrent ulanish bo'lishi. keyinchalik ishlanadi
  public Views $views; //templating uchun view lar bilan ishlash classi. keyinchalik ishlanadi
  public int $readTimeout; //kelgan ma'lumotni o'qishga qo'yilgan timeout. sekundda
  public int $writeTimeout; //yuboriladigan ma'lumotlarni yozishga qo'yilgan timeout. sekundda
  public int $readBufferSize = 4096; //Har bir connectionda kelgan ma'lumotlarni buferga olish hajmi
  public int $writeBufferSize = 4096; //Har bir connection bilan yuboriladigan ma'lumotlarning buferga yozish hajmi
  public string $proxyHeader = 'X-Forwarded-Ip'; //foydalanuvchining ip manzilini olish uchun qaysi headerdan foydalanish
  public bool $getOnly = false; //Faqat get so'rovlarini amalga oshirish uchun. Bu serverni anti-DOS himoyasi uchun. GET dan boshqa so'rovlar avtomatik tarzda bekor qilinadi
  public ErrorHandler $errorHandler; //Error yuz berganda qanaqa javob qayatrish.
  public bool $disableKeepAlive = false; //Keep-Alive connectionni o'chirib qo'yish
  public bool $disableDefaultDate = false; //odatiy kunni o'chirib qo'yish. bu foydalanuvchiga javob yuborilganda ishlatiladi
  public bool $disableDefaultContentType = false; //odatiy Content-Type ni o'rnatish
  public bool $disableHeaderNormalizing = false; //header kalitlarini normal holatga keltirishni yoqish. Masalan: conTenT-TyPE => Content-Type
  public bool $disableStartupMessage = false; //Startup messageni o'chirib qo'yish


}