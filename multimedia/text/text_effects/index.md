---
Title: Вывод текста с эффектами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Вывод текста с эффектами
========================

> Question:  
> How to make TextOut with 3d-Effect or hollow Text?

Answer:

Make a new Application and take this Proc bellow for the OnPaint-Event
of the Form. The TextOutput will look like written with a kaligraf.
If you replace the for loop in the proc with a single call of textout you
can use this code to write "hollow" text. Try it with different
Pen-Styles too!

    procedure TForm1.FormPaint(Sender: TObject);
    var
      HFnt: HFONT;
      Fontname, Txt: PChar;
      sze: Size;
      c: Integer;
      byt: Byte;
    begin
      Fontname := 'Arial';
      txt := 'Mediakueche';
      HFnt := CreateFont(90, 60, 0, 0, FW_BOLD, 0, 0, 0, DEFAULT_CHARSET,
        OUT_DEFAULT_PRECIS, CLIP_DEFAULT_PRECIS,
        PROOF_QUALITY, DEFAULT_PITCH + FF_DONTCARE, Fontname);
      SelectObject(Canvas.Handle, hfnt);
      SetBkMode(Canvas.Handle, TRANSPARENT);
      GetTextExtentPoint32(Canvas.Handle, txt, length(txt), sze);
      BeginPath(Canvas.Handle);
      c := 1;
      for c := 0 to 4 do
      begin
        TextOut(Canvas.Handle, 5 + c, 10 + c, Txt, length(Txt));
      end;
      EndPath(Canvas.Handle);
      //  Canvas.pen.Style := psDot;
      StrokePath(Canvas.Handle);
      SetBkMode(Canvas.Handle, OPAQUE);
     
      DeleteObject(SelectObject(Canvas.Handle, GetStockObject(WHITE_BRUSH)));
      SelectObject(Canvas.Handle, GetStockObject(SYSTEM_FONT));
      DeleteObject(HFnt);
     
    end;

