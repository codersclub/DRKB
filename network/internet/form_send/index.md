---
Title: Как заполнить форму и отправить на сервер?
Author: Демо
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как заполнить форму и отправить на сервер?
==========================================

Для того, чтобы отправить форму на сервер, необходимо:

1. Найти форму в исходном тексте страницы.
Для этого найти в исходном тексте страницы теги `<form>...</form>`

    Например:

        <form method=GET action=http://localhost/cgi-bin/mget?>
        <input type=text name=name1 value="имя" size="40" maxlength="20"><br>
        <input type=text name=name2 value="фамилия" size="40" maxlength="20"><br>
        <input type=submit>
        </form>


2. Определить метод, который используется для отправки данных. В
указанном выше примере это "GET" - form method=GET

3. Найти поля, которые необходимо заполнить.

    В примере это:

        <input type=text name=name1 value="имя" size="40" maxlength="20"><br>
        <input type=text name=name2 value="фамилия" size="40" maxlength="20"><br>


4. Используя компоненты для работы с протоколом TCP/IP, сформировать
строку запроса.
Для определенности пусть это будет компонент TIdHTTP из пакета Indy,
входящий в стандартный набор компонент Delphi.


Сформируем строку для отправки на сервер для нашего примера:

Пусть нам нужно отправить значениядля полей: имя=Vasya, фамилия=Pupkin.

В этом случае запрос будет выглядеть так:

    var
      s: String;
    begin
      s := IdHTTP1.Get('http://localhost/cgi-bin/mget?name1=Vasya&name2=Pupkin')


В случае, если форма использует метод POST:

    <form method=POST action=http://localhost/cgi-bin/mget?>
    <input type=text name=name1 value="имя" size="40" maxlength="20"><br>
    <input type=text name=name2 value="фамилия" size="40" maxlength="20"><br>
    <input type=submit>
    </form>

формируем запрос для отправки несколько по-другому:

    var
      tL: TStringList;
      s: String;
    begin
      tL := TStringList.Create;
      tL.Add('name1=Vasya');
      tL.Add('name2=Pupkin');
      try
        s := IdHTTP1.Post('http://localhost/cgi-bin/mget',tL);
      finally
        tL.Free;
      end;

