---
Title: Как програмно переключить раскладку клавиатуры?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как програмно переключить раскладку клавиатуры?
===============================================

    procedure TForm1.Button1Click(Sender: TObject);//На русский
    var
      Layout: array[0.. KL_NAMELENGTH] of char;
    begin
      LoadKeyboardLayout( StrCopy(Layout,'00000419'),KLF_ACTIVATE);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);//На английский
    var
      Layout: array[0.. KL_NAMELENGTH] of char;
    begin
      LoadKeyboardLayout(StrCopy(Layout,'00000409'),KLF_ACTIVATE);
    end;

