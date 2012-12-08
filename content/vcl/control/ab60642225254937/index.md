---
Title: Включение и выключение закладки TNotebook
Date: 01.01.2007
---


Включение и выключение закладки TNotebook
=========================================

::: {.date}
01.01.2007
:::

Вот хороший трюк от Xavier Pacheco:

    unit TabDis;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, StdCtrls, TabNotBk;
     
    type
      TFrmTabDis = class(TForm)
        TabbedNotebook1: TTabbedNotebook;
        Button1: TButton;
        procedure FormCreate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
      private
        { Private-Deklarationen }
      public
        { Public-Deklarationen }
      end;
     
    var
      FrmTabDis: TFrmTabDis;
     
    implementation
     
    {$R *.DFM}
     
    procedure TFrmTabDis.FormCreate(Sender: TObject);
    var
      i: integer;
      j: integer;
    begin
      { Создаем имена для всех Notebook TTabButton }
     
      j := 0;
     
      with TabbedNotebook1 do
        for i := 0 to ControlCount - 1 do
          if Controls[i].ClassName = 'TTabButton' then
          begin
            Controls[i].Name := Controls[i].ClassName + IntToStr(j);
            Inc(j);
          end;
    end;
     
    procedure TFrmTabDis.Button1Click(Sender: TObject);
    begin
      { Делаем недоступной определенную страницу notebook }
      with TControl(TabbedNotebook1.FindComponent('TTabButton2')) do
        Enabled := not Enabled;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
