---
Title: Как создать круглую форму?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как создать круглую форму?
==========================

Здесь приведён полный пример того, как создать круглую форму.

Не забудьте создать TButton, чтобы окно можно было закрыть.

    unit Unit1; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, 
      Forms, Dialogs, ExtCtrls, Buttons, StdCtrls; 
     
    type 
      TForm1 = class(TForm) 
        Button1: TButton; 
        procedure FormCreate(Sender: TObject); 
        procedure Button1Click(Sender: TObject); 
      private 
        { Private-Deklarationen} 
        procedure CreateParams(var Params: TCreateParams); override; 
      public 
        { Public-Deklarationen} 
      end;       
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.DFM} 
     
    { TForm1 } 
     
    procedure TForm1.CreateParams(var Params: TCreateParams); 
    begin 
      inherited CreateParams(Params); 
     
      { удаляем заголовок и рамку }
      Params.Style := Params.Style or ws_popup xor ws_dlgframe; 
    end; 
     
    procedure TForm1.FormCreate(Sender: TObject); 
    var 
      FormRgn: hRgn; 
    begin 
      {clear form} 
      Form1.Brush.Style := bsSolid; //bsclear; 
      { делаем круг формы } 
      GetWindowRgn(Form1.Handle, FormRgn); 
     
      { удаляем старый объект } 
      DeleteObject(FormRgn); 
      { делаем прямоугольник формы }
      Form1.Height := 500; 
      Form1.Width := Form1.Height; 
      { создаём круглую форму } 
      FormRgn := CreateRoundRectRgn(1, 1, Form1.Width - 1, 
                 Form1.height - 1, Form1.width, Form1.height); 
     
      { устанавливаем новое круглое окно }
      SetWindowRgn(Form1.Handle, FormRgn, TRUE); 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Form1.close; 
    end; 
     
    end.

