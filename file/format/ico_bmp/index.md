---
Title: Конвертирование ICO -> BMP
Date: 01.01.2007
---


Конвертирование ICO -> BMP
==========

Вариант 1:

Source: <https://blackman.wp-club.net/>

    Var
    Icon   : TIcon;
    Bitmap : TBitmap;
    begin
      Icon   := TIcon.Create;
      Bitmap := TBitmap.Create;
      Icon.LoadFromFile('c:\picture.ico');
      Bitmap.Width := Icon.Width;
      Bitmap.Height := Icon.Height;
      Bitmap.Canvas.Draw(0, 0, Icon);
      Bitmap.SaveToFile('c:\picture.bmp');
      Icon.Free;
      Bitmap.Free;
    end;


------------------------------------------------------------------------

Вариант 2:

    procedure TIconShow.FileListBox1Click(Sender: TObject);
    var
     
      MyIcon: TIcon;
      MyBitMap: TBitmap;
    begin
     
      MyIcon := TIcon.Create;
      MyBitMap := TBitmap.Create;
     
      try
        { получаем имя файла и связанную с ним иконку}
        strFileName := FileListBox1.Items[FileListBox1.ItemIndex];
        StrPCopy(cStrFileName, strFileName);
        MyIcon.Handle := ExtractIcon(hInstance, cStrFileName, 0);
     
        { рисуем иконку на bitmap в speedbutton }
        SpeedButton1.Glyph := MyBitMap;
        SpeedButton1.Glyph.Width := MyIcon.Width;
        SpeedButton1.Glyph.Height := MyIcon.Height;
        SpeedButton1.Glyph.Canvas.Draw(0, 0, MyIcon);
     
        SpeedButton1.Hint := strFileName;
     
      finally
        MyIcon.Free;
        MyBitMap.Free;
      end;
    end;

------------------------------------------------------------------------

Вариант 3:

Source: <https://delphiworld.narod.ru>

Чтобы преобразовать Icon в Bitmap используйте TImageList. для обратного
преобразования замените метод AddIcon на Add, и метод GetBitmap на
GetIcon.

    function Icon2Bitmap(Icon: TIcon): TBitmap;
    begin
      with TImageList.Create (nil) do
      begin
        AddIcon (Icon);
        Result := TBitmap.Create;
        GetBitmap (0, Result);
        Free;
      end;
    end;


------------------------------------------------------
Вариант 4:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Способ преобразования изображения размером 32x32 в иконку.

    unit main;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, ExtCtrls, StdCtrls;
     
    type
     
      TForm1 = class(TForm)
        Button1: TButton;
        Image1: TImage;
        Image2: TImage;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      winDC, srcdc, destdc: HDC;
     
      oldBitmap: HBitmap;
      iinfo: TICONINFO;
    begin
     
      GetIconInfo(Image1.Picture.Icon.Handle, iinfo);
     
      WinDC := getDC(handle);
      srcDC := CreateCompatibleDC(WinDC);
      destDC := CreateCompatibleDC(WinDC);
      oldBitmap := SelectObject(destDC, iinfo.hbmColor);
      oldBitmap := SelectObject(srcDC, iinfo.hbmMask);
     
      BitBlt(destdc, 0, 0, Image1.picture.icon.width,
        Image1.picture.icon.height,
        srcdc, 0, 0, SRCPAINT);
      Image2.picture.bitmap.handle := SelectObject(destDC, oldBitmap);
      DeleteDC(destDC);
      DeleteDC(srcDC);
      DeleteDC(WinDC);
     
      image2.Picture.Bitmap.savetofile(ExtractFilePath(Application.ExeName)
        + 'myfile.bmp');
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     
      image1.picture.icon.loadfromfile('c:\myicon.ico');
    end;
     
    end. 

