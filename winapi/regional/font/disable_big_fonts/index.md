---
Title: Защита приложений от крупных шрифтов
Date: 01.01.2004
Author: Андрей Чудин, ЦПР ТД Библио-Глобус.
Source: https://delphi.chertenok.ru
---

Защита приложений от крупных шрифтов
====================================

Вы когда-нибудь проверяли, как будет выглядеть написанная вами с такой
любовью программа с системе с крупными шрифтами? Согласитесь, это
неприглядное зрелище. Наползающие друг на друга метки и поля
редактирования, надписи, которые заканчиваются где то за пределами формы
и т.п. После этого появляется неконтролируемая неприязнь к
пользователям, которые предпочитают режим крупных шрифтов. Но это их
право. И ваша проблема.

Вы наверняка задавались вопросом о том, как избежать искажений. И
находили в сети одни и те же рецепты: использовать шрифты TrueType и
отключать свойство Scaled у форм. Рецепт, предлагающий использовать
только шрифты TrueType + Scaled = False для форм - верен. Однако тут
есть некоторые неудобства.

Дело в том, что ни один из стандартных TrueType шрифтов не сравнится по
качеству отображения с MS Sans Serif, который по умолчанию используется
в вашем приложении. Самый близкий - Arial все же имеет довольно заметные
отличия и проигрывает MS Sans Serif по читаемости.

Искажений форм так же полностью избежать не удастся. Особенно это может
повлиять на компоновку сложных форм, а также при использовании в
интерфейсе изображений и прочих немасштабируемых элементов. Иногда
хочется просто запретить масштабирование и защитить программу от влияния
крупных шрифтов. Но использовать MS Sans Serif в этом случае нельзя, так
как в режиме крупных шрифтов система "сдвигает" их на 2 пункта вверх и
шрифт 8pt MS Sans Serif выглядит как 10pt MS Sans Serif при мелких
шрифтах.

Для справки:

> В режиме стандартных размеров шрифтов в качестве системного
> используется, в основном, MS Sans Serif - рубленый шрифт без засечек. Он
> имеет размеры 8pt, 10pt, 12pt, 14pt, 18pt и 24pt. В основном
> используется размер 8pt. В режиме крупных шрифтов система увеличивает
> все шрифты на 120%. ( С 96 pixels per inch до 120 pixels per inch).
> Шрифт MS Sans Serif имеет всего 6 размеров. Поэтому 8pt становится 10pt,
> 10pt - 12pt и т.д. Шрифт 8pt MS Sans Serif выглядит как 10pt MS Sans
> Serif при мелких шрифтах. Шрифты же TrueType могут имеют произвольные
> размеры и шаг изменения равен 1pt. Поэтому при крупных шрифтах размеры
> TrueType и не-TrueType шрифтов изменяются по разному

Предлагаемое решение способно защитить программу от влияния режима
крупных шрифтов и не отказываться от шрифта MS Sans Serif при разработке
программы. Подход состоит в том, чтобы заменять все шрифты MS Sans Serif
на Arial при запуске программы при крупных шрифтах. Создавать программу,
естественно, следует при мелких шрифтах.

Можно написать невизуальный компонент и добавить его на каждую форму.
Компонент при загрузке проверяет режим и при обнаружении режима "Big
Fonts" "обходит" все визуальные компоненты для замены шрифта. Также
компонент заботится о том, чтобы свойство Scaled у форм было отключено.

    unit glSmallFontsDefence; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs; 
     
    type 
      TglSmallFontsDefence = class(TComponent) 
      private 
        procedure UpdateFonts(Control: TWinControl); 
        { Private declarations } 
      protected 
        procedure Loaded; override; 
      public 
        constructor Create(AOwner: TComponent); override; 
      published 
        { Published declarations } 
      end; 
     
    procedure Register; 
     
    implementation 
     
    function IsSmallFonts: boolean;{Значение функции TRUE если мелкий шрифт} 
    var DC: HDC; 
    begin 
      DC:=GetDC(0); 
      Result:=(GetDeviceCaps(DC, LOGPIXELSX) = 96); 
      { В случае крупного шрифта будет 120} 
      ReleaseDC(0, DC); 
    end; 
     
    procedure Register; 
    begin 
      RegisterComponents('Gl Components', [TglSmallFontsDefence]); 
    end; 
     
    { TglSmallFontsDefence } 
     
    constructor TglSmallFontsDefence.Create(AOwner: TComponent); 
    begin 
      inherited; 
      if (Owner is TForm) then (Owner as TForm).Scaled := false; 
    end; 
     
    procedure TglSmallFontsDefence.Loaded; 
    begin 
      inherited; 
      if (Owner is TForm) then (Owner as TForm).Scaled := false; 
      if csDesigning in ComponentState then 
      begin 
        if not IsSmallFonts then 
          ShowMessage('Проектирование приложения в режиме крупных' +
                       ' шрифтов недопустимо!'#13#10+
                      'Компонент TglSmallFontsDefence отказывается' +
                      ' работать в таких условиях.'); 
      end else 
        UpdateFonts((Owner as TForm)); 
    end; 
     
    procedure TglSmallFontsDefence.UpdateFonts(Control: TWinControl); 
    var 
      i: integer; 
      procedure UpdateFont(Font: TFont); 
      begin 
        if CompareText(Font.Name, 'MS Sans Serif') <> 0 then exit; 
        Font.Name := 'Arial'; 
      end; 
    begin 
      if IsSmallFonts then exit; 
      UpdateFont(TShowFont(Control).Font); 
      with Control do 
      for i:=0 to ControlCount-1 do 
      begin 
        UpdateFont(TShowFont(Controls[i]).Font); 
        if Controls[i] is TWinControl then UpdateFonts(Controls[i] as TWinControl); 
      end; 
     
    end; 
     
     
    end.

Вы можете добавить свойство Options типа перечисления, в котором задать
опции исключения некоторых классов компонентов. К примеру, можно
добавить возможность отключать замену шрифтов для потомков TCustomGrid.
Очень часто пользователи используют режим крупных шрифтов, чтобы
улучшить читаемость таблиц данных (TDBGrid). Тогда не надо лишать их
этой возможности.

составление статьи: Андрей Чудин, ЦПР ТД Библио-Глобус.
