---
Title: DDE для вызова диалога поиска файлов и папок
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


DDE для вызова диалога поиска файлов и папок
============================================

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


