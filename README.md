<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel N+1 Problemi Örneği

Bu proje, Laravel uygulamalarında sık karşılaşılan **N+1 Query Problemi**'ni göstermek ve çözmek için oluşturulmuştur.

### N+1 Problemi Nedir?

N+1 problemi, veritabanı sorgularında verimsizliğe neden olan bir durumdur:

- 1 sorgu: İlçeleri (counties) listele
- N sorgu: Her ilçe için şehir (city) bilgisini ayrı ayrı sorgula

Bu şekilde 1 şehir + 200 ilçe varsa = **201 sorgu** yapılır.

**Örnek (Sorunlu Kod):**
```php
$counties = County::all();

foreach ($counties as $county) {
    echo $county->city->name; // Her döngüde 1 sorgu = 200 sorgu
}
```

### Çözüm: Eager Loading

Laravel'in `with()` metodu kullanarak ilişkili verileri önceden yükleyin:

**Düzeltilmiş Kod:**
```php
$counties = County::with('city')->get(); // 2 sorgu

foreach ($counties as $county) {
    echo $county->city->name; // Sorgu yapılmaz, zaten yüklü
}
```

### Bu Projede Deneylemek

#### 1. Veritabanını Hazırla
```bash
php artisan migrate:fresh --seed
```

Bu komut:
- 20 şehir oluşturur
- Her şehir için 10 ilçe oluşturur (toplam 200 ilçe)

#### 2. N+1 Problemini Görün (Sorunlu Yol)
```bash
php artisan tinker
```

```php
$counties = County::all();

// Debug Bar'ı açın veya:
// DB::enableQueryLog();

foreach ($counties as $county) {
    echo $county->city->name . "\n";
}

// DB::getQueryLog() ile sorguları görün - ~200+ sorgu!
```

#### 3. Çözümü Deneyin (İyileştirilmiş Yol)
```php
$counties = County::with('city')->get();

foreach ($counties as $county) {
    echo $county->city->name . "\n";
}

// DB::getQueryLog() ile sorguları görün - Sadece 2 sorgu!
```

#### 4. Web Uygulaması
```bash
php artisan serve
```

Ev sayfasında tablo verilerini görüntüleyin ve Debug Bar'da sorguları izleyin.

### Model İlişkileri

**County Model:**
```php
public function city()
{
    return $this->belongsTo(City::class);
}
```

**City Model:**
```php
public function counties()
{
    return $this->hasMany(County::class);
}
```

### Performans Karşılaştırması

| Yöntem | Sorgu Sayısı | Hız |
|--------|-------------|-----|
| N+1 Problemi | 201 | Yavaş ❌ |
| Eager Loading | 2 | Hızlı ✅ |

### Diğer Eager Loading Yöntemleri

```php
// İlişkili verileri yükle
County::with('city')->get();

// Birden çok ilişki
County::with('city', 'region')->get();

// İç içe ilişkiler
County::with('city.region')->get();

// Koşullu eager loading
County::with(['city' => function ($query) {
    $query->where('active', true);
}])->get();
```

### Kaynaklar

- [Laravel Eloquent: Relationships](https://laravel.com/docs/eloquent-relationships)
- [Laravel Eloquent: Eager Loading](https://laravel.com/docs/eloquent-relationships#eager-loading)
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
