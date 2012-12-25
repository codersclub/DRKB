---
Title: DDE для вызова диалога поиска файлов и папок
Date: 01.01.2007
---


DDE для вызова диалога поиска файлов и папок
============================================

::: {.date}
01.01.2007
:::

    uses DdeMan;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      with TDDEClientConv.Create(Self) do
      begin
        ConnectMode := ddeManual;
        ServiceApplication := 'explorer.exe';
        SetLink( 'Folders', 'AppProperties');
        OpenLink;
        ExecuteMacro('[FindFolder(, C:\Мои документы)]', False);
        CloseLink;
        Free;
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
