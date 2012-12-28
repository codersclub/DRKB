---
Title: Установка и использование IDA Pro
Date: 01.01.2007
---


Установка и использование IDA Pro
=================================

::: {.date}
01.01.2007
:::

Дизассемблер позволяет получить ассемблерный текст программы из
машинного кода (.exe или .dll модуля). Многие дизассемблеры могут
определять имена вызываемых программой API-функций. IDA Pro отличается
от других дизассемблеров тем, что он способен опознавать имена не только
API-функций, но и функций из MFC (Microsoft Foundation Class -
используется программами, написанными на Visual C++) и OWL (Object
Windows Library - используется программами, написанными на Borland C++),
а также стандартных функций языка Си (таких как fread(), strlen() и
т.д.), включенных в код программы.

Установка программы обычно не вызывает никаких проблем. После запуска
дизассемблера (файл idaw.exe) появляется окно сессии DOS. Не пугайтесь,
IDA Pro - нормальное 32-разрядное приложение, просто оно консольное
(работает в окне сессии DOS). Именно поэтому интерфейс IDA Pro
напоминает интерфейс обычной DOS-программы.

Отметим несколько моментов, на которые Вам следует обратить внимание
перед началом работы с IDA Pro:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- --------------------------------------------------------------------------------------
  ·   Практически все настройки (кроме цветовой палитры) осуществляются через файл ida.cfg
  --- --------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   В первую очередь, давайте поменяем размеры экрана программы. Установленный по умолчанию размер на разрешении 1024\*768 не очень удобен, поэтому лучше заменить строку
  --- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

SCREEN\_MODE = 0 (по умолчанию 32 строки по 80 символов)

на

SCREEN\_MODE = 0x783B (59 строк по 120 символов)- для разрешения
1024х768

это максимальный размер окна, которое умещается на экране. Если у Вас
800х600, можете ничего не менять.

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   При работе с программой я обнаружил одну странную вещь: когда я закрываю IDA Pro, выдается два сообщения о том, что программа выполнила недопустимую операцию и будет закрыта (происходит ошибка при смене видеорежима). Чтобы этого избежать, нужно принудительно установить размер используемого программой шрифта. Для этого:
  --- ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- --------------------------------------------------------------------------
  ·   Запомните, как выглядит окно программы при автоматическом выборе шрифта.
  --- --------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 40px;"}
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Из конкретных значений размера шрифта выберите тот, при котором окно примет первоначальный вид. После этого никаких проблем при закрытии программы быть не должно.
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 14px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ·   Для того чтобы не производить подобные изменения при каждом запуске программы, нужно соответствующим образом изменить свойства запускаемого файла. Но установить конкретный размер шрифта при запуске для файла idaw.exe не представляется возможным, т.к. это не DOS-программа, а Windows-приложение и не имеет подобных установок. Лично я для этих целей использую собственный командный файл (файл с расширение .bat). Он содержит только одну строку: idaw.exe В свойствах idaw.bat (так я назвал свой файл) я установил необходимый размер шрифта (для приведенных значений разрешения и размера окна это шрифт 8х12). Теперь, вместо idaw.exe я запускаю idaw.bat - никаких проблем при закрытии больше не возникает.
  --- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

О приемах работы с IDA Pro Вы познакомитесь в следующих статьях на
примере работы с конкретными программами, или можете обратиться к ее
полному описанию, которое скоро появится в разделе Описание
инструментов. Что ж, со всеми описаниями мы закончили, в следующей
статье приступим к исследованию конкретной программы - WinZip 7.0
(beta).

Взято с <https://delphiworld.narod.ru>