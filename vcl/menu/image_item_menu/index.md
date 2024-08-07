---
Title: Элементы меню на основе изображений
Author: Neil Rubenking
Date: 01.01.1997
Source: <https://delphiworld.narod.ru>
---


Элементы меню на основе изображений
===================================

> В своем меню я хочу иметь графику. Но как мне сделать это?

Воспользуйтесь командой ModifyMenu. Тем не менее, Delphi 1.0 имеет
привычку СТИРАТЬ изменения в пунктах меню, к примеру, созданных на
основе изображения или отрисованных вручную. Если вы пользуетесь этими
"фишками", вы НЕ должны осуществлять enable/disable или check/uncheck
элементов меню через свойства. Вместо этого вы должны вызывать
соответствующие функции Windows API.

Вот демонстрационный пример из моей
книги Delphi Programming Problem Solver, демонстрирующий элементы меню
на основе изображений. Подразумевается, что вы создали форму и главное
меню. Меню содержит пустое подменю File (необязательно) и меню верхнего
уровня с именем Brush1. Ниже Brush1 вы должны иметь шесть пунктов
подменю; их имена могут быть абстрактными, но в приведенном ниже коде
они поименованы шестью стилями кисти. Вот сам код:

    unit bitmenuu;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics,
      Controls, Forms, Dialogs, ExtCtrls, Menus;
     
    type
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        Brush1: TMenuItem;
        Horizontal1: TMenuItem;
        Vertical1: TMenuItem;
        FDiagonal1: TMenuItem;
        BDiagonal1: TMenuItem;
        Cross1: TMenuItem;
        DiagCross1: TMenuItem;
        procedure FormCreate(Sender: TObject);
        procedure BrushStyleClick(Sender: TObject);
      private
        { Private declarations }
        Bitmaps: array[0..5] of TBitmap;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      N: Integer;
    begin
      with Brush1 do
        for N := 0 to 5 do
        begin
          Bitmaps[N] := TBitmap.Create;
          with Bitmaps[N], Canvas do
          begin
            Width := 80;
            Height := 16;
            Brush.Color := clMenu;
            Rectangle(0, 0, 80, 16);
            Brush.Color := clMenuText;
            Brush.Style := TBrushStyle(N + 2);
            Rectangle(0, 0, 80, 16);
          end;
          ModifyMenu(Handle, N, MF_BYPOSITION or MF_BITMAP,
            GetMenuItemID(Handle, N), PChar(Bitmaps[N].Handle));
        end;
    end;
     
    procedure TForm1.BrushStyleClick(Sender: TObject);
    var
      N: Integer;
    begin
      with Brush1 do
        for N := 0 to Count - 1 do
    {$IFDEF Win32}
          Items[N].Checked := Items[N] = Sender;
    {$ELSE}
          if Items[N] = Sender then
            CheckMenuItem(Handle, N, MF_BYPOSITION or MF_CHECKED)
          else
            CheckMenuItem(Handle, N, MF_BYPOSITION or MF_UNCHECKED);
    {$ENDIF}
      with Sender as TMenuItem do
        Brush.Style := TBrushStyle(Tag);
      Refresh;
    end;
     
    end.

OK, в обработчике события формы OnCreate мы создаем шесть изображений и
используем ModifyMenu для их назначения каждому из шести пунктов
подменю. В обработчике события OnClick мы, в зависимости от того
используется Delphi 2.0 или нет, применяем ту или иную технологию
установки атрибутов пункта меню. В Delphi 2.0 мы должны обойти все
пункты меню и установить Checked в True только для тех пунктов, на
которых щелкали мышью. В Delphi 1.0 мы должны воспользоваться API
функцией CheckMenuItem. Попробуйте это!

