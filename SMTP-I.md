# Исследование SMTP.

## Простая отсылка через mail()

### Код

```php

        $config = $this->getDI()["config"];
        ini_set('mail.log', $config["mailer"]->log);
        ini_set('smtp_port', (int)$config["mailer"]->port);
        ini_set('sendmail_from', $config["mailer"]->from);
        ini_set('smtp_ssl', $config["mailer"]->ssl);
        ini_set('smtp_server', $config["mailer"]->server);
        ini_set('auth_password', $config["mailer"]->password);
        ini_set('auth_password', $config["mailer"]->password);

        $to      = $config["mailer"]->to;
        $subject = 'Test send';
        $message = '<h1>Hello!</h1>';

        $headers = [
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html',
        ];

        mail($to, $subject, $message, $headers);

```

### Что пришло на сервер

```text

Delivered-To: xxx@gmail.com
Received: by 2002:aa7:c391:0:0:0:0:0 with SMTP id k17csp92073edq;
        Wed, 26 Aug 2020 21:44:33 -0700 (PDT)
X-Google-Smtp-Source: ABdhPJyrEjbB0KsW7g5xTDEAQjUf23Bm//LLx51GATeIx/ZAORu/pF9fCxWH24PhOzbYQpLYbpQv
X-Received: by 2002:ac2:4c0a:: with SMTP id t10mr9134666lfq.90.1598503472992;
        Wed, 26 Aug 2020 21:44:32 -0700 (PDT)
ARC-Seal: i=1; a=rsa-sha256; t=1598503472; cv=none;
        d=google.com; s=arc-20160816;
        b=UurM6gcWGS9Y5ux/Cf45ACoqiwnVKiGkdSe4vB4ODqZKI7GNkLnpoVV3iJJDk9nWu9
         Y2N2Isla+G3heMoyUQWBJ93O4vtutZsPfbOxBh5hcZl+mRoU0alljfUKtB1YvjUJWNhc
         wU2vOQ3xeRkEsthzLQaP5zlkAJ0DdoYYIRfEpwniJDSyMu83DuCVfndYOEpKhGiD7a4H
         FfwjucNBV5c8XN467Dk7qQ8lQcBrZOl9OSJ9D60YxDeDf+nJxpwbQBlclxZ4epEdmaq8
         p+hIPa8HR61W6lAB7fKw9D7PvhhLW0kRjpPNnX9u9Qf/9FMqeRUh1eUtq/K7eHVJWjNt
         +tcw==
ARC-Message-Signature: i=1; a=rsa-sha256; c=relaxed/relaxed; d=google.com; s=arc-20160816;
        h=mime-version:subject:to:message-id:from:date;
        bh=8FYa6ZJ2ZtE07VDVW47/Ni51bN4+BxYVzfYl9Q6uwqo=;
        b=VmBYWDOdvq9fJQ9OXeMIQRr6pCE0UK/qEg1VUSbiT0VPVZgaC2RGTg8OXanS1kCjyY
         QnV5IVSS6GvgGXDKr0AOlwvhQVJ5bGkDf+6sf02kH2V/EvOeFPzKSvDSnlsHt95t8bIz
         0+1ePsY+sxdI3oMuAIpjUNYhQXmzKrDvxyZme5K9wjsfqr7elpz1gWVoomU7NQwBmAvV
         +4jxGteVDoDfUOJeDyAgRBgGcMmGAe9yLJJ9IFDULxsG+dXKgXcZx6C6fl0jb3MNaqGu
         jub1UGhIxtX5HcaJZ+CzTMEUfm2AM2/Mdrk3Di7BT8KeL/UrdLFJu3hTW+skg5EE+GHn
         TC0g==
ARC-Authentication-Results: i=1; mx.google.com;
       spf=neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) smtp.mailfrom=demagog@demagog.demagog
Return-Path: <demagog@demagog.demagog>
Received: from demagog.demagog (ppp111-222-333-444.pppoe.komi.dslavangard.ru. [111.222.333.444])
        by mx.google.com with ESMTPS id i81si659837lfi.79.2020.08.26.21.44.32
        for <xxx@gmail.com>
        (version=TLS1_3 cipher=TLS_AES_256_GCM_SHA384 bits=256/256);
        Wed, 26 Aug 2020 21:44:32 -0700 (PDT)
Received-SPF: neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) client-ip=111.222.333.444;
Authentication-Results: mx.google.com;
       spf=neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) smtp.mailfrom=demagog@demagog.demagog
Received: from demagog.demagog (localhost [127.0.0.1]) by demagog.demagog (8.15.2/8.15.2/Debian-14~deb10u1) with ESMTP id 07R4iWsM001516 for <xxx@gmail.com>; Thu, 27 Aug 2020 07:44:32 +0300
Received: (from demagog@localhost) by demagog.demagog (8.15.2/8.15.2/Submit) id 07R4iWOj001514; Thu, 27 Aug 2020 07:44:32 +0300
Date: Thu, 27 Aug 2020 07:44:32 +0300
From: demagog <demagog@demagog.demagog>
Message-Id: <202008270444.07R4iWOj001514@demagog.demagog>
To: xxx@gmail.com
Subject: Test send
MIME-Version: 1.0
Content-Type: text/html

<h1>Hello!</h1>

```

### Google совет


**Почему это письмо попало в папку "Спам"?**

Фильтры ранее распознавали аналогичные письма как спам.

### Итог

* Письмо попадает в спам.

* Не выставлены некоторые заголовки.

* Некоторые заголовки выставлены неверно.

## Простая отсылка через mail() с дополнительными заголовками

### Код

```php

        $headers = [
            'From'         => $config["mailer"]->from,
            'Reply-To'     => $config["mailer"]->from,
            'Return-Path'  => $config["mailer"]->from,
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html',
        ];

```

### Что пришло на сервер

```text

Delivered-To: xxx@gmail.com
Received: by 2002:aa7:c391:0:0:0:0:0 with SMTP id k17csp106713edq;
        Wed, 26 Aug 2020 22:15:47 -0700 (PDT)
X-Google-Smtp-Source: ABdhPJwGvnNfSqBYJVo/vfVRCvCNc1/tDjs4x9Y8rtS8ux3WjlO99LvY6sPiXMiuf/024z+wXcb+
X-Received: by 2002:a2e:a556:: with SMTP id e22mr7889623ljn.317.1598505347586;
        Wed, 26 Aug 2020 22:15:47 -0700 (PDT)
ARC-Seal: i=1; a=rsa-sha256; t=1598505347; cv=none;
        d=google.com; s=arc-20160816;
        b=Nn/QdTwwko7PwnlyZWH6l1OkRCu6O+IktMxYUbTStvBWX91/1F9adZ5Y3vfS4zPMq7
         HRaqfhF51KSc/zwRt0Zu41qrJq3di7aeiZvryzS5WrzCxS6+qRlM2f5XLUl3r1mEocQM
         apCh1GHa2l3M/DTpbINbbrGcB/FcJtoL3hybB8lUO+r0gZFp+J1Fk/dUQJpGdVDi/v6k
         nDGw+jQlJCEmMoRFZVSjgtgcMKb0dS7fJxajh/LXGnOoCiBqppZdNHjoVkbBV1LJ0R0k
         zNRsDPcq4bpo5oxMj13Wel9RUYJs6bGxAbcXRHhwftZ/bAyuiAVbFbCQeaujwoaUhREa
         532g==
ARC-Message-Signature: i=1; a=rsa-sha256; c=relaxed/relaxed; d=google.com; s=arc-20160816;
        h=mime-version:reply-to:from:subject:to:message-id:date;
        bh=8FYa6ZJ2ZtE07VDVW47/Ni51bN4+BxYVzfYl9Q6uwqo=;
        b=otuOXAPT18lqXq1K3XWQFxK04c8dMQsMNEMtQJrv3pcGVCe7usLiRSKVFCQwowDOLp
         H6yRhDAtTscVOI4hO1wj5lIiPissa/gYcu9SwDKxDiMQNtnmI2ISfnbaDCVxNmE6Lop/
         CBo6s7IF3c22s9WOsTEQizzxpwXzxoJPexcqfNxhUj7Ug8JWBNWCVQnAWXhbv5Hbc1Jl
         MRcxrd//LVAFJ1dokNCmxHZqbhljoT5MXWI+48rNpsRG7sDFD7iA7vJYT7f6uVDH+jyB
         zT2DOsoBJSpwEfip9Voo2/QVdshynYIhOCAH6kPM+9kQVZb4g7/j2oO0t0BS/xMCv0l/
         Qc8w==
ARC-Authentication-Results: i=1; mx.google.com;
       spf=neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) smtp.mailfrom=demagog@demagog.demagog;
       dmarc=fail (p=NONE sp=QUARANTINE dis=NONE) header.from=gmail.com
Return-Path: <demagog@demagog.demagog>
Received: from demagog.demagog (ppp111-222-333-444.pppoe.komi.dslavangard.ru. [111.222.333.444])
        by mx.google.com with ESMTPS id p19si655010ljg.114.2020.08.26.22.15.47
        for <xxx@gmail.com>
        (version=TLS1_3 cipher=TLS_AES_256_GCM_SHA384 bits=256/256);
        Wed, 26 Aug 2020 22:15:47 -0700 (PDT)
Received-SPF: neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) client-ip=111.222.333.444;
Authentication-Results: mx.google.com;
       spf=neutral (google.com: 111.222.333.444 is neither permitted nor denied by best guess record for domain of demagog@demagog.demagog) smtp.mailfrom=demagog@demagog.demagog;
       dmarc=fail (p=NONE sp=QUARANTINE dis=NONE) header.from=gmail.com
Received: from demagog.demagog (localhost [127.0.0.1]) by demagog.demagog (8.15.2/8.15.2/Debian-14~deb10u1) with ESMTP id 07R5Fkvf005868 for <xxx@gmail.com>; Thu, 27 Aug 2020 08:15:46 +0300
Received: (from demagog@localhost) by demagog.demagog (8.15.2/8.15.2/Submit) id 07R5FkkW005867; Thu, 27 Aug 2020 08:15:46 +0300
Date: Thu, 27 Aug 2020 08:15:46 +0300
Message-Id: <202008270515.07R5FkkW005867@demagog.demagog>
To: xxx@gmail.com
Subject: Test send
From: bulk.bulk.slatel@gmail.com
Reply-To: bulk.bulk.slatel@gmail.com
MIME-Version: 1.0
Content-Type: text/html

<h1>Hello!</h1>
```

### Google совет

**Будьте осторожны!**

Системе Gmail не удалось подтвердить, что это письмо отправлено отсюда: bulk.bulk.slatel@gmail.com. Не рекомендуем нажимать на ссылки в этом письме, скачивать прикрепленные файлы и сообщать отправителю свои личные данные.

`<button>`Сообщить о фишинге`</button>`

### Итог

* Попадает в спам

* Несмотря на явно заданные заголовки, они переписаны sendmail

```text
  Return-Path: <demagog@demagog.demagog>
  Received: from demagog.demagog 

```

## Отправка с помощью telnet

### Код

```text

# openssl s_client -connect smtp.gmail.com:465 -crlf -ign_eof
CONNECTED(00000003)
220 smtp.gmail.com ESMTP u18sm225386ljj.3 - gsmtp

EHLO localhost
250-smtp.gmail.com at your service, [111.222.333.444]
250-SIZE 35882577
250-8BITMIME
250-AUTH LOGIN PLAIN XOAUTH2 PLAIN-CLIENTTOKEN OAUTHBEARER XOAUTH
250-ENHANCEDSTATUSCODES
250-PIPELINING
250-CHUNKING
250 SMTPUTF8

AUTH PLAIN XXXXXXX
235 2.7.0 Accepted

MAIL FROM: <bulk.bulk.slatel@gmail.com>
250 2.1.0 OK h11sm219742ljb.58 - gsmtp

rcpt to: <xxx@gmail.com>
250 2.1.5 OK h11sm219742ljb.58 - gsmtp
DATA

354  Go ahead h11sm219742ljb.58 - gsmtp
Hey!!!

I`m here!

.

250 2.0.0 OK  1598506577 h11sm219742ljb.58 - gsmtp

quit
221 2.0.0 closing connection h11sm219742ljb.58 - gsmtp
read:errno=0

```

### Что пришло на сервер

```text

Delivered-To: xxx@gmail.com
Received: by 2002:aa7:c391:0:0:0:0:0 with SMTP id k17csp116126edq;
        Wed, 26 Aug 2020 22:36:17 -0700 (PDT)
X-Received: by 2002:a19:7512:: with SMTP id y18mr6838845lfe.19.1598506577771;
        Wed, 26 Aug 2020 22:36:17 -0700 (PDT)
ARC-Seal: i=1; a=rsa-sha256; t=1598506577; cv=none;
        d=google.com; s=arc-20160816;
        b=Nyx0ARe9Ix652GvSpHlhB44iQPlmcjzMz3hirGPSQSQEYY7QWQuSOUlHIpQA0PjGaT
         lwrB4OyUffBtdQ7WXEuG82YWmEykozzet6MXtE2kx9oIdGSKZcQqJKgrvkTcr/PNfIeR
         vLgX8kYZv/5Y37TGhd4BXn8WTdwDedLIM9Hs+4EwuAvrHWIViCkrDqGr2Uce6y49aPe7
         92tIe5ttC6V74Kbr+Gb4zuMa3d2x1AKzdIXpltLYsIrEac9UTPGc+kkcztFTcXXkEbn+
         xwuL9HjSY1Pxm3Su0QC4sqZPxLTMqSu7nPCHz34ELbYbJSuZt4baztalxH7gg2XPtA51
         F/sQ==
ARC-Message-Signature: i=1; a=rsa-sha256; c=relaxed/relaxed; d=google.com; s=arc-20160816;
        h=from:date:message-id:dkim-signature;
        bh=3kgzqlfC8VudK0lqt3tPvpbw0jkbgOsshXmn3xIygGo=;
        b=SfjHPBubZ6Au9Q4sGJoAVLUgOmQ8xU/b8PBNUSjgcmnSJmXgULaLnNgU6TUNrHNfqG
         iZrHli2uZYDhY5M9k1Qhc7f450sE9AYhA6jx7NQvR/hOCi5YBsy2FrOTdLxUJ+qbj0e8
         OJK2XShAubcrB4mC5JUdKb9N5G5kDmy1KnlC0Zn77vDpn6eAfVLAanlHe435DTxoQfic
         vosvBfs+LrIQeKzA+MISYBm9JFsynTksDLGWxrZyF/foI3tFMnNPbl/Nh2BcFCpPPsGs
         gjnAWbwGAi37HzGPWX3f6dDMxEovkzQ2vafcEV5FK0KZAX67KeGJxliYvwgTN6nevs5d
         k/uA==
ARC-Authentication-Results: i=1; mx.google.com;
       dkim=pass header.i=@gmail.com header.s=20161025 header.b="J/xwgf9v";
       spf=pass (google.com: domain of bulk.bulk.slatel@gmail.com designates 209.85.220.65 as permitted sender) smtp.mailfrom=bulk.bulk.slatel@gmail.com;
       dmarc=pass (p=NONE sp=QUARANTINE dis=NONE) header.from=gmail.com
Return-Path: <bulk.bulk.slatel@gmail.com>
Received: from mail-sor-f65.google.com (mail-sor-f65.google.com. [209.85.220.65])
        by mx.google.com with SMTPS id r8sor412670ljh.46.2020.08.26.22.36.17
        for <xxx@gmail.com>
        (Google Transport Security);
        Wed, 26 Aug 2020 22:36:17 -0700 (PDT)
Received-SPF: pass (google.com: domain of bulk.bulk.slatel@gmail.com designates 209.85.220.65 as permitted sender) client-ip=209.85.220.65;
Authentication-Results: mx.google.com;
       dkim=pass header.i=@gmail.com header.s=20161025 header.b="J/xwgf9v";
       spf=pass (google.com: domain of bulk.bulk.slatel@gmail.com designates 209.85.220.65 as permitted sender) smtp.mailfrom=bulk.bulk.slatel@gmail.com;
       dmarc=pass (p=NONE sp=QUARANTINE dis=NONE) header.from=gmail.com
DKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed;
        d=gmail.com; s=20161025;
        h=message-id:date:from;
        bh=3kgzqlfC8VudK0lqt3tPvpbw0jkbgOsshXmn3xIygGo=;
        b=J/xwgf9vfboTwHN3vhY+6MeXouEtodFIqmFVRXvTNgHrFFNyKN3lCZNflpl3F3A+BD
         lBkQ6/qQYGnPFPrTKvqJkS9S+J9Wjk197oXpfL2NTDAvmUxwLWLoNUDIUHJSdJwmnBt+
         m6Mt/9uQIt2xBAu8n/EhEHql/0oMKQyA9U/jpB94YvsJZ9P2jfXoTPq09GcmIIpyoVxj
         7gAkfOs86dsZ9y1N5DtySUObopn/ZN0ulifY1jO/BTxA8F95t2CwxJP7ePq/scwTWzhl
         wCGoQjg2FIYeX6wW2EuYOYt1H0kW5KEPTOAoqokJB6u5UqSYJ/CLaaZEfS+VoWcGT28U
         7xJA==
X-Google-DKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed;
        d=1e100.net; s=20161025;
        h=x-gm-message-state:message-id:date:from;
        bh=3kgzqlfC8VudK0lqt3tPvpbw0jkbgOsshXmn3xIygGo=;
        b=GkVpdH8BH8EclzvRsKelETyOQlgmJuOYCDrl17mhMdPouULpmIeKBZVjdqLgxr8Knz
         9bAeWFpXz33rK6vtAdEtVGI0fTzuIYP5ngtJws1ckmpht8x46kPcZHtZ5ir1oy566z4m
         sa4ro2CpGLNL449cSaTTwq47Y7cnWqYuuSmL0c7GkPzJrM9X2yqkzeIkWB0i5lwCscug
         gA62ibxBiD1POS2dfg4MxCfctHIp0U84xz3lJAfwSUf0wpLLzJyegj/FPU4eRgMgMX67
         s1wybdqsBTjAM+AHmOOUccUHmTuHliaa96e48YvoufgRaudPdZRLcyeFXFh1CMFciYg2
         CpOg==
X-Gm-Message-State: AOAM530dHLdAYtkQiZqN3MpI/7drc/dtWO+BlL6++JyFRlEvgmlLLeJ9 T+yAaR3doxy3CSApaOdPufVEfXYI2NtYqIfA
X-Google-Smtp-Source: ABdhPJyWTTF9XYD0DUL5e0s08hYd4FSvl40+wX13CYH5yJexHDsMR8vJRmtvMRNbD0z6iNJGfnvciQ==
X-Received: by 2002:a2e:9202:: with SMTP id k2mr8351587ljg.297.1598506577248;
        Wed, 26 Aug 2020 22:36:17 -0700 (PDT)
Return-Path: <bulk.bulk.slatel@gmail.com>
Received: from localhost (ppp111-222-333-444.pppoe.komi.dslavangard.ru. [111.222.333.444])
        by smtp.gmail.com with ESMTPSA id h11sm219742ljb.58.2020.08.26.22.34.46
        for <xxx@gmail.com>
        (version=TLS1_3 cipher=TLS_AES_256_GCM_SHA384 bits=256/256);
        Wed, 26 Aug 2020 22:36:16 -0700 (PDT)
Message-ID: <5f474650.1c69fb81.64e6e.0b20@mx.google.com>
Date: Wed, 26 Aug 2020 22:36:16 -0700 (PDT)
From: bulk.bulk.slatel@gmail.com

Hey!!!

I`m here!

```

### Итог

* В спам не попадает.
