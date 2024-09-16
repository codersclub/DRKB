---
Title: Как программно переключить раскладку клавиатуры
Date: 01.01.2007
---

Как программно переключить раскладку клавиатуры
===============================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    //На русский
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Layout: array[0.. KL_NAMELENGTH] of char;
    begin
      LoadKeyboardLayout( StrCopy(Layout,'00000419'),KLF_ACTIVATE);
    end;

    //На английский
    procedure TForm1.Button2Click(Sender: TObject);
    var
      Layout: array[0.. KL_NAMELENGTH] of char;
    begin
      LoadKeyboardLayout(StrCopy(Layout,'00000409'),KLF_ACTIVATE);
    end;


------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Эта программа при нажатии на Button1 меняет язык на следующий, при
нажатии на Button2 - на русский, а на Button3 - на английский. Каждую
секунду программа выводит в заголовок окна число, определяющее текущий
язык.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ActivateKeyboardLayout(HKL_NEXT, 0);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ActivateKeyboardLayout(LoadKeyboardLayout('00000419', 0), 0);
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
      ActivateKeyboardLayout(LoadKeyboardLayout('00000409', 0), 0);
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      s: array [0..63] of char;
    begin
      GetKeyboardLayoutName(s);
      Form1.Caption := s;
    end; 

