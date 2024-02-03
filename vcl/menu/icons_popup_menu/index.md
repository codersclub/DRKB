---
Title: Иконки в PopupMenu
Date: 01.01.2007
---


Иконки в PopupMenu
==================

::: {.date}
01.01.2007
:::

    type
     
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        // * * * * Элемент для Menu Bar * * * * /
          Open1: TMenuItem;
        // * * * * Элемент для Menu file * * * * /
          procedure FormCreate(Sender: TObject);
        procedure FormShow(Sender: TObject);
      private
        {private declarations}
      public
        {public declarations}
        Icn, Txt, MnuItm: TBitmap;
      end;
     
    procedure TForm2.FormCreate(Sender: TObject);
    var
      R: TRect;
     
      HIcn: HIcon;
      Ic: TIcon;
      Index: Word;
      FileName: PChar;
    begin
     
      // * * Получаем иконку определенного приложения * * /
        Ic := TIcon.Create;
      Ic.Handle := ExtractAssociatedIcon(Hinstance, // * задаем путь и имя файла * /
       , Index);
      // * * Создаем для текста изображение * * /
        Txt := TBitmap.Create;
      with Txt do
      begin
        Width := Canvas.TextWidth(' Тест');
        Height := Canvas.TextHeight(' Тест');
        Canvas.TextOut(0, 0, ' Тест');
      end;
     
      // * * Копируем иконку в bitmap для изменения его размера.
        Вы не можете менять размер иконки * * /
        Icn := TBitmap.Create;
      with Icn do
      begin
        Width := 32;
        Height := 32;
        Brush.Color := clBtnFace;
        Canvas.Draw(0, 0, Ic);
      end;
     
      // * * Создаем окончательное изображение, куда мы помещаем иконку и текст * * /
        MnuItm := TBitmap.Create;
      with MnuItm do
      begin
        Width := Txt.Width + 18;
        Height := 18;
        with Canvas do
        begin
          Brush.Color := clBtnFace;
          Pen.Color := clBtnFace;
          Brush.Style := bsSolid;
          Rectangle(0, 0, Width, Height);
          CopyMode := cmSrcAnd;
          StretchDraw(Rect(0, 0, 16, 16), Icn);
          CopyMode := cmSrcAnd;
          Draw(16, 8 - (Txt.Height div 2), Txt);
        end;
      end;
    end;
     
    procedure TForm2.FormShow(Sender: TObject);
    var
     
      ItemInfo: TMenuItemInfo;
      hBmp1: THandle;
    begin
     
      HBmp1 := MnuItm.Handle;
      with ItemInfo do
      begin
        cbSize := SizeOf(ItemInfo);
        fMask := MIIM_TYPE;
        fType := MFT_BITMAP;
        dwTypeData := PChar(MakeLong(hBmp1, 0));
      end;
     
      // * * Заменяем MenuItem Open1 законченным изображением * *
        SetMenuItemInfo(GetSubMenu(MainMenu1.Handle, File1.MenuIndex),
          Open1.MenuIndex, true, ItemInfo);
     
    end;

    {
    В меню существуют некоторые проблемы масштабированием и палитрой иконки.
      Я также ищу лучшее решение, но это все, что я вам могу сейчас дать.
     
    Листинг был изменен для того, чтобы помещать иконки в "чЕкнутое"
      состояние меню(просто это делает Win95).Это позволяет вам иметь
      "чЕкнутое" и "нечЕкнутое" состояние.
    }
     
    unit Unit1;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      Menus, ShellAPI;
     
    type
     
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        Open1: TMenuItem;
        procedure FormCreate(Sender: TObject);
        procedure FormShow(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
        Icn, MnuItm: TBitmap;
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      R: TRect;
     
      HIcn: HIcon;
      Ic: TIcon;
      Index: Word;
    begin
     
      {     /** Получаем иконку некоторого приложения **/}
     
      Index := 0; { 11-я иконка в файле }
      Ic := TIcon.Create;
      Ic.Handle := ExtractAssociatedIcon(Hinstance,
        'c:\win95\system\shell32.dll', Index);
     
      {     /** Копируем иконку в bitmap для изменения его размера.
      Вы не можете менять размер иконки **/}
     
      Icn := TBitmap.Create;
     
      with Icn do
      begin
        Width := 32;
        Height := 32;
        Canvas.Brush.Color := clbtnface;
        Canvas.Draw(0, 0, Ic);
      end;
     
      {     /** Создаем окончательное изображение, куда мы помещаем иконку и текст **/}
     
      MnuItm := TBitmap.Create;
      with MnuItm do
      begin
        Width := 18;
        Height := 18;
        with Canvas do
        begin
          Brush.Color := clbtnface;
          Pen.Color := clbtnface;
          CopyMode := cmSrcAnd;
          StretchDraw(Rect(0, 0, 16, 16), Icn);
        end;
      end;
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    var
      ItemInfo: TMenuItemInfo;
      hBmp1: THandle;
    begin
      HBmp1 := MnuItm.Handle;
      with ItemInfo do
      begin
        cbSize := SizeOf(ItemInfo);
        fMask := MIIM_CHECKMARKS;
        fType := MFT_BITMAP;
        hBmpunChecked := HBmp1; { Неотмеченное (Unchecked) состояние }
        hBmpChecked := HBmp1; { Отмеченное (Checked) состояние }
      end;
     
      {     /** Заменяем MenuItem Open1 законченным изображением **/}
     
      SetMenuItemInfo(GetSubMenu(MainMenu1.Handle, File1.MenuIndex),
        Open1.MenuIndex, true, ItemInfo);
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
