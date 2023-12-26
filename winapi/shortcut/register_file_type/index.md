---
Title: Зарегистрировать новый тип файлов
Date: 01.01.2007
---

Зарегистрировать новый тип файлов
=================================

::: {.date}
01.01.2007
:::

Не хуже M\$ получается! У них свои типы файлов, и у нас будут свои! Всё,
что для этого нужно - точно выполнять последовательность действий и
научиться копировать в буфер, чтобы не писать все те коды, что будут тут
изложены :))

Сначала, естественно, объявляем в uses модуль Registry.

    uses
      Registry;

Затем в публичных объявлениях объявляем процедуру регистрации нового
типа файлов:

    public
      { Public declarations }
      procedure RegisterFileType(ext: string; FileName: string);

Описываем её так:

    procedure TForm1.RegisterFileType(ext: string; FileName: string);
    var
      reg: TRegistry;
    begin
      reg:=TRegistry.Create;
      with reg do
      begin
        RootKey:=HKEY_CLASSES_ROOT;
        OpenKey('.'+ext,True);
        WriteString('',ext+'file');
        CloseKey;
        CreateKey(ext+'file');
        OpenKey(ext+'file\DefaultIcon',True);
        WriteString('',FileName+',0');
        CloseKey;
        OpenKey(ext+'file\shell\open\command',True);
        WriteString('',FileName+' "%1"');
        CloseKey;
        Free;
      end;
    end;

Ну а по нажатию какого-нибудь батона регистрируем!

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      RegisterFileType('DelphiWorld', Application.ExeName);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
