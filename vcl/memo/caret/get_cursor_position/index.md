---
Title: Как получить координаты курсора в memo-поле?
Date: 01.01.2007
---


Как получить координаты курсора в memo-поле?
============================================

Вариант 1:

Source: <https://forum.sources.ru>

    procedure CaretPos(H: THandle; var L,C : Word); 
    begin 
      L := SendMessage(H,EM_LINEFROMCHAR,-1,0); 
      C := LoWord(SendMessage(H,EM_GETSEL,0,0)) - SendMessage(H,EM_LINEINDEX,-1,0); 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      LineNum,ColNum : Word; 
    begin 
      CaretPos(Memo1.Handle,LineNum,ColNum); 
      Edit1.Text := IntToStr(LineNum) + '  ' + IntToStr(ColNum); 
    end;

Хотя в Delphi 5 свойство CaretPos уже включено в memo.


------------------------------------------------------------------------

Вариант 2:

Source: <https://forum.sources.ru>

> Как получить номер строки memo, в которой находится курсор?

Для этого необходимо послать сообщение `EM_LINEFROMCHAR`.

    LineNumber := Memo1.Perform(EM_LINEFROMCHAR, -1, 0);


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    var
      X, Y: LongInt;
    begin
      Y := Memo1.Perform(EM_LINEFROMCHAR, Memo1.SelStart, 0);
      X := Memo1.Perform(EM_LINEINDEX, Y, 0);
      inc(Y);
      X := Memo1.SelStart - X + 1;
      Form1.Caption := 'X = ' + IntToStr(X) + ' : ' + 'Y = ' + IntToStr(Y);
    end;

