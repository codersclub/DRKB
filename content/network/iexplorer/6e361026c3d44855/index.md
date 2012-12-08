---
Title: Как обновить все окна IE?
Date: 01.01.2007
---


Как обновить все окна IE?
=========================

::: {.date}
01.01.2007
:::

    uses
     MSHTML_TLB, SHDocVw_TLB;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     ShellWindow: IShellWindows;
     WB: IWebbrowser2;
     spDisp: IDispatch;
     IDoc1: IHTMLDocument2;
     k: Integer;
    begin
     ShellWindow := CoShellWindows.Create;
     for k := 0 to ShellWindow.Count do
     begin
       spDisp := ShellWindow.Item(k);
       if spDisp = nil then Continue;
       spDisp.QueryInterface(iWebBrowser2, WB);
       if WB <> nil then
       begin
         WB.Document.QueryInterface(IHTMLDocument2, iDoc1);
         if iDoc1 <> nil then
         begin
           WB := ShellWindow.Item(k) as IWebbrowser2;
           WB.Refresh;
         end;
       end;
     end;
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
