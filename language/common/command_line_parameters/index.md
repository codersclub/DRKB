---
Title: Как использовать параметры коммандной строки?
Author: Vit
Date: 01.01.2007
---


Как использовать параметры коммандной строки?
=============================================

::: {.date}
01.01.2007
:::

Paramcount - показывает сколько параметров передано

Paramstr(0) - это имя с путем твоей программы

Paramstr(1) - имя первого параметра

Paramstr(2) - имя второго параметра и т.д.

Если ты запускаешь:

с:\\myprog.exe /a -b22 c:\\dev

то Paramcount будет равен 3

Paramstr(0) будет равен с:\\myprog.exe

Paramstr(1) будет равен /a

Paramstr(2) будет равен -b22

Paramstr(3) будет равен c:\\dev

Параметр это просто строка, набор букв, выполнить ее нельзя - ты можешь
только проверить на наличие строки и если она присутствует, то выполнить
какое либо действие, это действие ты должен написать сам, никаких
стандартных действий нет.

Например у тебя возможно 3 параметра:

Если параметр = "/v" то выдать сообщение, если параметр "/c" то
покрасить форму в синий цвет, если параметр "/f" - поменять заголовок
формы:

    if paramstr(1) = '/v' then
      showmessage('Parameter "/v" was found!');
    if paramstr(1) = '/c' then
      color := clBlue;
    if paramstr(1) = '/f' then
      caption := 'Parameter "/f" was found';

Поставь этот код на событие формы onActivate, откомпиллируй и попробуй
запустить программу с одним из 3х указанных параметров и ты увидишь что
произойдет.

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Функция

    function FindCmdLineSwitch(const Switch: string;
                               SwitchChars: TSysCharSet;IgnoreCase: Boolean ): Boolean; 
    type TSysCharSet = set of Char;

Функция определяет, была ли передана приложению в качестве параметра
командной строки строка Switch. Параметр IgnoreCase указывает должен ли
учитываться регистр. Параметр SwitchChars идентифицирует допустимые
символы-разделители (например, "-", "/").

Взято с <https://atrussk.ru/delphi/>
