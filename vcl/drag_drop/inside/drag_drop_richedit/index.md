---
Title: Drag & Drop из RichEdit
Date: 01.01.2007
---


Drag & Drop из RichEdit
=======================

::: {.date}
01.01.2007
:::

    var
       Form1: TForm1;
       richcopy: string;
       transfering: boolean;
     implementation
     
     {$R *.DFM\}
     
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

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
