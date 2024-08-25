---
Title: Вставка содержимого буфера как картинку в RTF
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Вставка содержимого буфера как картинку в RTF
=============================================

    procedure TForm1.Button1Click(Sender: TObject);
    var
      b : tbitmap;
      fr: TFormatRange;
      r : TRect;
    begin
      b:=tbitmap.create;
      b.width:=rxrichedit1.width;
      b.height:=rxrichedit1.height;
      r:=rect(0,0,RXRichEdit1.Width*screen.Pixelsperinch,
        RXRichEdit1.Height*screen.Pixelsperinch);
      fr.hdc:=b.Canvas.handle;
      fr.hdctarget:=b.Canvas.handle;
      fr.rc:=r;
      fr.rcpage:=r;
      fr.chrg.cpMin:=0;
      fr.chrg.cpMax:=-1;
      Sendmessage(RXRichEdit1.handle,EM_FORMATRANGE,1,longint(@fr));
      image1.Picture.assign(b);
      b.free;
    end;

