---
Title: Загрузка JPEG из ресурсов
Author: Smike
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Загрузка JPEG из ресурсов
=========================

    uses Jpeg;
    {$R test.res}
     
    function LoadJpegRes(const ID: string): TJpegImage;
    var
      RS: TResourceStream;
    begin
      Result := TJpegImage.Create;
      RS := TResourceStream.Create(HInstance, ID, RT_RCDATA);
      try
        RS.Seek(0, soBeginning);
        Result.LoadFromStream(RS);
      finally
        RS.Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      MyJpeg: TJpegImage;
    begin
      MyJpeg := LoadJpegRes('MYJPEG');
      Image1.Canvas.Draw(0, 0, MyJpeg);
    end;


Для JPEG, загнанного в ресурсы, таким образом:

    MYJPEG RCDATA "Test.jpg" 


