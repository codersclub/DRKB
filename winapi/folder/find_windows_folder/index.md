---
Title: Как найти каталог Windows?
Author: Vit
Date: 01.01.2007
---


Как найти каталог Windows?
==========================

Вариант 1:

Author: Vit

    function GetWindowsFolder:string;
     
    var p:PChar;
    begin
      GetMem(p, MAX_PATH);
      result:='';
      if GetWindowsDirectory(p, MAX_PATH)>0 then
        result:=string(p);
      FreeMem(p);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    public
      { Public declarations }
      Windir: string;
      WindirP: PChar;
      Res: Cardinal;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      WinDirP := StrAlloc(MAX_PATH);
      Res := GetWindowsDirectory(WinDirP, MAX_PATH);
      if Res > 0 then
        WinDir := StrPas(WinDirP);
      Label1.Caption := WinDir;
    end;

