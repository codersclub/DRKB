---
Title: Как получить размер развернутого TComboBox?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как получить размер развернутого TComboBox?
===========================================

В течение события FormShow, выпадающему списке дважды посылается
сообщение CB\_SHOWDROPDOWN, один раз, чтобы он открылся, а второй -
чтобы свернулся. Затем посылается сообщение CB\_GETDROPPEDCONTROLRECT,
передающее адрес TRect.

Когда вызов SendMessage возвращается, то TRect будет содержать
прямоугольник, который соответствует раскрытому ComboBox-у относительно
окна. Затем можно вызвать ScreenToClient для преобразования координат
TRect-а в координаты относительно клиентской области формы.

    var 
      R : TRect; 
     
    procedure TForm1.FormShow(Sender: TObject); 
    var 
      T : TPoint; 
    begin 
      SendMessage(ComboBox1.Handle, 
                  CB_SHOWDROPDOWN, 
                  1, 
                  0); 
      SendMessage(ComboBox1.Handle, 
                  CB_SHOWDROPDOWN, 
                  0, 
                  0); 
      SendMessage(ComboBox1.Handle, 
                  CB_GETDROPPEDCONTROLRECT, 
                  0, 
                  LongInt(@r)); 
      t := ScreenToClient(Point(r.Left, r.Top)); 
      r.Left := t.x; 
      r.Top := t.y; 
      t := ScreenToClient(Point(r.Right, r.Bottom)); 
      r.Right := t.x; 
      r.Bottom := t.y; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Form1.Canvas.Rectangle(r.Left, 
                             r.Top, 
                             r.Right, 
                             r.Bottom ); 
    end;

