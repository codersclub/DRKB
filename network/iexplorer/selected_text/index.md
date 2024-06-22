---
Title: Как прочитать выделенный текст из IE?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как прочитать выделенный текст из IE?
=====================================

    uses
      SHDocVw_TLB; // http://www.euromind.com/iedelphi if don't have that unit
     
    function GetSelectedIEtext: string;
    var
      x: Integer;
      Sw: IShellWindows;
      IE: HWND;
    begin
      IE := FindWindow('IEFrame', nil);
      sw := CoShellWindows.Create;
      for x := SW.Count - 1 downto 0 do
        if (Sw.Item(x) as IWebbrowser2).hwnd = IE then begin
          Result := variant(Sw.Item(x)).Document.Selection.createRange.Text;
          break;
        end;
    end;

