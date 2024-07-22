---
Title: Drag & Drop из RichEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Drag & Drop из RichEdit
=======================

    var
       Form1: TForm1;
       richcopy: string;
       transfering: boolean;
     implementation
     
     {$R *.DFM}
     
     procedure TForm1.RichEdit1MouseDown(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     begin
      if length(richedit1.seltext)>0 then begin
       richcopy:=richedit1.seltext;
       transfering:=true;
      end; //seltext
     end;
     
     procedure TForm1.ListBox1MouseMove(Sender: TObject; Shift: TShiftState; X,
       Y: Integer);
     begin
      if transfering then begin
       transfering:=false;
       listbox1.items.add(richcopy);
      end; //transfering
     end;



 
