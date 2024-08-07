---
Title: Подсветка синтаксиса
Author: Vit
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Подсветка синтаксиса
====================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls, ComCtrls;
     
    type
      TForm1 = class(TForm)
        RichEdit1: TRichEdit;
        Button1: TButton;
        OpenDialog1: TOpenDialog;
        Button2: TButton;
        procedure RichEdit1KeyUp(Sender: TObject; var Key: Word;
          Shift: TShiftState);
        procedure HighLight;
        function CheckList(InString: string): boolean;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    function TForm1.CheckList(InString: string): boolean;
    const TheList: array[1..13] of string = ('begin', 'or', 'end','end.',
    'end;', 'then', 'var', 'for', 'do', 'if', 'to', 'string', 'while');
    var X: integer;
    begin
      Result := false;
      X := 1;
      InString := StringReplace(InString, ' ', '',[rfReplaceAll]);
      InString := StringReplace(InString, #$A, '',[rfReplaceAll]);
      InString := StringReplace(InString, #$D, '',[rfReplaceAll]);
      while X < High(TheList) + 1 do
      if TheList[X] = lowercase(InString) then
      begin
        Result := true;
        X := High(TheList) + 1;
      end
      else inc(X);
    end;
     
    procedure TForm1.RichEdit1KeyUp(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    var WEnd, WStart, BCount: integer;
      Mark: string;
    begin
      if (ssCtrl in Shift) and (Key = ord('V')) then Button2Click(Self);
      if (Key = VK_Return) or (Key = VK_Back) or (Key = VK_Space) then
      begin
        if RichEdit1.SelStart > 1 then
        begin
          WStart := 0;
          WEnd := RichEdit1.SelStart;
          BCount := WEnd - 1;
          while BCount <> 0 do
          begin
            Mark := copy(RichEdit1.Text, BCount, 1);
            if (Mark = ' ') or (Mark = #$A) then
            begin
              WStart := BCount;
              BCount := 1;
            end;
            dec(BCount);
          end;
          RichEdit1.SelStart := WEnd - (WEnd - WStart);
          RichEdit1.SelLength := WEnd - WStart;
          if CheckList(RichEdit1.SelText) then
            RichEdit1.SelAttributes.Style := [fsBold]
          else RichEdit1.SelAttributes.Style := [];
          RichEdit1.SelStart := WEnd;
          RichEdit1.SelAttributes.Style := [];
        end;
      end;
    end;
     
    function SearchFor(WorkSpace, Search: string; Start: integer): integer;
    var Temp: string;
    begin
      Temp := copy(WorkSpace, Start, length(WorkSpace));
      Result := pos(Search, Temp);
    end;
     
    procedure TForm1.HighLight;
    var WStart, WEnd, WEnd2: integer;
      WorkSpace, SWord: string;
    begin
      WStart  :=  1;
      WEnd  :=  1;
      with  RichEdit1 do
      begin
        WorkSpace  :=  Text + ' ' + #$D#$A;
        while WEnd > 0 do
        begin
          WEnd := SearchFor(WorkSpace, ' ', WStart);
          WEnd2 := SearchFor(WorkSpace, #$A, WStart);
          if WEnd2 < WEnd then WEnd := WEnd2;
          SWord := copy(WorkSpace, WStart, WEnd - 1);
          if (SWord <> ' ') and (SWord <>'') then
            if CheckList(SWord) then
            begin
              SelStart  := WStart - 1;
              SelLength := length(SWord);
              SelAttributes.Style := [fsBOLD];
              SelStart := WStart + length(SWord) + 1;
              SelAttributes.Style := [];
            end;
          WStart := WStart + WEnd;
        end;
        SelStart := length(Text);
        SetFocus;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if OpenDialog1.Execute then
      begin
        RichEdit1.Lines.LoadFromFile(OpenDialog1.FileName);
        HighLight;
      end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      RichEdit1.PasteFromClipboard;
      HighLight;
    end;
     
    end.


**Примечание Vit**

Все способы подкраски синтаксиса реализованные через RichEdit грешат
одним существенным недостатком - они реализованы через изменение
атрибутов текста.

И чем это грозит?

А представьте себе что вы загрузили файл Дельфи, большой такой на пару
мегабайт, например интерфейс от какого-то ActiveX от MS Word... и
решили написать комментарий в начале файла, открываете скобку "(\*" и
... ждёте секунд 10, а то и минуту пока изменятся атрибуты у всего
файла, затем закрываете скобку "\*)" и ждёте следующие пол минуты...
Если же текст побольше, например вы загрузили какой-нибудь XML мегабайт
на 50, то тогда после каждого нажатия клавиши у вас будет время выпить
пивка и пройти уровень в Quake (желательно на другой машине, чтоб не
тормозила)...

И что же делать?

А то что сам метод порочен по своей сути!
Зачем вам подкрашивать 50
мегабайтов текста при нажатии на клавишу если реально надо подсветить
только то что вы видите не экране! А это всего-лишь максимум 10 Kb
текста, но обычно и вовсе 1-2 Kb...

Кроме того, зачем менять аттрибуты?
Ведь Вам же не надо ничего специального делать с зелёными словами,
причём так чтобы это не коснулось синих слов?!! Измение атрибутов в
RichEdit мероприятие само по себе очень долгое, ведь по сути дела
меняется сам поток данных! В данном случае достаточно только изменить
прорисовку текста, т.е. как этот текст рисуется на экране, не меняя сам
текст и его атрибуты совершенно!

Фактически всё что вам надо сделать -
это поменять процедуру прорисовки текста компонента, но это в теории, на
практике всё гораздо сложнее... Но логика та же. Именно так работают и
все редакторы с подсветкой синтаксиса - и от Борланда, и от MS, и от
сторонних производителей.

Чтоб не тратить время на изобретение велосипеда предлагаю применять
компонент SynEdit - самый совершенный на сегодняшний день аналог Memo с
подсветкой синтаксиса. [См. Подсветку в Мемо](/vcl/memo/syntax_highlight/)

