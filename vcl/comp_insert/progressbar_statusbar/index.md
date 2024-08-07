---
Title: Как поместить TProgressBar в панель StatusBar?
Author: Vit
Date: 01.01.2007
---


Как поместить TProgressBar в панель StatusBar?
==============================================

Вариант 1:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

Корректнее было бы самому канву рисовать, но можно и просто вставить -
держи функцию для этого - применять вместо стандартного метода Create.

    Function CreateProgressBar(StatusBar:TStatusBar; index:integer):TProgressBar;
      var findleft:integer;
          i:integer;

     
    begin
      result:=TProgressBar.create(Statusbar);
      result.parent:=Statusbar;
      result.visible:=true;
      result.top:=2;
      findleft:=0;
      for i:=0 to index-1 do findleft:=findleft+Statusbar.Panels[i].width+1;
      result.left:=findleft;
      result.width:=Statusbar.Panels[index].width-4;
      result.height:=Statusbar.height-2;
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Даниил Карапетян (delphi4all@narod.ru)

Source: https://delphi4all.narod.ru

Есть два принципиально разных решения. Первый вариант - это сделать все
"вручную" .

Здесь создается Bitmap с текстом (возможно любое изображение). Чтобы
нарисовать светлую часть полосы, достаточно скопировать кусок Bitmap на
StatusBar, а чтобы нарисовать темную часть полосы, нужно скопировать
кусок Bitmap с инвертированием. При этом фон станет темным, а текст
светлым. Реализация ясна из самой программы.

Второй вариант более простой в реализации, но и менее функциональный.
StatusBar является наследником TWinControl, а следовательно, на нем
можно разместить еще какие-то компоненты. Но сделать это можно только
динамически (непосредственно из программы). На StatusBar помещается
компонент ProgressBar, вначале невидимый. Когда в нем появляется
необходимость, его нужно сделать видимым и начать изменять свойство
Position.

Из этого примера хорошо видны некоторые достоинства и недостатки
объектов.

Если у Вас Delphi3, то строчка pb.Smooth := true; работать не будет. На
сайте выложена версия программы с заменой этой строчки. Впрочем, ее
можно просто удалить - принципиально это ничего не изменит. Скачать все
необходимые для компиляции файлы проекта можно на program.dax.ru.

**Способ 1**

    uses Commctrl;
    const
     MaxProgress = 50;
    var
     bm: TBitmap;
    // Возвращает прямоугольник нулевой панели:
    function GetPanelRect: TRect;
    begin
     SendMessage(Form1.StatusBar1.Handle, SB_GETRECT, 0,
       integer(@result));
     InflateRect(result, -1, -1);
    end;
     
    // Копирует часть bm на StatusBar
    procedure CopyPart(left, right: integer; ACopyMode: TCopyMode);
    var bmRect, pnRect: TRect;
    begin
     bmRect := Rect(left, 0, right, bm.Height - 1);
     pnRect := bmRect;
     with GetPanelRect do
       OffsetRect(pnRect, Left, Top);
     with Form1.StatusBar1.Canvas do begin
       CopyMode := ACopyMode;
       CopyRect(pnRect, bm.Canvas, bmRect);
     end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     with StatusBar1.Panels.Add do begin
       Width := 100;
       Style := psOwnerDraw;
     end;
     with StatusBar1.Panels.Add do begin
       Width := 0;
       Text := 'abc';
     end;
     Timer1.Enabled := false;
     Timer1.Interval := 50;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     Timer1.Enabled := true;
     bm := TBitmap.Create;
     with GetPanelRect do begin
       bm.Width := Right - Left;
       bm.Height := Bottom - Top;
     end;
     with bm.Canvas do begin
       Brush.Color := clSilver;
       FillRect(Bounds(0, 0, bm.Width, bm.Height));
       TextOut(1, 1, 'Doing smth...');
     end;
     CopyPart(0, bm.Width - 1, cmSrcCopy); // Вывод текста
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
     Timer1.Tag := Timer1.Tag + 1;
     if Timer1.Tag >  MaxProgress then begin
       Timer1.Enabled := false;
       Timer1.Tag := 0;
       StatusBar1.Repaint; // Очистка StatusBar
     end else
       // Вывод только что закрашенной части:
       CopyPart(trunc((Timer1.Tag - 1) / MaxProgress * bm.Width),
         trunc(Timer1.Tag / MaxProgress * bm.Width), cmNotSrcCopy);
    end;
     
    procedure TForm1.StatusBar1DrawPanel(StatusBar: TStatusBar;
     Panel: TStatusPanel; const Rect: TRect);
    var p: integer;
    begin
     if (Panel.Index = 0) and (Timer1.Tag >  0) then begin
       p := round((Rect.Right - Rect.Left) * Timer1.Tag / MaxProgress);
       // Вывод закрашенной части:
       CopyPart(0, p, cmNotSrcCopy);
       // Вывод незакрашенной части:
       CopyPart(p + 1, bm.Width - 1, cmSrcCopy);
     end;
    end;

**Способ 2**

    uses Commctrl;
    const
     MaxProgress = 50;
    var pb: TProgressBar;
     
    function GetPanelRect: TRect;
    begin
     SendMessage(Form1.StatusBar1.Handle, SB_GETRECT, 0, integer(@result));
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     with StatusBar1.Panels.Add do begin
       Width := 100;
       Style := psOwnerDraw;
     end;
     with StatusBar1.Panels.Add do begin
       Width := 0;
       Text := 'abc';
     end;
     Timer1.Enabled := false;
     Timer1.Interval := 50;
     pb := TProgressBar.Create(StatusBar1);
     pb.Visible := false;
     pb.Parent := StatusBar1;
     pb.BoundsRect := GetPanelRect;
     pb.Smooth := true;
     pb.Step := 1;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     Timer1.Enabled := true;
     pb.Position := 0;
     pb.Max := MaxProgress;
     pb.Visible := true;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
     Timer1.Tag := Timer1.Tag + 1;
     if Timer1.Tag >  MaxProgress then begin
       Timer1.Enabled := false;
       Timer1.Tag := 0;
       pb.Visible := false;
     end else pb.StepIt;
    end;

Даниил Карапетян.
Email: <delphi4all@narod.ru>

На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.

