---
Title: Как использовать клавишу-акселератор в TTabSheet (TPageControl)
Date: 01.01.2007
---


Как использовать клавишу-акселератор в TTabSheet (TPageControl)
===============================================================

::: {.date}
01.01.2007
:::

Вопрос:

Как использовать клавишу-акселератор в TTabsheets? Я добавляю
клавишу-акселератор в заголовок каждого Tabsheet моего PageControl, но
при попытке переключать страницы этой клавишей программа пикает и ничего
не происходит.

Вариант 1:

    { 
      With menus (and labels), If you use the '&' character in the caption of a menu, 
      you can access that menu item with the short cut key. 
      With this code you can do the same thing with TTabSheet objects 
      that are used with TPageControl objects. 
     
      Zugriffstasten ermoglichen die Ausfuhrung eines Menubefehls mit Hilfe der Tastatur. 
      Der Benutzer braucht nur die Taste Alt und den mit dem Zeichen & kombinierten 
      Buchstaben zu drucken. 
     
      Dieser code erlaubt dieselebe Funktionalitat fur ein 
      TTabSheet eines TPageControls. 
    }
     
     // in form declaration 
    private
       procedure CMDialogChar(var Msg: TWMCHAR); message CM_DIALOGCHAR;
     end;
     
        type
       TPageControlCracker = class(TPageControl);
     
     {...}
     
     implementation
     
       procedure TForm1.CMDialogChar(var Msg: TWMCHAR);
       var
         i: Integer;
       begin
         if (Msg.keydata and $20000000) <> 0 then
         begin
           { Alt key is down }
           with TPageControlCracker(PageControl1) do
             for i := 0 to PageCount - 1 do
             begin
               if IsAccel(Msg.charcode, Pages[i].Caption) then
               begin
                 if CanChange then
                 begin
                   ActivePage := Pages[i];
                   Msg.Result := 1;
                   Change;
                   Exit;
                 end; { If }
               end;  { If }
             end; {For}
         end; {If}
         inherited;
       end;

Взято с сайта: <https://www.swissdelphicenter.ch>

------------------------------------------------------------------------
Вариант 2:

Можно перехватить сообщение CM\_DIALOGCHAR

    type
      TForm1 = class(TForm)
        PageControl1: TPageControl;
        TabSheet1: TTabSheet;
        TabSheet2: TTabSheet;
        TabSheet3: TTabSheet;
      private
        {Private declarations}
        procedure CMDialogChar(var Msg:TCMDialogChar);
        message CM_DIALOGCHAR;
      public
        {Public declarations}
      end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.CMDialogChar(var Msg:TCMDialogChar);
    var
      i: integer;
    begin
      with PageControl1 do
      begin
        if Enabled then
          for i := 0 to PageControl1.PageCount - 1 do
            if ((IsAccel(Msg.CharCode, Pages[i].Caption)) and
            (Pages[i].TabVisible)) then
            begin
              Msg.Result:=1;
              ActivePage := Pages[i];
              exit;
            end;
      end;
      inherited;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------
Вариант 3:

TPageControl, расположенный на закладке Win95 палитры компонентов, в
настоящий момент не может работать с акселераторами. Тем не менее, в
наших силах создать потомок TPageControl, поддерживающий вышеназванную
характеристику.

В приведенном ниже коде показана реализация такого компонента. Наследник
TPageControl осуществляет захват и обработку сообщения CM\_DIALOGCHAR.
Это позволяет перехватывать комбинации клавиш, которые могут быть
акселератороми для данной формы. Обработчик со бытия CMDialogChar
использует функцию IsAccel, которая позволяет определить, имеет ли
отношение перехваченный код клавиш к акселератору одной из страниц
TPageControl. В этом случае делаем страницу активной и передаем ей
фокус.

    unit tapage;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics,
      Controls, Forms, Dialogs, ComCtrls;
     
    type
     
      TAPageControl = class(TPageControl)
      private
        procedure CMDialogChar(var Msg: TCMDialogChar); message CM_DIALOGCHAR;
      end;
     
    procedure Register;
     
    implementation
     
    procedure TAPageControl.CMDialogChar(var Msg: TCMDialogChar);
    var
      i: Integer;
      S: string;
    begin
      if Enabled then
        for I := 0 to PageCount - 1 do
          if IsAccel(Msg.CharCode, Pages[i].Caption) and
            Pages[I].TabVisible then
          begin
            Msg.Result := 1;
            ActivePage := Pages[I];
            Change;
            Exit; // выход из цикла.
          end;
      inherited;
    end;
     
    procedure Register;
    begin
      RegisterComponents('Test', [TAPageControl]);
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
