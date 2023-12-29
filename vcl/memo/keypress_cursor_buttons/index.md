---
Title: Событие Key Press и курсорные клавиши в TMemo
Date: 01.01.2007
---


Событие Key Press и курсорные клавиши в TMemo
=============================================

::: {.date}
01.01.2007
:::

Мне необходимо обновлять текущую строку в во время перемещения по ним с
помощью курсорных клавиш.

Вам повезло. Совсем недавно мне пришлось помучиться с этой задачкой. Я
переместил функции в отдельный модуль. Для тестирования кода создайте
пустую форму с одним компонентом Tmemo.

Вам потребуется перехватывать ряд событий. В приведенном ниже коде я
создал обработчиков всех возможных для данной операции событий, выберите
себе необходимые сами. Некоторые из событий могут иметь общий
обработчик.

Данный пример отображает в заголовке текущие координаты курсора
(столбец, строка).

Я не стал отображать координаты, когда текст выбран, поскольку не был
уверен как этим оперировать без рассогласования...

Сообщайте мне о любых возникающих проблемах, но я уверен что это должно
работать как положено.

    unit Unit1;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
     
      TForm1 = class(TForm)
        Memo1: TMemo;
        procedure Memo1Change(Sender: TObject);
        procedure Memo1Click(Sender: TObject);
        procedure Memo1Enter(Sender: TObject);
        procedure Memo1KeyDown(Sender: TObject; var Key: Word;
          Shift: TShiftState);
        procedure Memo1KeyUp(Sender: TObject; var Key: Word;
          Shift: TShiftState);
        procedure Memo1MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Memo1MouseUp(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
      private
        { Private declarations }
        function GetLineIndex: Word;
        function GetStrInsertIndex: Word;
        procedure GetCursorCoord;
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    function TForm1.GetLineIndex: Word;
    begin
     
      Result := SendMessage(Memo1.handle, EM_LINEFROMCHAR, memo1.selstart, 0);
    end;
     
    function TForm1.GetStrInsertIndex: word;
    begin
      GetStrInsertIndex :=
        memo1.Selstart - SendMessage(Memo1.handle, EM_LINEINDEX, GetLineIndex, 0)
    end;
     
    procedure TForm1.GetCursorCoord;
    var
      LineIndex: word;
     
      LineChar: byte;
      SelSt: word;
    begin
      SelSt := Memo1.selstart;
      LineIndex := GetLineIndex;
      Linechar := GetStrInsertIndex;
     
      if Memo1.seltext > '' then
        Caption := 'Выбранный текст'
      else
        Caption := 'Колонка ' + inttostr(LineChar + 1) + ' , ' +
     
        'Строка ' + inttostr(Lineindex + 1);
    end;
     
    procedure TForm1.Memo1Change(Sender: TObject);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1Click(Sender: TObject);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1Enter(Sender: TObject);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1KeyDown(Sender: TObject; var Key: Word;
     
      Shift: TShiftState);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1KeyUp(Sender: TObject; var Key: Word;
     
      Shift: TShiftState);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1MouseDown(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
      GetCursorCoord;
    end;
     
    procedure TForm1.Memo1MouseUp(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
      GetCursorCoord;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
