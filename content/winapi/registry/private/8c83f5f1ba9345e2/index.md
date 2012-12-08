---
Title: Как узнать, откуда была установлена Windows?
Date: 01.01.2007
---

Как узнать, откуда была установлена Windows?
============================================

::: {.date}
01.01.2007
:::

    uses Registry;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
            reg: TRegistry;
    begin
            reg := TRegistry.Create;
            reg.RootKey := HKEY_LOCAL_MACHINE;
            reg.OpenKey('Software\Microsoft\Windows\CurrentVersion\SETUP',false);
            ShowMessage(reg.ReadString('SourcePath'));
            reg.CloseKey;
            reg.free;
    end;

Взято из

DELPHI VCL FAQ Перевод с английского      

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)
