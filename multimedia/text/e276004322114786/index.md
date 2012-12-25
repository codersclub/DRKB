---
Title: Отображение текста с тегами форматирования
Date: 01.01.2007
---


Отображение текста с тегами форматирования
==========================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> Отображение текста с тегами форматирования
     
    Рисует строку текста, содержащую теги форматирования, походие на теги HTML.
     
    Поддерживаются следующие теги:
    <b>..</b> Полужирный
    <i>..</i> Наклонный
    <u>..</u> Подчёркнутый
    <s>..</s> Перечёркнутый
     
    <big[ n]>..</big> Увеличить ращмер шрифта на n единиц (по умолчанию 1)
    <small[ n]>..</small> Уменьшить шрифт на n единиц (по умолчанию 1)
     
    <sub>..</sub> Нижний индекс
    <sup>..</sup> Верхний индекс
    Для правильного отображения внутри тегов <sub> и <sup> не должно располагаться других тегов
     
    <font name="Имя шрифта" size="Размер" color="Цвет" charset="Кодовая страница">..</font> 
    Установка параметров шрифта.
    Размер шрифта указывается как для свойства TFont.Size, а не как в HTML. 
    В качестве цвета можно указывать либо константы clXXXX либо числа в формате #RRGGBB, 
    где RR GG и ВВ соответственно шестнадцатеричные значения 00..FF красной, 
    зелёной и синей составляющей, HTML цвета не поддерживаются. В параметре charset 
    указываются константы XXXX_CHARSET, например RUSSIAN_CHARSET или ANSI_CHARSET
     
    Зависимости: Windows, SysUtils, Classes, Graphics, Dim
    Автор:       Dimka Maslov, mainbox@endimus.com, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        17 марта 2004 г.
    ***************************************************** }
     
    unit HtDraw;
     
    interface
     
    uses Windows, SysUtils, Classes, Graphics, Dim;
     
    type
      TTag = class;
     
      THtDraw = class(TObject)
      private
        FTag: TTag;
        FText: TString;
        procedure SetText(Value: TString);
      public
        function Draw(Canvas: TCanvas; X, Y: Integer): Integer;
        // Canvas - устройство для отображения текста.
        // в свойстве Canvas.Font задаются начальные параметры шрифта
        // X, Y - начальные координаты
        // Функция возвращает сумму X и ширины выведенного текста
        property Text: TString read FText write SetText;
        // Задаёт текст для отображения. В отличие от свойств компонентов,
        // присвоение значения этого свойства не приводит к автоматической
        // перерисовке. Необходимо вызывать метод Draw
        constructor Create(const AText: TString);
        destructor Destroy; override;
      end;
     
     

Полный текст модулей располагается по адресам:

HtDraw: http://downloads.endimus.com/htdraw.zip

Dim : http://downloads.endimus.com/dimpas.zip

Пример использования:

    var
      HtDraw: THtDraw;
    begin
      HtDraw :=
        THtDraw.Create('<b>T</b><i>e</i><u>s</u><s>t</s>');
      try
        HtDraw.Draw(Canvas, 10, 10);
      finally
        HtDraw.Free;
      end;
    end;
