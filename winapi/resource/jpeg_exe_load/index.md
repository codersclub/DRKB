---
Title: Как поместить JPEG-картинку в exe-файл и потом загрузить её?
Date: 01.01.2007
---

Как поместить JPEG-картинку в exe-файл и потом загрузить её?
============================================================

1) Создайте текстовый файл с расширением ".rc".
Имя этого файла должно отличаться от имени файла - пректа или любого модуля проекта.

Файл должен содержать строку вроде:

    MYJPEG JPEG C:\DownLoad\MY.JPG

где:

- "MYJPEG" - имя ресурса
- "JPEG" - пользовательский тип ресурса
- "C:\\DownLoad\\MY.JPG" - путь к JPEG файлу.

Пусть например rc - файл называется "foo.rc"

2) Запустите BRCC32.exe (Borland Resource CommandLine Compiler) - программа
находится в каталоге Bin Delphi/C++Builder\'а - передав ей в качестве
параметра полный путь к rc - файлу.

В нашем примере:

    C:\DelphiPath\BIN\BRCC32.EXE C:\ProjectPath\FOO.RC

Вы получите откомпилированный ресурс - файл с расширением ".res".
(в нашем случает foo.res).

3) Далее добавьте ресурс к своему приложению.

    {Грузим ресурс}
    {$R FOO.RES}
     
    uses Jpeg;
     
    procedure LoadJPEGFromRes(TheJPEG: string; ThePicture: TPicture);
    var
      ResHandle: THandle;
      MemHandle: THandle;
      MemStream: TMemoryStream;
      ResPtr: PByte;
      ResSize: Longint;
      JPEGImage: TJPEGImage;
    begin
      ResHandle := FindResource(hInstance, PChar(TheJPEG), 'JPEG');
      MemHandle := LoadResource(hInstance, ResHandle);
      ResPtr := LockResource(MemHandle);
      MemStream := TMemoryStream.Create;
      JPEGImage := TJPEGImage.Create;
      ResSize := SizeOfResource(hInstance, ResHandle);
      MemStream.SetSize(ResSize);
      MemStream.Write(ResPtr^, ResSize);
      FreeResource(MemHandle);
      MemStream.Seek(0, 0);
      JPEGImage.LoadFromStream(MemStream);
      ThePicture.Assign(JPEGImage);
      JPEGImage.Free;
      MemStream.Free;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      LoadJPEGFromRes('MYJPEG', Image1.Picture);
    end;
