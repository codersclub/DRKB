---
Title: Drag & Drop TImage
Date: 01.01.2007
---


Drag & Drop TImage
==================

::: {.date}
01.01.2007
:::

Вот рабочий пример. Расположите на форме панель побольше, скопируйте и
измените приведенный код так, чтобы изображение загружалось из ВАШЕГО
каталога Delphi.

    procedure TForm1.Panel1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      with Source as TImage do
      begin
        Left := X;
        Top := Y;
      end;
    end;
     
    procedure TForm1.Panel1DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    begin
      Accept := Source is TImage;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      with TImage.Create(Self) do
      begin
        Parent := Panel1;
        AutoSize := True;
        Picture.LoadFromFile('D:\DELPHI\IMAGES\CHIP.BMP');
        DragMode := dmAutomatic;
        OnDragOver := Panel1DragOver;
        OnDragDrop := Panel1DragDrop;
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
