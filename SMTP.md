# Исследование SMTP.

## Настройка сервера.

### DNS

* Настроить записи A, PTR, MX.

```
  example.com. IN A 22.11.33.44

  mail.example.com. IN A 11.22.33.44

  44.33.22.11.in-addr.arpa. IN PTR example.com.

  44.33.22.11.in-addr.arpa. IN PTR mail.example.com.

  example.com. IN MX 0 example.com.
  
  example.com. IN MX 10 mail.example.com.
```

* SPF запись.

  `mail.example.com. TXT "v=spf1 a mx ~all"`

* DKIM запись.

  `mail._domainkey.mail.example.com TXT "v=DKIM1; k=rsa; t=s; p=base64encode(public.pem)"`
  
  * Генерируем секретный ключ длинной 1024:
 
    `$ openssl genrsa -out private.pem 1024 `

  * Получаем публичный ключ из секретного:

    `$ openssl rsa -pubout -in private.pem -out public.pem `     

* DMARC (Domain-based Message Authentication, Reporting and Conformance) запись.

  Отправляет ежедневные отчеты.

  `_dmarc.mail.example.com TXT "v=DMARC1; p=none; rua=mailto:postmaster@mail.example.com"`

### Sendmail DKIM+SPF+DMARC

[Статья по настройке sendmail](https://habr.com/ru/post/415569/)

### STARTTLS

[Статья по настройке sendmail](http://samag.ru/archive/article/1766).

## Заголовки письма.

* Подписка. При Double-opt в письме с предложением подписаться.

```
    List-Subscribe: <url|email>

```

* Отписка. 
  
  ```
    List-Unsubscribe-Post: List-Unsubscribe=One-Click
    
    List-Unsubscribe: <url|email>
  ```

* Стоп слова (смотреть тут: [Рекомендации Яндекс](https://zen.yandex.ru/media/id/5d7b7eff35c8d800ad8f03b9/pisma-popadaiut-v-papku-spam-kak-otpravit-rassylku-vo-vhodiascie-5dc142772fda8600af6cb7ec))

## Стратегия отправки.

* Выбор и разогрев базы IP-адреса: выделенный или общий: наращивать объем постепенно.

* Добавлять новые адреса не больше, чем по 10% от объема существующей базы в неделю.

* Настройка FBL (Feedback Loop). Аналог List-Unsubscribe.

  Настраивается на каждом почтовике отдельно как я понял.
  
* Регулярно проверять репутацию адреса отправителя
  Настраивайте Postmaster Tools или Gmail – это инструменты для 
  проверки успешности доставки писем, которые предоставляют 
  такую информацию:
  
  * отмечают ли пользователи ваши письма как спам;
  * почему не доставляется информация;
  * обеспечивается ли безопасность при рассылке.

* По паузам - какие-то древние записи попадаются.
  
  По моему опыту это делается опытным путем. 
  Самое лучшее заранее рассчитать количество писем в день, и исходя из этого,
  рассчитать паузу между пачками писем.
  
  Создавал пачки писем (тоже регулировалось), скажем по 10-20 штук.
  
  Письма группировал по хосту:
    * MAIL.RU: *@mail.ru, *@inbox.ru, *@list.ru, *@bk.ru 
    * GMAIL.COM: *@gmail.com
  
  Пачки писем создавал с условием вхождения максимального количества групп.
