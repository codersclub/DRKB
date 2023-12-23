---
Title: Какой язык на данный момент на клавиатуре?
Author: Mikel
Date: 01.01.2007
---

Какой язык на данный момент на клавиатуре?
==========================================

::: {.date}
01.01.2007
:::

Используй GetKeyboardLayoutName

Автор: Mikel

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    var

     
    Form1: TForm1;
    LAYOUT: String;
    implementation
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      RA: Array[0..$FFF] of Char;
    begin
    GetKeyboardLayoutName(RA) ;
    Layout := StrPas(RA);
    if Layout = '00000419' then 
      showmessage(' CCCP ' ) 
    else
      if Layout = '00000409' then 
        showmessage(' USA ' )
      else 
        showmessage(' X 3 ' ) ;
    end; 

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    function WhichLanguage:string; 
    var 
    ID:LangID; 
    Language: array [0..100] of char; 
    begin 
    ID:=GetSystemDefaultLangID; 
    VerLanguageName(ID,Language,100); 
    Result:=String(Language); 
    end; 

Пример вызова этой функции:

    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Edit1.Text:=WhichLanguage; 
    end;

Также, для определения активного языка можно воспользоваться функцией
GetUserDefaultLangID.

Взято из <https://forum.sources.ru>
