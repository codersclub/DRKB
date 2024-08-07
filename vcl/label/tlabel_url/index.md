---
Title: Как переделать TLabel в URL?
Author: Kevin Lange (klange@partslink.com)
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как переделать TLabel в URL?
============================

Приложение содержит ссылку, которая позволяет запускать Браузер и сразу
перейти по указанному в ссылке адресу. Процесс создания URL заключается
в переделке компоненты TLabel в URL.

Следующие 3 шага показывают как переделать TLabel в URL.

**Шаг 1:**
Установите в свойствах шрифта подчёркивание и цвет ссылки.

**Шаг 2:**
Установите свойства курсора. Когда мышка попадает на URL, то
курсор должен превращаться в ручку.

**Шаг 3:**
Записываем событие OnClick для ссылки. Когда пользователь
нажимает на ссылку, то запускается браузер, который автоматически
переходит на заданный адрес. Однако этого мало! Нужно будет добавить в
приложение ещё одну строчку

Та самая строчка:

    ShellExecute(0,'open',pChar(URL),NIL,NIL,SW_SHOWNORMAL);

Внимание: функция ShellExecute содержится в ShellAPI, поэтому вам
прийдётся включить его в проект.

Пример приложения

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ShellAPI;
     
    type
      TForm1 = class(TForm)
        URLLabel: TLabel;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure URLLabelClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Close;
    end;
     
    procedure TForm1.URLLabelClick(Sender: TObject);
    Const
      URL : String = 'http://www.sources.ru';
    begin
      ShellExecute(0,'open',pChar(URL),NIL,NIL,SW_SHOWNORMAL);
    end;
     
    end.

