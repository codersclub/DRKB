---
Title: Можно ли создать форму, которая получает дополнительные параметры в методе Сreate?
Date: 01.01.2007
---


Можно ли создать форму, которая получает дополнительные параметры в методе Сreate?
==================================================================================

::: {.date}
01.01.2007
:::

Просто замените конструктор Create класса Вашей формы.

    unit Unit2;
     
    interface
     
    uses Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TForm2 = class(TForm)
      private
      {Private declarations}
      public
        constructor CreateWithCaption(aOwner: TComponent; aCaption: string);
      {Public declarations}
      end;
     
    var
      Form2: TForm2;
     
    implementation
     
    {$R *.DFM}
     
    constructor TForm2.CreateWithCaption(aOwner: TComponent; aCaption: string);
    begin
      Create(aOwner);
      Caption := aCaption;
    end;
     
    uses Unit2;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Unit2.Form2 := Unit2.TForm2.CreateWithCaption(Application, 'My Caption');
      Unit2.Form2.Show;
    end;
