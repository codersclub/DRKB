---
Title: Как использовать файлы справки?
Date: 01.01.2007
---


Как использовать файлы справки?
===============================

::: {.date}
01.01.2007
:::

Вариант 1:

    { First we need to tell the Application object the name 
      of the Help file and where to locate it. } 
     
    Application.HelpFile := ExtractFilePath(Application.ExeName) + 'YourHelpFile.hlp'; 
     
    { To Show a help file's content tab: } 
    Application.HelpCommand(HELP_CONTENTS, 0); 
    {  To display a specific topic of your help file: } 
    Application.HelpJump('TApplication_HelpJump'); 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------
Вариант 2:

Вот код для трех стандартных пунктов меню \"Help\":

    procedure TForm1.Contents1Click(Sender: TObject);
    begin
      Application.HelpCommand(HELP_CONTENTS, 0);
    end;
     
    procedure TForm1.SearchforHelpOn1Click(Sender: TObject);
    begin
      Application.HelpCommand(HELP_PARTIALKEY, 0);
    end;
     
    procedure TForm1.HowtoUseHelp1Click(Sender: TObject);
    begin
      Application.HelpCommand(HELP_HELPONHELP, 0);
    end;

Взято с <https://delphiworld.narod.ru>
