---
Title: Удобная загрузка местоположения формы
Author: Virtualik
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Удобная загрузка местоположения формы
=====================================

Если вы храните параметры местоположения (Top, Left, Width, Height) формы
в реестре, то чтобы не загружать данные из нескольких ключей вы можете
их записать в один, и из одного же прочитать ;)

По сути, данные записывается в виде record\'а. А как это примерно может
выглядеть смотрите в примере.

    var
      Ini: TRegIniFile;
    ...
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      Rct: TRect;
    begin
      Ini := TRegIniFile.Create('<Здесь вы пишете путь к вашим настройкам в
        реестре > ');
      // Если есть данные --> загружаем их
      if Ini.ReadBinaryData('FormPosition', Rct, SizeOf(TRect)) > 0 then
        BoundsRect := Rct;
      ...
    end;
     
    procedure TReply.FormDestroy(Sender: TObject);
    var
      Rct: TRect;
    begin
      // Сохранение данных на выходе
      ...
      Rct := BoundsRect;
      Ini.WriteBinaryData('MsgPos', Rct, SizeOf(TRect));
      Ini.Free;
    end;
