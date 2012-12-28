---
Title: Регистрация программ в меню «Пуск» Windows 95
Date: 01.01.2007
---


Регистрация программ в меню «Пуск» Windows 95
=============================================

::: {.date}
01.01.2007
:::

Подобная проблема возникает при создании инсталляторов и
деинсталляторов. Наиболее простой и гибкий путь - использование DDE. При
этом посылаются запросы к PROGMAN. Для этого необходимо поместить на
форму компонент для посылки DDE запросов - объект типа TDdeClientConv.
Для определенности назовем его DDEClient. Затем добавим метод для
запросов к PROGMAN:

    function TForm2.ProgmanCommand(Command: string): boolean;
    var
      macrocmd: array[0..88] of char;
    begin
      DDEClient.SetLink('PROGMAN', 'PROGMAN');
      DDEClient.OpenLink; { Устанавливаем связь по DDE }
      strPCopy(macrocmd, '[' + Command + ']'); { Подготавливаем ASCIIZ строку }
      ProgmanCommand := DDEClient.ExecuteMacro(MacroCmd, false);
      DDEClient.CloseLink; { Закрываем связь по DDE }
    end;
     
    // Пример использования:
    ProgmanCommand('CreateGroup(Комплекс программ для
      каталогизации литературы, )');
    ProgmanCommand('AddItem(' + path + 'vbase.hlp, Справка по VBase,
      '+ path +' vbase.hlp, 0, , , '+ path + ', , )');
    // где path - строка типа String, содержащая
    // полный путь к каталогу ('C:\Catalog\');

При вызове ProgmanCommand возвращает true, если посылка макроса была
успешна. Система команд (основных) приведена ниже:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ■   Create(Имя группы, путь к GRP файлу) Создать группу с именем \"Имя группы\", причем в нем могут быть пробелы и знаки препинания. Путь к GRP файлу можно не указывать, тогда он создастся в каталоге Windows.
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------
  ■   Delete(Имя группы) Удалить группу с именем \"Имя группы\"
  --- -----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------------------------------------------------
  ■   ShowGroup(Имя группы, состояние) Показать группу в окне, причем состояние - число, определяющее параметры окна:
  --- -----------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- ------------------------------------
  □   1-нормальное состояние + активация
  --- ------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- ---------------------
  □   2-миним.+ активация
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- ---------------------
  □   3-макс. + активация
  --- ---------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- ------------------------
  □   4-нормальное состояние
  --- ------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 72px;"}
  --- -------------
  □   5-Активация
  --- -------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  ■   AddItem(командная строка, имя раздела, путь к иконке, индекс иконки (с 0), Xpos,Ypos, рабочий каталог, HotKey, Mimimize) Добавить раздел к активной группе. В командной строке, имени размера и путях допустимы пробелы,
  --- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ------------------------------------------------------------------------------------------------------------------------------------
  ■   Xpos и Ypos - координаты иконки в окне, лучше их не задавать, тогда PROGMAN использует значения по умолчанию для свободного места.
  --- ------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -------------------------------------------
  ■   HotKey - виртуальный код горячей клавиши.
  --- -------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------
  ■   Mimimize - тип запуска, 0-в обычном окне, \<\>0 - в минимизированном.
  --- -----------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- -----------------------------------------------------------------------------
  ■   DeleteItem(имя раздела) Удалить раздел с указанным именем в активной группе
  --- -----------------------------------------------------------------------------
:::

 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0