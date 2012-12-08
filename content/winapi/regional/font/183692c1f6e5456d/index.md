---
Title: Получение имени шрифта, зная имя файла шрифта
Author: p0s0l
Date: 01.01.2007
---

Получение имени шрифта, зная имя файла шрифта
=============================================

::: {.date}
01.01.2007
:::

function GetFontResourceInfoW (FontPath : PWideChar; var BufSize :
DWORD; FontName : PWideChar; dwFlags : DWORD) : DWORD; stdcall; external
\'GDI32.DLL\';

1-ый параметр - указатель на Wide-строку, содержащую путь к файлу
шрифта;

2-ой параметр - указатель на DWORD-переменную, содержащую размер
выходного буфера. После выполнения функции в этой переменной будет
содержаться необходимая длина буфера;

3-ий параметр - указатель на буфер, в случае успешного выполнения будет
содержать Wide-строку имени шрифта;

4-ый параметр - какие-то флаги, если рыться в функции
GetFontResourceInfoW особым случаем является когда dwFlags=4, но зачем
это, я так и не понял - в результате будет возвращен тот же путь к
файлу; ну а для получения имени шрифта флаг должен быть равен 1.

    function GetFontName (FontFileA : PChar) : String;

     
    type
      TGetFontResourceInfoW = function (FontPath : PWideChar; var BufSize : DWORD; FontName : PWideChar; dwFlags : DWORD) : DWORD; stdcall;
    var
      GetFontResourceInfoW : TGetFontResourceInfoW;
      FontFileW : PWideChar;
      FontNameW : PWideChar;
      FontFileWSize, FontNameSize : DWORD;
     
    begin
      Result := '';
      GetFontResourceInfoW := GetProcAddress(GetModuleHandle('gdi32.dll'), 'GetFontResourceInfoW');
      if @GetFontResourceInfoW = nil then Exit;
      if AddFontResource(FontFileA) = 0 then Exit;
     
      FontFileWSize := (Length(FontFileA)+1)*2;
      GetMem(FontFileW, FontFileWSize);
      StringToWideChar(FontFileA, FontFileW, FontFileWSize);
     
      FontNameSize := 0;
      FontNameW := nil;
      GetFontResourceInfoW (FontFileW, FontNameSize, FontNameW, 1);
      GetMem (FontNameW, FontNameSize);
      FontNameW^ := #0; // на случай какого-нибудь облома
      GetFontResourceInfoW (FontFileW, FontNameSize, FontNameW, 1);
     
      Result := FontNameW;
      FreeMem (FontFileW);
      FreeMem (FontNameW);
     
      RemoveFontResource(FontFileA);
    end;

Пример вызова:

 

GetFontName(\'C:\\MyFonts\\FUTURA.TTF\') - возвратит \'FuturaEugenia\'.

PS: Всё бы хорошо, но эта функция хоть и есть в Win9x, только её там
вызывать нельзя - пишет \"This function is only valid in Windows NT
mode.\"\...

FontView в Win9x использует EnumFontFamiliesEx (видимо по предложенному
Vit\'ом и x77 способу)\...

FontView в WinNT использует GetFontResourceInfo (в импорте вообще нет
EnumFontFamiliesEx или других Enum\*)\...

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>
